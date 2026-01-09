<?php

class TicketRepository extends BaseRepository
{
    public function find(int $id): ?Ticket
    {
        $query = "SELECT * FROM tickets WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Ticket(
            $row['id'],
            $row['user_id'],
            $row['match_id'],
            $row['seat_id'],
            (float)$row['price_paid'],
            $row['qr_code'],
            $row['status'],
            $row['purchase_time']
        ) : null;
    }

    public function findDetails(int $id): ?TicketDetailsDTO
    {
        $query = "
        SELECT
            t.id AS ticket_id,
            t.user_id,
            t.price_paid,
            t.status,
            t.purchase_time,
            t.qr_code,
            t.seat_id,
            m.match_datetime,
            ht.name AS home_team_name,
            at.name AS away_team_name,
            sc.name AS category_name
        FROM tickets t
        JOIN matches m ON t.match_id = m.id
        JOIN teams ht ON m.home_team_id = ht.id
        JOIN teams at ON m.away_team_id = at.id
        LEFT JOIN seats s ON t.seat_id = s.id
        LEFT JOIN seat_categories sc ON s.category_id = sc.id
        WHERE t.id = :id
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new TicketDetailsDTO(
            $row['ticket_id'],
            $row['user_id'],
            (float)$row['price_paid'],
            $row['status'],
            $row['purchase_time'],
            $row['qr_code'],
            $row['seat_id'],
            $row['home_team_name'],
            $row['away_team_name'],
            $row['match_datetime'],
            $row['category_name']
        ) : null;
    }


    public function findByUserId(int $userId): array
    {
        $query = "SELECT t.*, m.match_datetime, ht.name as home_team_name, at.name as away_team_name, sc.name as category_name
                  FROM tickets t
                  JOIN matches m ON t.match_id = m.id
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  LEFT JOIN seats s ON t.seat_id = s.id
                  LEFT JOIN seat_categories sc ON s.category_id = sc.id
                  WHERE t.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tickets = [];
        foreach ($rows as $row) {
            $tickets[] = new TicketDetailsDTO(
                (int)$row['id'],
                (int)$row['user_id'],
                (float)$row['price_paid'],
                $row['status'],
                $row['purchase_time'] ?? '',
                $row['qr_code'],
                isset($row['seat_id']) ? (int)$row['seat_id'] : null,
                $row['home_team_name'],
                $row['away_team_name'],
                $row['match_datetime'],
                $row['category_name'] ?? null
            );
        }
        return $tickets;
    }

    public function countByUserMatch(int $userId, int $matchId): int
    {
        $query = "SELECT COUNT(*) FROM tickets WHERE user_id = :user_id AND match_id = :match_id AND status != 'CANCELLED'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function create(array $data): int|bool
    {
        $query = "INSERT INTO tickets (user_id, match_id, seat_id, price_paid, qr_code, status) 
                  VALUES (:user_id, :match_id, :seat_id, :price_paid, :qr_code, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':match_id', $data['match_id']);
        $stmt->bindParam(':seat_id', $data['seat_id']);
        $stmt->bindParam(':price_paid', $data['price_paid']);
        $stmt->bindParam(':qr_code', $data['qr_code']);
        $stmt->bindParam(':status', $data['status']);

        if ($stmt->execute()) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }
}

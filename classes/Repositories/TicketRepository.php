<?php

class TicketRepository extends BaseRepository
{
    public function find(int $id): ?Ticket
    {
        $query = "SELECT t.*, m.match_datetime, ht.name as home_team_name, at.name as away_team_name 
                  FROM tickets t
                  JOIN matches m ON t.match_id = m.id
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  WHERE t.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Ticket(
            $row['id'],
            $row['user_id'],
            $row['match_id'] ?? null,
            $row['seat_id'] ?? null,
            (float)($row['price_paid'] ?? 0.0),
            $row['qr_code'] ?? null,
            $row['status'] ?? 'VALID',
            $row['purchase_time'] ?? null,
            $row['home_team_name'] ?? null,
            $row['away_team_name'] ?? null,
            $row['match_datetime'] ?? null
        ) : null;
    }

    public function findByUserId(int $userId): array
    {
        $query = "SELECT t.*, m.match_datetime, ht.name as home_team_name, at.name as away_team_name 
                  FROM tickets t
                  JOIN matches m ON t.match_id = m.id
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  WHERE t.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tickets = [];
        foreach ($rows as $row) {
            $tickets[] = new Ticket(
                $row['id'],
                $row['user_id'],
                $row['match_id'],
                $row['seat_id'] ?? null,
                (float)$row['price_paid'],
                $row['qr_code'],
                $row['status'],
                $row['purchase_time'] ?? null,
                $row['home_team_name'],
                $row['away_team_name'],
                $row['match_datetime']
            );
        }
        return $tickets;
    }

    public function create(array $data): bool
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
        return $stmt->execute();
    }
}

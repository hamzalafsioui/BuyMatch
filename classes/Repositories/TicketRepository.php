<?php

class TicketRepository extends BaseRepository
{
    public function find(int $id): ?Ticket
    {
        $query = "SELECT * FROM tickets WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Ticket(
            $data['id'],
            $data['user_id'],
            $data['match_id'],
            $data['seat_id'],
            $data['price_paid'],
            $data['qr_code'],
            $data['status'],
            $data['purchase_time']
        ) : null;
    }

    public function findByUserId(int $userId): array
    {
        $query = "SELECT t.*, m.match_datetime, ht.name as home_team, at.name as away_team 
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
                $row['price_paid'],
                $row['qr_code'],
                $row['status'],
                $row['purchase_time'] ?? null
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

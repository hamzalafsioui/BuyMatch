<?php

class SeatRepository extends BaseRepository
{
    public function findByMatchAndNumber(int $matchId, string $seatNumber): ?Seat
    {
        $query = "SELECT * FROM seats WHERE match_id = :match_id AND seat_number = :seat_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->bindParam(':seat_number', $seatNumber);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Seat::fromDatabase($row) : null;
    }

    public function create(array $data): int
    {
        $query = "INSERT INTO seats (match_id, category_id, seat_number) VALUES (:match_id, :category_id, :seat_number)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $data['match_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':seat_number', $data['seat_number']);
        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function isAvailable(int $matchId, int $seatId): bool
    {
        $query = "SELECT COUNT(*) FROM tickets WHERE match_id = :match_id AND seat_id = :seat_id AND status != 'CANCELLED'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->bindParam(':seat_id', $seatId);
        $stmt->execute();
        return (int)$stmt->fetchColumn() === 0;
    }
    
    public function  countByMatchId($matchId)
    {

        $query = "SELECT COUNT(*) AS total_places FROM seats WHERE match_id = :match_id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}

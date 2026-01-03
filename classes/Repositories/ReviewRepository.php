<?php

class ReviewRepository extends BaseRepository
{
    public function findByMatchId(int $matchId): array
    {
        $query = "SELECT r.*, u.firstname, u.lastname 
                  FROM reviews r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.match_id = :match_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $reviews = [];
        foreach ($rows as $row) {
            $reviews[] = new Review(
                $row['id'],
                $row['user_id'],
                $row['match_id'],
                $row['rating'],
                $row['comment'],
                $row['created_at']
            );
        }
        return $reviews;
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO reviews (user_id, match_id, rating, comment) 
                  VALUES (:user_id, :match_id, :rating, :comment)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':match_id', $data['match_id']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':comment', $data['comment']);
        return $stmt->execute();
    }
}

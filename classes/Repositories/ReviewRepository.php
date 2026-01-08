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
            $reviews[] = new ReviewDetailsDTO(
                (int)$row['id'],
                (int)$row['user_id'],
                (int)$row['match_id'],
                (int)$row['rating'],
                $row['comment'],
                $row['created_at'],
                $row['firstname'],
                $row['lastname']
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

    public function getAllForAdmin(): array
    {
        $query = "SELECT r.*, u.firstname, u.lastname, ht.name as home_team, at.name as away_team
                  FROM reviews r 
                  JOIN users u ON r.user_id = u.id 
                  JOIN matches m ON r.match_id = m.id
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  ORDER BY r.created_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM reviews WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

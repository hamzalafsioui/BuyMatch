<?php

class SeatCategoryRepository extends BaseRepository
{
    public function create(array $data): bool
    {
        $query = "INSERT INTO seat_categories (match_id, name, price) VALUES (:match_id, :name, :price)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':match_id', $data['match_id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price']);
        return $stmt->execute();
    }

    public function findByMatchId(int $matchId): array
    {
        $query = "SELECT * FROM seat_categories WHERE match_id = :match_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($rows as $row) {
            $categories[] = SeatCategory::fromDatabase($row);
        }
        return $categories;
    }

    public function find(int $id): ?SeatCategory
    {
        $query = "SELECT * FROM seat_categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? SeatCategory::fromDatabase($row) : null;
    }

    public function deleteByMatchId(int $matchId): bool
    {
        $query = "DELETE FROM seat_categories WHERE match_id = :match_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':match_id', $matchId);
        return $stmt->execute();
    }

    public function update(int $id, array $data): bool
    {
        $query = "UPDATE seat_categories SET name = :name, price = :price WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price']);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM seat_categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

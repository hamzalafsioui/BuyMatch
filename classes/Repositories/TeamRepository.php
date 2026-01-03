<?php

class TeamRepository extends BaseRepository
{
    public function find(int $id): ?Team
    {
        $query = "SELECT * FROM teams WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Team(
            $data['id'],
            $data['name'],
            $data['logo']
        ) : null;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM teams";
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $teams = [];
        foreach ($rows as $row) {
            $teams[] = new Team(
                $row['id'],
                $row['name'],
                $row['logo']
            );
        }
        return $teams;
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO teams (name, logo) VALUES (:name, :logo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':logo', $data['logo']);
        return $stmt->execute();
    }
}

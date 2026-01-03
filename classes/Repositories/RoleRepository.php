<?php

class RoleRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = "SELECT * FROM roles";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByName(string $name): ?array
    {
        $query = "SELECT * FROM roles WHERE name = :name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }
}

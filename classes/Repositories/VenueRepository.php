<?php

class VenueRepository extends BaseRepository
{
    public function find(int $id): ?Venue
    {
        $query = "SELECT * FROM venues WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Venue(
            $data['id'],
            $data['name'],
            $data['city'],
            $data['address'],
            $data['capacity']
        ) : null;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM venues";
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $venues = [];
        foreach ($rows as $row) {
            $venues[] = new Venue(
                $row['id'],
                $row['name'],
                $row['city'],
                $row['address'],
                $row['capacity']
            );
        }
        return $venues;
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO venues (name, city, address, capacity) VALUES (:name, :city, :address, :capacity)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':capacity', $data['capacity']);
        return $stmt->execute();
    }
}

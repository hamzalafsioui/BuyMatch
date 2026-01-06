<?php

class MatchRepository extends BaseRepository
{
    public function find(int $id): ?MatchEntity
    {
        $query = "SELECT * FROM matches WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new MatchEntity(
            (int)$data['id'],
            (int)$data['organizer_id'],
            (int)$data['home_team_id'],
            (int)$data['away_team_id'],
            (int)$data['venue_id'],
            $data['match_datetime'],
            (int)($data['duration_min'] ?? 90),
            (int)$data['total_seats'],
            (float)($data['ticket_price'] ?? 0),
            $data['status'] ?? 'DRAFT',
            $data['request_status'] ?? 'PENDING',
            (float)($data['avg_rating'] ?? 0),
            $data['created_at']
        ) : null;
    }

    public function getAllPublished(): array
    {
        $query = "SELECT m.*, ht.name as home_team_name, ht.logo as home_team_logo, 
                         at.name as away_team_name, at.logo as away_team_logo,
                         v.name as venue_name, v.city as venue_city
                  FROM matches m
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  JOIN venues v ON m.venue_id = v.id
                  WHERE m.status = 'PUBLISHED' AND m.request_status = 'APPROVED'
                  ORDER BY m.match_datetime ASC";
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $matches = [];
        foreach ($rows as $row) {
            $matches[] = new MatchDetailsDTO(
                (int)$row['id'],
                $row['home_team_name'],
                $row['home_team_logo'] ?? '',
                $row['away_team_name'],
                $row['away_team_logo'] ?? '',
                $row['venue_name'],
                $row['venue_city'],
                $row['match_datetime'],
                $row['status']
            );
        }
        return $matches;
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO matches (organizer_id, home_team_id, away_team_id, venue_id, match_datetime, duration_min, total_seats, ticket_price, status, request_status) 
                  VALUES (:organizer_id, :home_team_id, :away_team_id, :venue_id, :match_datetime, :duration_min, :total_seats, :ticket_price, :status, :request_status)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizer_id', $data['organizer_id']);
        $stmt->bindParam(':home_team_id', $data['home_team_id']);
        $stmt->bindParam(':away_team_id', $data['away_team_id']);
        $stmt->bindParam(':venue_id', $data['venue_id']);
        $stmt->bindParam(':match_datetime', $data['match_datetime']);
        $stmt->bindParam(':duration_min', $data['duration_min']);
        $stmt->bindParam(':total_seats', $data['total_seats']);
        $stmt->bindParam(':ticket_price', $data['ticket_price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':request_status', $data['request_status']);

        return $stmt->execute();
    }

    public function findByOrganizer(int $organizerId): array
    {
        $query = "SELECT m.*, ht.name as home_team_name, ht.logo as home_team_logo, at.name as away_team_name, at.logo as away_team_logo, v.name as venue_name, v.city as venue_city
                  FROM matches m
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  JOIN venues v ON m.venue_id = v.id
                  WHERE m.organizer_id = :organizer_id
                  
                  ORDER BY m.match_datetime DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $matches = [];
        foreach ($rows as $row) {
            $matches[] = new MatchDetailsDTO(
                (int)$row['id'],
                $row['home_team_name'],
                $row['home_team_logo'],
                $row['away_team_name'],
                $row['away_team_logo'],
                $row['venue_name'],
                $row['venue_city'],
                $row['match_datetime'],
                $row['status']
            );
        }
        return $matches;
    }

    public function getStats(int $organizerId): array
    {
        $stats = [
            'total_matches' => 0,
            'upcoming_matches' => 0,
            'total_seats_sold' => 0
        ];

        // Total Matches
        $query = "SELECT COUNT(*) FROM matches WHERE organizer_id = :organizer_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        $stats['total_matches'] = $stmt->fetchColumn();

        // Upcoming Matches
        $query = "SELECT COUNT(*) FROM matches WHERE organizer_id = :organizer_id AND match_datetime > NOW()";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        $stats['upcoming_matches'] = $stmt->fetchColumn();

        // total seats sold
        $query = "SELECT COUNT(*) FROM tickets t 
        JOIN matches m ON m.id = t.match_id 
         WHERE m.organizer_id = :organizer_id AND t.status IN('VALID','USED')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        $stats['total_seats_sold'] = $stmt->fetchColumn();

        return $stats;
    }

    public function update(int $id, array $data): bool
    {
        $query = "UPDATE matches 
                  SET home_team_id = :home_team_id, 
                      away_team_id = :away_team_id, 
                      venue_id = :venue_id, 
                      match_datetime = :match_datetime, 
                      duration_min = :duration_min, 
                      total_seats = :total_seats, 
                      ticket_price = :ticket_price,
                      status = :status 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':home_team_id', $data['home_team_id']);
        $stmt->bindParam(':away_team_id', $data['away_team_id']);
        $stmt->bindParam(':venue_id', $data['venue_id']);
        $stmt->bindParam(':match_datetime', $data['match_datetime']);
        $stmt->bindParam(':duration_min', $data['duration_min']);
        $stmt->bindParam(':total_seats', $data['total_seats']);
        $stmt->bindParam(':ticket_price', $data['ticket_price']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM matches WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllRequests(): array
    {
        $query = "SELECT m.*, ht.name as home_team_name, ht.logo as home_team_logo, 
                         at.name as away_team_name, at.logo as away_team_logo,
                         v.name as venue_name, v.city as venue_city,
                         u.firstname, u.lastname
                  FROM matches m
                  JOIN teams ht ON m.home_team_id = ht.id
                  JOIN teams at ON m.away_team_id = at.id
                  JOIN venues v ON m.venue_id = v.id
                  JOIN users u ON m.organizer_id = u.id
                  WHERE m.request_status = 'PENDING'
                  ORDER BY m.created_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}

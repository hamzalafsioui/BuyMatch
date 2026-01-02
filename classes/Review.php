<?php

class Review
{
    private $id;
    private $userId;
    private $matchId;
    private $rating;
    private $comment;
    private $createdAt;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['user_id'] ?? null;
        $this->matchId = $data['match_id'] ?? null;
        $this->rating = $data['rating'] ?? 0;
        $this->comment = $data['comment'] ?? '';
        $this->createdAt = $data['created_at'] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getMatchId()
    {
        return $this->matchId;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

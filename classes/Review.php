<?php

class Review
{
    private $id;
    private $userId;
    private $matchId;
    private $rating;
    private $comment;
    private $createdAt;

    public function __construct(
        ?int $id = null,
        ?int $userId = null,
        ?int $matchId = null,
        int $rating = 0,
        string $comment = '',
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->matchId = $matchId;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->createdAt = $createdAt;
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

<?php

class ReviewDetailsDTO
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $matchId,
        public int $rating,
        public string $comment,
        public string $createdAt,
        public string $firstname,
        public string $lastname
    ) {}
}

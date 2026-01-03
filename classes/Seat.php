<?php

class Seat
{
    private $id;
    private $matchId;
    private $categoryId;
    private $seatNumber;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->matchId = $data['match_id'] ?? null;
        $this->categoryId = $data['category_id'] ?? null;
        $this->seatNumber = $data['seat_number'] ?? '';
    }

    public function getId()
    {
        return $this->id;
    }
    public function getMatchId()
    {
        return $this->matchId;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function getSeatNumber()
    {
        return $this->seatNumber;
    }
}

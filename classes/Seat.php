<?php

class Seat
{
    private ?int $id;
    private int $matchId;
    private int $categoryId;
    private string $seatNumber;

    public function __construct(
        ?int $id,
        int $matchId,
        int $categoryId,
        string $seatNumber
    ) {
        $this->id = $id;
        $this->matchId = $matchId;
        $this->categoryId = $categoryId;
        $this->seatNumber = $seatNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchId(): int
    {
        return $this->matchId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getSeatNumber(): string
    {
        return $this->seatNumber;
    }
}

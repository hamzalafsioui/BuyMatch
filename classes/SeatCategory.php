<?php

class SeatCategory
{
    private ?int $id;
    private int $matchId;
    private string $name;
    private float $price;

    public function __construct(
        ?int $id,
        int $matchId,
        string $name,
        float $price
    ) {
        $this->id = $id;
        $this->matchId = $matchId;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchId(): int
    {
        return $this->matchId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // fromDatabase for => DB hydration
    public static function fromDatabase(array $row): self
    {
        return new self(
            isset($row['id']) ? (int)$row['id'] : null,
            (int)$row['match_id'],
            $row['name'],
            (float)$row['price']
        );
    }
}

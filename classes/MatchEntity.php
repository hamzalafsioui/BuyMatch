<?php

class MatchEntity
{
    private $id;
    private $organizerId;
    private $homeTeamId;
    private $awayTeamId;
    private $venueId;
    private $matchDatetime;
    private $durationMin;
    private $totalSeats;
    private $ticketPrice;
    private $status;
    private $requestStatus;
    private $avgRating;
    private $createdAt;

    public function __construct(
        ?int $id = null,
        ?int $organizerId = null,
        ?int $homeTeamId = null,
        ?int $awayTeamId = null,
        ?int $venueId = null,
        ?string $matchDatetime = null,
        int $durationMin = 90,
        ?int $totalSeats = null,
        float $ticketPrice = 0,
        string $status = 'DRAFT',
        string $requestStatus = 'PENDING',
        float $avgRating = 0,
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->organizerId = $organizerId;
        $this->homeTeamId = $homeTeamId;
        $this->awayTeamId = $awayTeamId;
        $this->venueId = $venueId;
        $this->matchDatetime = $matchDatetime;
        $this->durationMin = $durationMin;
        $this->totalSeats = $totalSeats;
        $this->ticketPrice = $ticketPrice;
        $this->status = $status;
        $this->requestStatus = $requestStatus;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getOrganizerId()
    {
        return $this->organizerId;
    }
    public function getHomeTeamId()
    {
        return $this->homeTeamId;
    }
    public function getAwayTeamId()
    {
        return $this->awayTeamId;
    }
    public function getVenueId()
    {
        return $this->venueId;
    }
    public function getMatchDatetime()
    {
        return $this->matchDatetime;
    }
    public function getDurationMin()
    {
        return $this->durationMin;
    }
    public function getTotalSeats()
    {
        return $this->totalSeats;
    }
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getRequestStatus()
    {
        return $this->requestStatus;
    }
    public function getAvgRating()
    {
        return $this->avgRating;
    }

    public function publish()
    {
        $this->status = 'PUBLISHED';
    }
    public function finish()
    {
        $this->status = 'FINISHED';
    }
}

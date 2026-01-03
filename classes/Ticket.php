<?php

class Ticket
{
    private $id;
    private $userId;
    private $matchId;
    private $seatId;
    private $pricePaid;
    private $qrCode;
    private $status;
    private $purchaseTime;

    public function __construct(
        ?int $id = null,
        ?int $userId = null,
        ?int $matchId = null,
        ?int $seatId = null,
        float $pricePaid = 0.0,
        ?string $qrCode = null,
        string $status = 'VALID',
        ?string $purchaseTime = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->matchId = $matchId;
        $this->seatId = $seatId;
        $this->pricePaid = $pricePaid;
        $this->qrCode = $qrCode;
        $this->status = $status;
        $this->purchaseTime = $purchaseTime;
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
    public function getSeatId()
    {
        return $this->seatId;
    }
    public function getPricePaid()
    {
        return $this->pricePaid;
    }
    public function getQrCode()
    {
        return $this->qrCode;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getPurchaseTime()
    {
        return $this->purchaseTime;
    }
}

<?php
class TicketDetailsDTO
{
    public function __construct(
        public int $ticketId,
        public int $userId,
        public float $pricePaid,
        public string $status,
        public string $purchaseTime,
        public string $qrCode,
        public ?int $seatId,
        public string $homeTeamName,
        public string $awayTeamName,
        public string $matchDatetime,
        public ?string $categoryName
    ) {}
}

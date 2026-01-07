<?php

class MatchDetailsDTO
{

    public function __construct(
        public int $matchId,
        public string $homeTeamName,
        public string $homeTeamLogo,
        public string $awayTeamName,
        public string $awayTeamLogo,
        public string $venueName,
        public string $venueCity,
        public string $matchDatetime,
        public string $status,
        public string $requestStatus
    ) {}
}

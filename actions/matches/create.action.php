<?php
require_once __DIR__ . '/../../config/App.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!Auth::isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Check if POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get user id and check is organizer
$userId = $_SESSION['user_id'];
$currentUser = Auth::getCurrentUser();

if (!$currentUser || $currentUser->getRoleId() != 2) {
    echo json_encode(['success' => false, 'message' => 'Access denied. Organizers only.']);
    exit;
}

// Validate input
$homeTeamId = $_POST['home_team_id'] ?? null;
$awayTeamId = $_POST['away_team_id'] ?? null;
$venueId = $_POST['venue_id'] ?? null;
$matchDate = $_POST['match_date'] ?? null;
// $price = $_POST['price'] ?? 0; 
$totalSeats = $_POST['total_seats'] ?? null;
$durationMin = $_POST['duration_min'] ?? 90;
$catNames = $_POST['category_names'] ?? [];
$catPrices = $_POST['category_prices'] ?? [];

if (!$homeTeamId || !$awayTeamId || !$venueId || !$matchDate || !$totalSeats || empty($catNames)) {
    echo json_encode(['success' => false, 'message' => 'All fields including at least one category are required']);
    exit;
}

if ($homeTeamId == $awayTeamId) {
    echo json_encode(['success' => false, 'message' => 'Home and Away teams must be different']);
    exit;
}

// Create MatchRepo
$matchRepo = new MatchRepository();

$data = [
    'organizer_id' => $userId,
    'home_team_id' => $homeTeamId,
    'away_team_id' => $awayTeamId,
    'venue_id' => $venueId,
    'match_datetime' => $matchDate,
    'duration_min' => $durationMin,
    'total_seats' => $totalSeats,
    'ticket_price' => $catPrices[0] ?? 0,
    'status' => 'DRAFT',
    'request_status' => 'PENDING'
];

try {
    if ($matchRepo->create($data)) {
        $matchId = $matchRepo->getLastInsertId();
        $catRepo = new SeatCategoryRepository();

        foreach ($catNames as $index => $name) {
            $catRepo->create([
                'match_id' => $matchId,
                'name' => $name,
                'price' => $catPrices[$index]
            ]);
        }

        echo json_encode(['success' => true, 'message' => 'Match created successfully', 'redirect' => BASE_URL . '/pages/organizer/matches/index.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create match']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

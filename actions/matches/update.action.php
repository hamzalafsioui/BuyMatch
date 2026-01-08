<?php
require_once __DIR__ . '/../../config/App.php';

header('Content-Type: application/json');

if (!Auth::isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$currentUser = Auth::getCurrentUser();
if (!$currentUser || $currentUser->getRoleId() != 2) {
    echo json_encode(['success' => false, 'message' => 'Access denied. Organizers only.']);
    exit;
}

$matchId = $_POST['match_id'] ?? null;
if (!$matchId) {
    echo json_encode(['success' => false, 'message' => 'Match ID is required']);
    exit;
}

// Is this Match created by the current organizer
$matchRepo = new MatchRepository();
$match = $matchRepo->find($matchId);

if (!$match || $match->getOrganizerId() != $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Match not found or access denied']);
    exit;
}

if ($match->getStatus() === 'FINISHED') {
    echo json_encode(['success' => false, 'message' => 'Cannot update a match that has already finished']);
    exit;
}

$homeTeamId = $_POST['home_team_id'] ?? null;
$awayTeamId = $_POST['away_team_id'] ?? null;
$venueId = $_POST['venue_id'] ?? null;
$matchDate = $_POST['match_date'] ?? null;
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

$data = [
    'home_team_id' => $homeTeamId,
    'away_team_id' => $awayTeamId,
    'venue_id' => $venueId,
    'match_datetime' => $matchDate,
    'duration_min' => $durationMin,
    'total_seats' => $totalSeats,
    'ticket_price' => $catPrices[0] ?? 0,
    'status' => $match->getStatus()
];

if ($matchRepo->update($matchId, $data)) {
    $catRepo = new SeatCategoryRepository();


    $currentStoredCats = $catRepo->findByMatchId($matchId);
    $currentStoredIds = array_map(fn($c) => (int)$c->getId(), $currentStoredCats);

    $submittedIds = $_POST['category_ids'] ?? [];
    $processedExistingIds = [];

    // Update existing or Create new
    foreach ($catNames as $index => $name) {
        $id = isset($submittedIds[$index]) ? trim($submittedIds[$index]) : 'new';
        $price = $catPrices[$index];

        if ($id !== 'new' && is_numeric($id)) {
            // Update existing
            $catRepo->update((int)$id, ['name' => $name, 'price' => $price]);
            $processedExistingIds[] = (int)$id;
        } else {
            // Create new
            $catRepo->create([
                'match_id' => $matchId,
                'name' => $name,
                'price' => $price
            ]);
        }
    }

    // Delete old categories that were removed in UI
    foreach ($currentStoredIds as $exId) {
        if (!in_array($exId, $processedExistingIds)) {
            try {
                $catRepo->delete($exId);
            } catch (PDOException $e) {
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Match updated successfully', 'redirect' => BASE_URL . '/pages/organizer/matches/index.php']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update match']);
}

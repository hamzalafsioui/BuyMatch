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

// Get raw JSON or POST body
$input = json_decode(file_get_contents('php://input'), true);
$matchId = $input['match_id'] ?? $_POST['match_id'] ?? null;

if (!$matchId) {
    echo json_encode(['success' => false, 'message' => 'Match ID is required']);
    exit;
}


$matchRepo = new MatchRepository();
$match = $matchRepo->find($matchId);

if (!$match || $match->getOrganizerId() != $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Match not found or access denied']);
    exit;
}

// Cannot delete a match that has already finished
if ($match->getStatus() === 'FINISHED') {
    echo json_encode(['success' => false, 'message' => 'Cannot delete a match that has already finished']);
    exit;
}



if ($matchRepo->delete($matchId)) {
    echo json_encode(['success' => true, 'message' => 'Match deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete match']);
}

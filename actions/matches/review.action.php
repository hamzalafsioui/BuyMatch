<?php
require_once '../../config/App.php';

header('Content-Type: application/json');

if (!Auth::isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$matchId = $input['match_id'] ?? null;
$rating = $input['rating'] ?? null;
$comment = $input['comment'] ?? '';

if (!$matchId || !$rating) {
    echo json_encode(['success' => false, 'message' => 'Missing rating or match ID']);
    exit;
}

$reviewRepo = new ReviewRepository();
$matchRepo = new MatchRepository();
$match = $matchRepo->find($matchId);

if (!$match || $match->getStatus() !== 'FINISHED') {
    echo json_encode(['success' => false, 'message' => 'You can only review finished matches']);
    exit;
}

// check if user has a ticket
$ticketRepo = new TicketRepository();
if ($ticketRepo->countByUserMatch($_SESSION['user_id'], $matchId) === 0) {
    echo json_encode(['success' => false, 'message' => 'You can only review matches you attended']);
    exit;
}

$success = $reviewRepo->create([
    'user_id' => $_SESSION['user_id'],
    'match_id' => $matchId,
    'rating' => (int)$rating,
    'comment' => $comment
]);

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save review']);
}
exit;

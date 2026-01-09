<?php
require_once '../../config/App.php';

header('Content-Type: application/json');

$matchId = $_GET['match_id'] ?? null;

if (!$matchId) {
    echo json_encode(['success' => false, 'message' => 'Match ID is required']);
    exit;
}

$reviewRepo = new ReviewRepository();
$ticketRepo = new TicketRepository();

$reviews = $reviewRepo->findByMatchId((int)$matchId);

$currentUserHasTicket = false;
if (Auth::isAuthenticated()) {
    $currentUserHasTicket = $ticketRepo->countByUserMatch($_SESSION['user_id'], (int)$matchId) > 0;
}

// Format reviews for JSON
$formattedReviews = array_map(function ($review) {
    return [
        'id' => $review->id,
        'username' => $review->firstname . ' ' . $review->lastname,
        'rating' => $review->rating,
        'comment' => $review->comment,
        'date' => date('M d, Y', strtotime($review->createdAt))
    ];
}, $reviews);

echo json_encode([
    'success' => true,
    'reviews' => $formattedReviews,
    'can_review' => $currentUserHasTicket,
    'is_logged_in' => Auth::isAuthenticated()
]);
exit;

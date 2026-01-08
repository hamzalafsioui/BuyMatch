<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';

requireRole(2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $matchId = (int)($data['match_id'] ?? 0);

    if (!$matchId) {
        echo json_encode(['success' => false, 'message' => 'Invalid match ID']);
        exit;
    }

    $matchRepo = new MatchRepository();

    
    if ($matchRepo->publishMatch($matchId, $_SESSION['user_id'])) {
        echo json_encode(['success' => true, 'message' => 'Match published successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to publish match. Make sure it is approved by admin.']);
    }
}
exit;

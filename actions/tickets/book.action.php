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

$input = json_decode(file_get_contents('php://input'), true);
$matchId = $input['match_id'] ?? null;
$categoryId = $input['category_id'] ?? null;
$qty = (int)($input['quantity'] ?? 1);
$requestedSeats = $input['seats'] ?? [];

if (!$matchId || !$categoryId || empty($requestedSeats)) {
    echo json_encode(['success' => false, 'message' => 'Missing required booking data']);
    exit;
}

$matchRepo = new MatchRepository();
$match = $matchRepo->find($matchId);
$catRepo = new SeatCategoryRepository();
$category = $catRepo->find($categoryId);
$ticketRepo = new TicketRepository();
$seatRepo = new SeatRepository();

if (!$match || !$category) {
    echo json_encode(['success' => false, 'message' => 'Match or Category not found']);
    exit;
}

// Check ticket limit
$existingCount = $ticketRepo->countByUserMatch($_SESSION['user_id'], $matchId);
if (($existingCount + $qty) > 4) {
    echo json_encode(['success' => false, 'message' => "You can only book up to 4 tickets per match. You already have $existingCount."]);
    exit;
}

//  Booking
$db = Database::getInstance()->getConnection();
$db->beginTransaction();

try {
    foreach ($requestedSeats as $seatNum) {
        $seatNum = trim($seatNum);
        // Find or Create Seat
        $seat = $seatRepo->findByMatchAndNumber((int)$matchId, $seatNum);
        $seatId = null;

        if ($seat) {
            $seatId = $seat->getId();
            // Is available
            if (!$seatRepo->isAvailable((int)$matchId, (int)$seatId)) {
                throw new Exception("Seat $seatNum is already taken.");
            }
        } else {
            // Create the seat record
            $seatId = $seatRepo->create([
                'match_id' => $matchId,
                'category_id' => $categoryId,
                'seat_number' => $seatNum
            ]);
        }

        // Create Ticket
        $ticketData = [
            'user_id' => $_SESSION['user_id'],
            'match_id' => $matchId,
            'seat_id' => $seatId,
            'price_paid' => $category->getPrice(),
            'qr_code' => strtoupper(substr(md5(uniqid($_SESSION['user_id'] . $matchId . $seatId, true)), 0, 12)),
            'status' => 'VALID'
        ];

        if (!$ticketRepo->create($ticketData)) {
            throw new Exception("Failed to create ticket for seat $seatNum");
        }
    }

    $db->commit();

   

    echo json_encode(['success' => true, 'message' => 'Booking successful!']);
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;

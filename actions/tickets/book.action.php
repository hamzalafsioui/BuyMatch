<?php
require_once __DIR__ . '/../../config/App.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Check ticket limit tickets (MAX 4)
$existingCount = $ticketRepo->countByUserMatch($_SESSION['user_id'], $matchId);
if (($existingCount + $qty) > 4) {
    echo json_encode(['success' => false, 'message' => "You can only book up to 4 tickets per match. You already have $existingCount."]);
    exit;
}

// Check Limit places (MAX 2000);
$existingPlaceCount = $seatRepo->countByMatchId($matchId);
if ($existingPlaceCount > 2000) {
    echo json_encode(['success' => false, 'message' =>  "The maximum number of seats for this match (2000) has been reached."]);
    exit;
}

//  Booking
$db = Database::getInstance()->getConnection();
$db->beginTransaction();

try {
    $createdTickets = [];

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

        $ticketId = $ticketRepo->create($ticketData);
        if (!$ticketId) {
            throw new Exception("Failed to create ticket for seat $seatNum");
        }
        $createdTickets[] = $ticketId;
    }


    $db->commit();

    //  Email Sending
    $emailSent = false;
    $userRepo = new UserRepository();
    $user = $userRepo->find($_SESSION['user_id']);
    if ($user) {
        $ticketDtos = [];
        foreach ($createdTickets as $tId) {
            $dto = $ticketRepo->findDetails((int)$tId);
            if ($dto) {
                $ticketDtos[] = $dto;
            }
        }
        $emailSent = MailService::sendTicket($user, $ticketDtos);
    }

    echo json_encode(['success' => true, 'message' => 'Booking successful!', "emailSent" => $emailSent]);
} catch (Exception $e) {
    $db->rollBack();
    Logger::log($e->getMessage(), "ERROR");
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;

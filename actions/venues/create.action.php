<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';

header('Content-Type: application/json');

// Only Organizers and Admins can create venues
if (!Auth::isAuthenticated() || !in_array(Auth::getCurrentUser()->getRoleId(), [2, 3])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$city = trim($_POST['city'] ?? '');
$address = trim($_POST['address'] ?? '');
$capacity = intval($_POST['capacity'] ?? 0);

if (empty($name) || empty($city) || empty($address) || $capacity <= 0) {
    echo json_encode(['success' => false, 'message' => 'All fields are required and capacity must be positive']);
    exit;
}

$venueRepo = new VenueRepository();
$success = $venueRepo->create([
    'name' => $name,
    'city' => $city,
    'address' => $address,
    'capacity' => $capacity
]);

if ($success) {
    echo json_encode([
        'success' => true,
        'message' => 'Venue created successfully',
        'redirect' => BASE_URL . '/pages/organizer/venues/index.php'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create venue']);
}

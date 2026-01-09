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

// Get user id and check is organizer or admin
$currentUser = Auth::getCurrentUser();
if (!$currentUser || !in_array($currentUser->getRoleId(), [2, 3])) {
    echo json_encode(['success' => false, 'message' => 'Access denied. Organizers and Admins only.']);
    exit;
}

// Validate input
$name = $_POST['name'] ?? null;
if (!$name) {
    echo json_encode(['success' => false, 'message' => 'Team name is required']);
    exit;
}

// Handle logo upload
$logo = null;
if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $logo = Utility::handleUpload($_FILES['logo'], 'assets/img/teams');
    if (!$logo) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload logo or invalid file type']);
        exit;
    }
}

// Create TeamRepo
$teamRepo = new TeamRepository();

$data = [
    'name' => $name,
    'logo' => $logo
];

try {
    if ($teamRepo->create($data)) {
        $redirect = ($currentUser->getRoleId() == 3) ? BASE_URL . '/pages/admin/teams/index.php' : BASE_URL . '/pages/organizer/teams/index.php';
        echo json_encode(['success' => true, 'message' => 'Team created successfully', 'redirect' => $redirect]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create team']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

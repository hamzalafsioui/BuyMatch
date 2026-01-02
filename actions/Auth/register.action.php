<?php
require_once __DIR__ . '/../../config/App.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$profileImage = Utility::handleUpload(
    $_FILES['profile_image'] ?? null,
    'assets/img/uploads/profiles/'
);

$companyLogo = Utility::handleUpload(
    $_FILES['company_logo'] ?? null,
    'assets/img/uploads/logos/'
);

$data = [
    'role_id' => ($_POST['role'] ?? '') === 'organizer' ? 2 : 1,
    'firstname' => $_POST['firstname'] ?? '',
    'lastname' => $_POST['lastname'] ?? '',
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? '',
    'phone' => $_POST['phone'] ?? null,
    'img_path' => $profileImage,
    'company_name' => $_POST['company_name'] ?? null,
    'logo' => $companyLogo,
    'bio' => $_POST['bio'] ?? null,
    'is_acceptable' => 0
];

if (
    empty($data['firstname']) ||
    empty($data['lastname']) ||
    empty($data['email']) ||
    empty($data['password'])
) {
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
    exit;
}

if (Auth::register($data)) {
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful',
        'redirect' => BASE_URL . '/pages/auth/login.php'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Registration failed. Email might already be in use.'
    ]);
}

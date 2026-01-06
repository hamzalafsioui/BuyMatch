<?php
require_once __DIR__ . '/../../config/App.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

if (Auth::login($email, $password)) {
    $currentUser = Auth::getCurrentUser();
    $redirect = BASE_URL . '/index.php'; // Default

    // Redirection
    $redirectionPara = $_POST["redirect"] ?? null;
    if (!empty($redirectionPara)) {
        $decodedRedirect = urldecode($redirectionPara);

        // check is starts with BASE_URL or /
        if (str_starts_with($decodedRedirect, 'http') 
            || 
        str_starts_with($decodedRedirect, "/")) {
            $redirect = $decodedRedirect;
        } 
    } else {
        if ($currentUser) {
            if ($currentUser->getRoleId() == 2) { // Organizer
                $redirect = BASE_URL . '/pages/organizer/dashboard.php';
            } elseif ($currentUser->getRoleId() == 3) { // Admin
                $redirect = BASE_URL . '/pages/admin/dashboard.php';
            }
        }
    }


    echo json_encode(['success' => true, 'message' => 'Login successful', 'redirect' => $redirect]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
}

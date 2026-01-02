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
    echo json_encode(['success' => true, 'message' => 'Login successful', 'redirect' => BASE_URL . '/index.php']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
}

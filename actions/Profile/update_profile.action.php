<?php
require_once __DIR__ . '/../../config/App.php';



if (!Auth::isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_SESSION['user_id'];
$userRepo = new UserRepository();
$currentUser = $userRepo->find($userId);

if (!$currentUser) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// catch data
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
if (empty($firstname) || empty($lastname) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Name and Email are required']);
    exit;
}

if (!empty($password)) {
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }
}

// Prepare Update Data
$updateData = [
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'phone' => $phone,
];

// Handle Image Uploads
if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
    $imgPath = Utility::replaceUpload($_FILES['img_path'], 'assets/img/uploads/profiles/',$currentUser->getImgPath());
    if ($imgPath) {
        $updateData['img_path'] = $imgPath; 
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload profile image']);
        exit;
    }
}

if (!empty($password)) {
    $updateData['password'] = $password;
}

// Organizer Specific Fields
if ($currentUser->getRoleId() == 2 && $currentUser instanceof Organizer) {
    $companyName = $_POST['company_name'] ?? '';
    $bio = $_POST['bio'] ?? '';

    if (empty($companyName)) {
        echo json_encode(['success' => false, 'message' => 'Company Name is required']);
        exit;
    }

    $updateData['company_name'] = $companyName;
    $updateData['bio'] = $bio;

    // Organizer Logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logo = Utility::replaceUpload($_FILES['logo'], 'assets/img/uploads/logos/',$currentUser->getImgLogo());
        if ($logo) {
            $updateData['logo'] = $logo;
        }
    }
}

if ($userRepo->update($userId, $updateData)) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}

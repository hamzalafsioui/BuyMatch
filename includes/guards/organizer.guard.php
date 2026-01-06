<?php

require_once __DIR__ . '/../../config/App.php';

$currentUser = Auth::getCurrentUser();

if (!$currentUser || $currentUser->getRoleId() !== 2) {
    header('Location: /pages/auth/login.php');
    exit;
}

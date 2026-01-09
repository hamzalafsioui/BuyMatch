<?php

require_once __DIR__ . '/../../config/App.php';

function requireRole(int ...$roleIds): void
{
    $user = Auth::getCurrentUser();

    if (!$user || !in_array($user->getRoleId(), $roleIds)) {
        header('Location: ' . BASE_URL . '/pages/auth/login.php');
        exit;
    }

    // check for Organizers
    if ($user->getRoleId() == 2) {
        $currentPage = $_SERVER['PHP_SELF'];
        // If not accepted and not already on the pending page
        if (!$user->isAcceptable() && strpos($currentPage, 'pending_approval.php') === false) {
            header('Location: ' . BASE_URL . '/pages/auth/pending_approval.php');
            exit;
        }
    }
}

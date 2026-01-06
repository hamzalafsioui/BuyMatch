<?php

require_once __DIR__ . '/../../config/App.php';

function requireRole(int $roleId): void
{
    $user = Auth::getCurrentUser();

    if (!$user || $user->getRoleId() !== $roleId) {
        header('Location: /pages/auth/login.php');
        exit;
    }
}

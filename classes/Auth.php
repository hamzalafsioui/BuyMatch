<?php

class Auth
{
    public static function login(string $email, string $password): bool
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            if (!$user->getIsActive()) {
                return false;
            }

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role_id'] = $user->getRoleId();
            $_SESSION['user_email'] = $user->getEmail();

            return true;
        }

        return false;
    }

    public static function register(array $data): bool
    {
        $userRepo = new UserRepository();

        // Basic validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($userRepo->findByEmail($data['email'])) {
            return false;
        }

        return $userRepo->create($data);
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function getCurrentUser(): ?User
    {
        if (!self::isAuthenticated()) {
            return null;
        }

        $userRepo = new UserRepository();
        return $userRepo->find($_SESSION['user_id']);
    }

    public static function requireLogin(): void
    {
        if (!self::isAuthenticated()) {
            header('Location: ' . BASE_URL . '/pages/auth/login.php');
            exit;
        }
    }
}

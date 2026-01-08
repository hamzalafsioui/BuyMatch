<?php
require_once __DIR__ . '/../config/App.php';
require_once __DIR__ . '/../includes/guards/role.guard.php';

requireRole(3);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    /* =================== TOGGLE USER STATUS =================== */
    if ($action === 'toggle_user_status') {
        $userId = (int)($_POST['user_id'] ?? 0);
        if ($userId) {
            $userRepo = new UserRepository();
            if ($userRepo->toggleStatus($userId)) {
                header('Location: ' . BASE_URL . '/pages/admin/users.php?msg=Status updated successfully');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/pages/admin/users.php?error=Failed to update status');
                exit;
            }
        }
    }

    /* =================== UPDATE MATCH STATUS =================== */
    elseif ($action === 'update_match_status') {
        $matchId = (int)($_POST['match_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if (!$matchId) {
            die('Invalid match ID');
        }

        if (!in_array($status, ['PUBLISHED', 'APPROVED', 'REJECTED'])) {
            die('Invalid status');
        }

        $matchRepo = new MatchRepository();

        if ($status === 'PUBLISHED') {
            // $matchRepo->updateRequestStatus($matchId, 'APPROVED');
            
            $matchRepo->publishMatchForAdmin($matchId);
        } else {
            
            $matchRepo->updateRequestStatus($matchId, $status);
        }

        header('Location: ' . BASE_URL . '/pages/admin/matches.php?msg=Match status updated');
        exit;
    }

   

    /* =================== TOGGLE ORGANIZER ACCEPTANCE =================== */
    elseif ($action === 'toggle_organizer_acceptance') {
        $userId = (int)($_POST['user_id'] ?? 0);
        if ($userId) {
            $userRepo = new UserRepository();
            if ($userRepo->toggleOrganizerAcceptance($userId)) {
                header('Location: ' . BASE_URL . '/pages/admin/users.php?msg=Organizer acceptance status updated');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/pages/admin/users.php?error=Failed to update organizer status');
                exit;
            }
        }
    }
}

header('Location: ' . BASE_URL);
exit;

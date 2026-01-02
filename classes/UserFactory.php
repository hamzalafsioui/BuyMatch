<?php

class UserFactory
{
    public static function create(array $data): User
    {
        $roleId = $data['role_id'] ?? null;

        
        switch ($roleId) {
            case 2:
                return new Organizer($data);
            case 3:
                return new Admin($data);
            case 1:
            default:
                return new Buyer($data);
        }
    }
}

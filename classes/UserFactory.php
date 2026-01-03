<?php

class UserFactory
{
    public static function create(array $data): User
    {
        $roleId = $data['role_id'] ?? null;
        $id = $data['id'] ?? null;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $phone = $data['phone'] ?? null;
        $imgPath = $data['img_path'] ?? null;
        $isActive = isset($data['is_active']) ? (bool)$data['is_active'] : true;
        $createdAt = $data['created_at'] ?? null;

        $userArgs = [
            $id,
            $roleId,
            $firstname,
            $lastname,
            $email,
            $password,
            $phone,
            $imgPath,
            $isActive,
            $createdAt
        ];

        switch ($roleId) {
            case 2:
                // Organizer 
                $companyName = $data['company_name'] ?? null;
                $logo = $data['logo'] ?? null;
                $bio = $data['bio'] ?? null;
                $isAcceptable = isset($data['is_acceptable']) ? (bool)$data['is_acceptable'] : false;

                return new Organizer(
                    ...array_merge($userArgs, [$companyName, $logo, $bio, $isAcceptable])
                );
            case 3:
                return new Admin(...$userArgs);
            case 1:
            default:
                return new Buyer(...$userArgs);
        }
    }
}

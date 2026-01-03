<?php

class UserRepository extends BaseRepository implements IUserRepository
{
    public function find(int $id): ?User
    {
        $query = "SELECT u.*, o.company_name, o.logo, o.bio, o.is_acceptable 
                  FROM users u 
                  LEFT JOIN organizers o ON u.id = o.user_id 
                  WHERE u.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? UserFactory::create($user) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $query = "SELECT u.*, o.company_name, o.logo, o.bio, o.is_acceptable 
                  FROM users u 
                  LEFT JOIN organizers o ON u.id = o.user_id 
                  WHERE u.email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? UserFactory::create($user) : null;
    }

    public function create(array $data): bool
    {
        try {
            $this->db->beginTransaction();

            $query = "INSERT INTO users (role_id, firstname, lastname, email, password, phone, img_path) 
                      VALUES (:role_id, :firstname, :lastname, :email, :password, :phone, :img_path)";

            $stmt = $this->db->prepare($query);
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt->bindParam(':role_id', $data['role_id']);
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':img_path', $data['img_path']);

            if (!$stmt->execute()) {
                throw new Exception("Error creating user");
            }

            $userId = $this->db->lastInsertId();

            // If user is an organizer (role_id = 2) => insert into organizers table
            if ($data['role_id'] == 2) {
                $queryOrg = "INSERT INTO organizers (user_id, company_name, logo, bio, is_acceptable) 
                             VALUES (:user_id, :company_name, :logo, :bio, :is_acceptable)";
                $stmtOrg = $this->db->prepare($queryOrg);
                $isAcceptable = $data['is_acceptable'] ?? 0;
                $stmtOrg->bindParam(':user_id', $userId);
                $stmtOrg->bindParam(':company_name', $data['company_name']);
                $stmtOrg->bindParam(':logo', $data['logo']);
                $stmtOrg->bindParam(':bio', $data['bio']);
                $stmtOrg->bindParam(':is_acceptable', $isAcceptable, PDO::PARAM_BOOL);

                if (!$stmtOrg->execute()) {
                    throw new Exception("Error creating organizer profile");
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $this->db->beginTransaction();

            // Update users table
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone";

            if (!empty($data['img_path'])) {
                $query .= ", img_path = :img_path";
            }
            if (!empty($data['password'])) {
                $query .= ", password = :password";
            }

            $query .= " WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':id', $id);

            if (!empty($data['img_path'])) {
                $stmt->bindParam(':img_path', $data['img_path']);
            }
            if (!empty($data['password'])) {
                $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $passwordHash);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error updating user");
            }

            // Update organizers table
            if (isset($data['company_name'])) {

                $queryOrg = "UPDATE organizers SET company_name = :company_name, bio = :bio";
                if (!empty($data['logo'])) {
                    $queryOrg .= ", logo = :logo";
                }
                $queryOrg .= " WHERE user_id = :user_id";

                $stmtOrg = $this->db->prepare($queryOrg);
                $stmtOrg->bindParam(':company_name', $data['company_name']);
                $stmtOrg->bindParam(':bio', $data['bio']);
                $stmtOrg->bindParam(':user_id', $id);

                if (!empty($data['logo'])) {
                    $stmtOrg->bindParam(':logo', $data['logo']);
                }

                $stmtOrg->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}

<?php

abstract class User
{
    protected $id;
    protected $roleId;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $phone;
    protected $imgPath;
    protected $isActive;
    protected $createdAt;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->roleId = $data['role_id'] ?? null;
            $this->firstname = $data['firstname'] ?? '';
            $this->lastname = $data['lastname'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->password = $data['password'] ?? '';
            $this->phone = $data['phone'] ?? null;
            $this->imgPath = $data['img_path'] ?? null;
            $this->isActive = $data['is_active'] ?? true;
            $this->createdAt = $data['created_at'] ?? null;
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getRoleId()
    {
        return $this->roleId;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getImgPath()
    {
        return $this->imgPath;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    // Setters
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function setImgPath($imgPath)
    {
        $this->imgPath = $imgPath;
    }
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
}

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

    public function __construct(
        ?int $id = null,
        ?int $roleId = null,
        string $firstname = '',
        string $lastname = '',
        string $email = '',
        string $password = '',
        ?string $phone = null,
        ?string $imgPath = null,
        bool $isActive = true,
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->imgPath = $imgPath;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
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
    public function getPassword()
    {
        return $this->password;
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

    public function isAcceptable(): bool
    {
        return true;
    }
}

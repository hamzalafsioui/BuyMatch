<?php

class Organizer extends User
{
    private $companyName;
    private $logo;
    private $bio;
    private $isAcceptable;

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
        ?string $createdAt = null,
        ?string $companyName = null,
        ?string $logo = null,
        ?string $bio = null,
        bool $isAcceptable = false
    ) {
        parent::__construct(
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
        );
        $this->companyName = $companyName;
        $this->logo = $logo;
        $this->bio = $bio;
        $this->isAcceptable = $isAcceptable;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }
    public function getLogo()
    {
        return $this->logo;
    }
    public function getBio()
    {
        return $this->bio;
    }
    public function isAcceptable()
    {
        return $this->isAcceptable;
    }

    public function setCompanyName($name)
    {
        $this->companyName = $name;
    }
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
    public function setBio($bio)
    {
        $this->bio = $bio;
    }
    public function setIsAcceptable($isAcceptable)
    {
        $this->isAcceptable = $isAcceptable;
    }
}

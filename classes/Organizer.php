<?php

class Organizer extends User
{
    private $companyName;
    private $logo;
    private $bio;
    private $isAcceptable;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->companyName = $data['company_name'] ?? null;
        $this->logo = $data['logo'] ?? null;
        $this->bio = $data['bio'] ?? null;
        $this->isAcceptable = $data['is_acceptable'] ?? false;
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

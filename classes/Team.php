<?php

class Team
{
    private $id;
    private $name;
    private $logo;

    public function __construct(
        ?int $id = null,
        string $name = '',
        ?string $logo = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getLogo()
    {
        return $this->logo;
    }
}

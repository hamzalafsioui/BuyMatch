<?php

class Venue
{
    private $id;
    private $name;
    private $city;
    private $address;
    private $capacity;

    public function __construct(
        ?int $id = null,
        string $name = '',
        string $city = '',
        ?string $address = null,
        ?int $capacity = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->address = $address;
        $this->capacity = $capacity;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getCapacity()
    {
        return $this->capacity;
    }
}

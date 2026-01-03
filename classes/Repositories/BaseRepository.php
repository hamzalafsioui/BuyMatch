<?php

abstract class BaseRepository
{
    protected $db;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function getLastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}

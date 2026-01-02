<?php

interface IUserRepository
{
   
    public function find(int $id): ?array;
    public function findByEmail(string $email): ?array;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
}

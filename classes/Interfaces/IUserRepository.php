<?php

interface IUserRepository
{

    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
}

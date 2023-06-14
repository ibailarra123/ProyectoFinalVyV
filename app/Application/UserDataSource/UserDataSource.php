<?php

namespace App\Application\UserDataSource;

use App\Domain\User;

interface UserDataSource
{
    /**
     * @return bool
     */
    public function addUser(User $user): bool;

    /**
     * @return User[]
     */
    public function getAll(): array;

    /**
     * @return User or null
     */
    public function findById(string $email): ?User;

    /**
     * @return User or null
     */
    public function findByEmail(string $email): ?User;
}

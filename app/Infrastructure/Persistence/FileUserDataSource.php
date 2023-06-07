<?php

namespace App\Infrastructure\Persistence;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Illuminate\Support\Facades\Cache;

class FileUserDataSource implements UserDataSource
{
    public function addUser(User $user): bool
    {
        $users = Cache::get("users");
        $users[$user->getId()] = $user;

        return Cache::forever("users", $users);
    }
    public function getAll(): array
    {
        return Cache::get("users") != null ? Cache::get("users") : array();
    }

    public function findByEmail(string $email): ?User
    {
        $users = Cache::get("users");
        foreach ($users as $user)
        {
            if ($user->getEmail() == $email) return $user;
        }
        return null;
    }

    public function findById(string $id): ?User
    {
        $users = Cache::get("users");

        return  $users != null ? $users[$id] : null;
    }
}

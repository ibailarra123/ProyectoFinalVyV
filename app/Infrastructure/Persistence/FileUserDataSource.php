<?php

namespace App\Infrastructure\Persistence;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Illuminate\Support\Facades\Cache;

class FileUserDataSource implements UserDataSource
{
    private Cache $cache;

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function create(string $userId, string $email): User
    {
        $user = new User(intval($userId), $email);

        $this->addUser($user);

        return $user;
    }

    public function addUser(User $user): bool
    {
        $users = $this->cache::get("users");
        $users[$user->getId()] = $user;

        return $this->cache::forever("users", $users);
    }
    public function getAll(): array
    {
        return $this->cache::get("users") != null ? $this->cache::get("users") : array();
    }

    public function findByEmail(string $email): ?User
    {
        $users = $this->cache::get("users");
        foreach ($users as $user) {
            if ($user->getEmail() == $email) {
                return $user;
            }
        }
        return null;
    }

    public function findById(string $userId): ?User
    {
        $users = $this->cache::get("users");

        return  $users != null && array_key_exists($userId, $users) ? $users[$userId] : null;
    }
}

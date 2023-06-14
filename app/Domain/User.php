<?php

namespace App\Domain;

class User
{
    private int $idUser;
    private string $email;

    public function __construct(int $idUser, string $email)
    {
        $this->idUser = $idUser;
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->idUser;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

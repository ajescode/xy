<?php

namespace Engine;

class Session
{
    const ADMIN_PERMISSION = 1;

    protected $userId = 0;

    protected $login = '';

    protected $userLogged = false;

    protected $isAdmin = false;

    public function __construct(array $user = [])
    {
        if (!empty($user)) {
            $this->userId = $user['id'];
            $this->login = $user['login'];
            if ((int)$user['permission'] === self::ADMIN_PERMISSION) {
                $this->isAdmin = true;
            }
            $this->userLogged = true;
        }

    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function isUserLogged(): bool
    {
        return $this->userLogged;
    }

    public function isUserAdmin(): bool
    {
        return $this->isAdmin;
    }
}
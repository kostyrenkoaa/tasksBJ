<?php
namespace App\services;

use App\entities\User;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionService
{
    const FLASH_ERRORS = 'flashErrors';
    const AUTH_FIELD = 'auth_field';

    protected Session $session;

    public function getSession(): Session
    {
        if (empty($this->session)) {
            $this->session = new Session();
            $this->session->start();
        }

        return $this->session;
    }

    public function setFlashErrors($errors)
    {
        $this->getSession()->set(SessionService::FLASH_ERRORS, $errors);
    }

    public function getFlashErrors()
    {
        $errors = $this->getSession()->get(SessionService::FLASH_ERRORS);
        $this->getSession()->remove(SessionService::FLASH_ERRORS);
        return $errors;
    }

    public function login(User $user)
    {
        $this->getSession()->set(SessionService::AUTH_FIELD, $user);
    }

    public function logout()
    {
        $this->getSession()->remove(SessionService::AUTH_FIELD);
    }

    public function isLogin()
    {
        $user = $this->getSession()->get(SessionService::AUTH_FIELD);
        return !empty($user);
    }
}

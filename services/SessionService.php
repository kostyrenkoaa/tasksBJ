<?php
namespace App\services;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionService
{
    const FLASH_ERRORS = 'flashErrors';

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
}

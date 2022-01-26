<?php
namespace App\services;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionService
{
    protected Session $session;

    public function getSession(): Session
    {
        if (empty($this->session)) {
            $this->session = new Session();
            $this->session->start();
        }

        return $this->session;
    }
}

<?php
namespace App\services;

class Service
{
    public function __construct(
        protected DBService $db,
        protected SessionService $sessionService
    )
    {
    }

    protected function getSession()
    {
        return $this->sessionService->getSession();
    }
}

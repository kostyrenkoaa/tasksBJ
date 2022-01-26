<?php
namespace App\services;

class UserService extends Service
{
    public function getInfo()
    {
        $this->db->userRepository->getAll();
        return [
            'title' => 'Работает)'
        ];
    }
}

<?php
namespace App\services;

use App\dto\CreateTaskDTO;
use App\dto\LoginDTO;
use App\dto\PaginatorDTO;
use App\entities\User;

class AuthService extends Service
{
    public function login(LoginDTO $loginDTO)
    {
        $user = $this->db->userRepository->getUserByLogin($loginDTO->login);
        if (!$this->isSuccessLogin($user, $loginDTO)) {
            return false;
        }

        $this->sessionService->login($user);
        return true;
    }

    protected function isSuccessLogin(User|bool $user, LoginDTO $loginDTO)
    {
        if (empty($user) || empty($user->password)) {
            return false;
        }

        return password_verify($loginDTO->password, $user->password);
    }
}

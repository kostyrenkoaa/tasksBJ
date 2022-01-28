<?php
namespace App\services;

use App\dto\LoginDTO;
use App\entities\User;

class AuthService extends Service
{
    /**
     * Совершает вход пользователя
     *
     * @param LoginDTO $loginDTO
     * @return bool
     */
    public function login(LoginDTO $loginDTO)
    {
        $user = $this->db->UserRepository->getUserByLogin($loginDTO->login);
        if (!$this->isSuccessLogin($user, $loginDTO)) {
            return false;
        }

        $this->sessionService->login($user);
        return true;
    }

    /**
     * Проверяет переданные данные на соответствие пользователю
     *
     * @param User|bool $user
     * @param LoginDTO $loginDTO
     * @return bool
     */
    protected function isSuccessLogin(User|bool $user, LoginDTO $loginDTO)
    {
        if (empty($user) || empty($user->password)) {
            return false;
        }

        return password_verify($loginDTO->password, $user->password);
    }
}

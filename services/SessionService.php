<?php
namespace App\services;

use App\entities\User;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionService
{
    const FLASH_ERRORS = 'flashErrors';
    const FLASH_MSG = 'flashMSG';
    const AUTH_FIELD = 'auth_field';

    protected Session $session;

    /**
     * Возвращает экземпляр сессии
     *
     * @return Session
     */
    public function getSession(): Session
    {
        if (empty($this->session)) {
            $this->session = new Session();
            $this->session->start();
        }

        return $this->session;
    }

    /**
     * Устанавливает ошибки в флеш сообщение
     *
     * @param $errors
     * @return void
     */
    public function setFlashErrors($errors)
    {
        $this->setFlash(SessionService::FLASH_ERRORS, $errors);
    }

    /**
     * Возвращает ошибки из флеш сообщения
     *
     * @return mixed
     */
    public function getFlashErrors()
    {
        return $this->getFlash(SessionService::FLASH_ERRORS);
    }

    /**
     * Устанавливает флеш сообщение
     *
     * @param $msg
     * @return void
     */
    public function setFlashMSG($msg)
    {
        $this->setFlash(SessionService::FLASH_MSG, $msg);
    }

    /**
     * Возвращает флеш сообщение
     *
     * @return mixed
     */
    public function getFlashMSG()
    {
        return $this->getFlash(SessionService::FLASH_MSG);
    }

    /**
     * Сохраняет данные пользователя в сессию
     *
     * @param User $user
     * @return void
     */
    public function login(User $user)
    {
        $this->getSession()->set(SessionService::AUTH_FIELD, $user);
    }

    /**
     * Удалят данные пользователя из сессии
     *
     * @return void
     */
    public function logout()
    {
        $this->getSession()->remove(SessionService::AUTH_FIELD);
    }

    /**
     * Проверяет авторизован ли пользователь
     *
     * @return bool
     */
    public function isLogin()
    {
        $user = $this->getSession()->get(SessionService::AUTH_FIELD);
        return !empty($user);
    }

    /**
     * Устанавливает данные в сессию с указанным ключом
     *
     * @param $key
     * @param $value
     * @return void
     */
    protected function setFlash($key, $value)
    {
        $this->getSession()->set($key, $value);
    }

    /**
     * Возвращает данные из сессии с указанным ключом и удаляет их из нее
     *
     * @param $key
     * @return mixed
     */
    protected function getFlash($key)
    {
        $value = $this->getSession()->get($key);
        $this->getSession()->remove($key);
        return $value;
    }
}

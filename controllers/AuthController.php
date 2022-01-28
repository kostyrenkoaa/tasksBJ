<?php

namespace App\controllers;

use App\forms\LoginForm;
use App\services\AuthService;
use App\services\SessionService;
use App\services\TwigRenderService;

class AuthController extends Controller
{
    /**
     * Форма для авторизации пользователя
     *
     * @param TwigRenderService $renderService
     * @param SessionService $sessionService
     * @return string
     */
    public function indexAction(
        TwigRenderService $renderService,
        SessionService    $sessionService

    ): string
    {
        if ($sessionService->isLogin()) {
            $this->redirect();
        }
        return $renderService->render(
            'auth',
            [
                'errors' => $sessionService->getFlashErrors() ?: [],
            ]
        );
    }

    /**
     * Авторизация пользователя
     *
     * @param LoginForm $loginForm
     * @param AuthService $authService
     * @return string
     * @throws \App\exceptions\RedirectException
     */
    public function loginAction(
        LoginForm   $loginForm,
        AuthService $authService
    ): string
    {
        $this->ifIsNotPostRedirect();
        $this->ifHasErrorsRedirect($loginForm->getErrorsForm(), '/auth');

        if ($authService->login($loginForm->getDataForm())) {
            $this->redirect('/');
        }

        $this->redirect('/auth', ['login' => 'Не верный логин или пароль']);
    }

    /**
     * Выход из сессии
     *
     * @param SessionService $sessionService
     * @return void
     * @throws \App\exceptions\RedirectException
     */
    public function logoutAction(
        SessionService $sessionService
    )
    {
        $sessionService->logout();
        $this->redirect('/');
    }
}

<?php

namespace App\controllers;

use App\forms\LoginForm;
use App\services\AuthService;
use App\services\SessionService;
use App\services\TwigRenderService;

class AuthController extends Controller
{
    public function indexAction(
        TwigRenderService $renderService,
        SessionService $sessionService

    ): string
    {
        $msg = '';
        $errors = $sessionService->getFlashErrors() ?: [];
        if (!empty($errors['msg'])) {
            $msg = $errors['msg'];
        }

        return $renderService->render(
            'auth',
            [
                'msg' => $msg,
                'errors' => $errors
            ]
        );
    }

    public function loginAction(
        LoginForm $loginForm,
        AuthService $authService
    )
    {
        $this->ifIsNotPostRedirect();
        $this->ifHasErrorsRedirect($loginForm->getErrorsForm(), '/auth');

        if ($authService->login($loginForm->getDataForm())) {
            $this->redirect('/');
        }

        $this->redirect('/auth', ['login' => 'Не верный логин или пароль']);
    }

    public function logoutAction(
        SessionService $sessionService
    )
    {
        $sessionService->logout();
        $this->redirect('/');
    }
}

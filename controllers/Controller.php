<?php

namespace App\controllers;

use App\exceptions\RedirectException;
use App\services\SessionService;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __construct(
        protected Request $request
    )
    {
    }

    /**
     * При запросе отличным от мерода пост совершает редирект
     *
     * @throws RedirectException
     */
    protected function ifIsNotPostRedirect($url = '/')
    {
        if (!$this->request->isMethod('POST')) {
            $this->redirect($url);
        }
    }

    /**
     * Если пользователь не админ - совершает редирект
     *
     * @throws RedirectException
     */
    protected function ifIsNotAdminRedirect(SessionService $sessionService, $url = '/')
    {
        if (!$sessionService->isLogin()) {
            $this->redirect($url);
        }
    }

    /**
     * Если есть ошибки - редирект
     *
     * @throws RedirectException
     */
    protected function ifHasErrorsRedirect($errors = [], $url = '/')
    {
        if (!empty($errors)) {
            $this->redirect($url, $errors);
        }
    }

    /**
     * Трегерит редирект на указанны адрес
     *
     * @throws RedirectException
     */
    protected function redirect($url = '/', $errors = [],)
    {
        throw new RedirectException($url, $errors);
    }
}

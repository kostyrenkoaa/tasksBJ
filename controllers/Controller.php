<?php
namespace App\controllers;

use App\exceptions\RedirectException;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __construct(
        protected Request $request
    )
    {
    }

    /**
     * @throws RedirectException
     */
    protected function ifIsNotPostRedirect($url = '/')
    {
         if (!$this->request->isMethod('POST')) {
             $this->redirect($url);
         }
    }

    /**
     * @throws RedirectException
     */
    protected function ifHasErrorsRedirect($errors = [], $url = '/')
    {
         if (!empty($errors)) {
             $this->redirect($url, $errors);
         }
    }

    /**
     * @throws RedirectException
     */
    protected function redirect($url = '/', $errors = [],)
    {
        throw new RedirectException($url, $errors);
    }
}

<?php
namespace App\controllers;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __construct(
        protected Request $request
    )
    {
    }
}

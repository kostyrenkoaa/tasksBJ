<?php
namespace App\controllers;

use App\services\TwigRenderService;
use App\services\UserService;

class HomeController extends Controller
{
    public function indexAction(
        UserService $userService,
        TwigRenderService $renderService

    )
    {
        return $renderService->render('home', $userService->getInfo());
    }
}

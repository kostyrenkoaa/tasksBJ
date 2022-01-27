<?php

namespace App\controllers;

use App\forms\GetTasksForm;
use App\services\PaginatorService;
use App\services\SessionService;
use App\services\TaskService;
use App\services\TwigRenderService;

class HomeController extends Controller
{
    public function indexAction(
        GetTasksForm $getTasksForm,
        TaskService       $taskService,
        TwigRenderService $renderService,
        SessionService $sessionService,
        PaginatorService $paginatorService,

    ): string
    {
        $paginatorDTO = $paginatorService->getData(
            $paginatorService->getDB()->taskRepository, $getTasksForm->getDataForm()
        );

        return $renderService->render(
            'home',
            [
                'tasks' => $taskService->getTasks($paginatorDTO),
                'errors' => $sessionService->getFlashErrors() ?: [],
                'paginator' => $paginatorDTO,
            ]
        );
    }
}

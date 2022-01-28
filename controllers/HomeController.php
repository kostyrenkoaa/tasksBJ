<?php

namespace App\controllers;

use App\forms\GetTasksForm;
use App\services\PaginatorService;
use App\services\SessionService;
use App\services\TaskService;
use App\services\TwigRenderService;

class HomeController extends Controller
{
    /**
     * Страница для вывода тасков. Главная страница
     *
     * @param GetTasksForm $getTasksForm
     * @param TaskService $taskService
     * @param TwigRenderService $renderService
     * @param SessionService $sessionService
     * @param PaginatorService $paginatorService
     * @return string
     */
    public function indexAction(
        GetTasksForm      $getTasksForm,
        TaskService       $taskService,
        TwigRenderService $renderService,
        SessionService    $sessionService,
        PaginatorService  $paginatorService,

    ): string
    {
        $paginatorDTO = $paginatorService->getData(
            $paginatorService->getDB()->TaskRepository, $getTasksForm->getDataForm()
        );

        return $renderService->render(
            'home',
            [
                'msg' => $sessionService->getFlashMSG(),
                'tasks' => $taskService->getTasks($paginatorDTO),
                'errors' => $sessionService->getFlashErrors() ?: [],
                'paginator' => $paginatorDTO,
                'isLogin' => $sessionService->isLogin(),
                'url' => '/task/create',
                'task' => $taskService->getDB()->TaskRepository->getNewEntity()
            ]
        );
    }
}

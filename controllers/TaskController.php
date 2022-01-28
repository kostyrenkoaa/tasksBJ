<?php

namespace App\controllers;

use App\exceptions\RedirectException;
use App\forms\CreateTaskForm;
use App\forms\UpdateTaskForm;
use App\services\SessionService;
use App\services\TaskService;
use App\services\TwigRenderService;

class TaskController extends Controller
{
    /**
     * Создание таска
     *
     * @param CreateTaskForm $createTaskForm
     * @param TaskService $taskService
     * @param SessionService $sessionService
     * @throws RedirectException
     */
    public function createAction(
        CreateTaskForm $createTaskForm,
        TaskService $taskService,
        SessionService $sessionService,
    )
    {
        $this->ifIsNotPostRedirect();
        $this->ifHasErrorsRedirect($createTaskForm->getErrorsForm());
        $taskService->save($createTaskForm->getDataForm());
        $sessionService->setFlashMSG('Задача успешно создана');
        $this->redirect();
    }

    /**
     * Обновление таска
     *
     * @param SessionService $sessionService
     * @param UpdateTaskForm $updateTaskForm
     * @param TaskService $taskService
     * @throws RedirectException
     */
    public function updateAction(
        SessionService $sessionService,
        UpdateTaskForm $updateTaskForm,
        TaskService    $taskService
    )
    {
        $this->ifIsNotPostRedirect();
        $this->ifIsNotAdminRedirect($sessionService);
        $updateTaskDTO = $updateTaskForm->getDataForm();
        $this->ifHasErrorsRedirect($updateTaskForm->getErrorsForm(), '/task/form/?id=' . $updateTaskDTO->id);
        $taskService->update($updateTaskDTO);
        $sessionService->setFlashMSG('Задача успешно изменена');
        $this->redirect();
    }

    /**
     * Форма изменения таска
     *
     * @param SessionService $sessionService
     * @param TaskService $taskService
     * @param TwigRenderService $renderService
     * @return string
     * @throws RedirectException
     */
    public function formAction(
        SessionService    $sessionService,
        TaskService       $taskService,
        TwigRenderService $renderService
    )
    {
        $this->ifIsNotAdminRedirect($sessionService);
        $id = (int)$this->request->get('id');
        if (empty($id)) {
            $this->redirect();
        }

        $task = $taskService->getTask($id);
        if (empty($task)) {
            $this->redirect();
        }

        return $renderService->render(
            'editTask',
            [
                'task' => $task,
                'errors' => $sessionService->getFlashErrors() ?: [],
                'url' => '/task/update?id=' . $id,
                'isLogin' => $sessionService->isLogin(),
            ]
        );

    }
}

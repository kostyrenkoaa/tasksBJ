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
     * @param CreateTaskForm $createTaskForm
     * @param TaskService $taskService
     * @return mixed
     * @throws RedirectException
     */
    public function createAction(CreateTaskForm $createTaskForm, TaskService $taskService): mixed
    {
        $this->ifIsNotPostRedirect();
        $this->ifHasErrorsRedirect($createTaskForm->getErrorsForm());
        $taskService->save($createTaskForm->getDataForm());

        $this->redirect();
    }

    public function updateAction(
        SessionService $sessionService,
        UpdateTaskForm $updateTaskForm,
        TaskService $taskService
    ): mixed
    {
        $this->ifIsNotPostRedirect();
        $this->ifIsNotAdminRedirect($sessionService);
        $updateTaskDTO = $updateTaskForm->getDataForm();
        $this->ifHasErrorsRedirect($updateTaskForm->getErrorsForm(), '/task/form/?id=' . $updateTaskDTO->id);
        $taskService->update($updateTaskDTO);
        $this->redirect();
    }

    public function formAction(
        SessionService $sessionService,
        TaskService $taskService,
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

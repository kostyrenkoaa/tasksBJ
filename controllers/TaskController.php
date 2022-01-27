<?php

namespace App\controllers;

use App\exceptions\RedirectException;
use App\forms\CreateTaskForm;
use App\services\TaskService;

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
}

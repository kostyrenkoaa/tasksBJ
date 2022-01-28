<?php
namespace App\services;

use App\dto\CreateTaskDTO;
use App\dto\PaginatorDTO;
use App\dto\UpdateTaskDTO;
use App\entities\Task;

class TaskService extends Service
{
    /**
     * Возвращает такс по id
     *
     * @param $taskId
     * @return Task
     */
    public function getTask($taskId)
    {
        return $this->db->TaskRepository->getOne($taskId);
    }

    /**
     * Возвращает таски по данным пагинатора
     *
     * @param PaginatorDTO $paginatorDTO
     * @return array
     */
    public function getTasks(PaginatorDTO $paginatorDTO)
    {
        return $this->db->TaskRepository->getAllByPagination($paginatorDTO);
    }

    /**
     * Сохраняет новый таск
     *
     * @param CreateTaskDTO $createTaskDTO
     * @return void
     */
    public function save(CreateTaskDTO $createTaskDTO)
    {
        $task = $this->getFilledTask($createTaskDTO);
        $this->db->TaskRepository->save($task);
    }

    /**
     * Возвращает заполненный таск данными
     *
     * @param CreateTaskDTO|UpdateTaskDTO $taskDTO
     * @param Task|Null $task
     * @param int $isEdit
     * @return Task|Null|null
     */
    protected function getFilledTask(CreateTaskDTO|UpdateTaskDTO $taskDTO, Task|Null $task = Null, $isEdit = 0)
    {
        if (empty($task)) {
            $task = $this->db->TaskRepository->getNewEntity();
        }

        $task->email = $taskDTO->email;
        $task->text = $taskDTO->text;
        $task->user_name = $taskDTO->user_name;
        $task->is_edit = $isEdit;
        $task->status = $isEdit;
        if (!empty($taskDTO->is_done)) {
            $task->status = Task::STATUS_DONE;
        }

        return $task;
    }

    /**
     * Обновляет таск
     *
     * @param UpdateTaskDTO $updateTaskDTO
     * @return bool
     */
    public function update(UpdateTaskDTO $updateTaskDTO)
    {
        $task = $this->db->TaskRepository->getOne($updateTaskDTO->id);
        if (empty($task)) {
            return false;
        }

        $isEdit = 0;
        if ($task->is_edit == 1 || $task->text != $updateTaskDTO->text) {
            $isEdit = 1;
        }

        $task = $this->getFilledTask($updateTaskDTO, $task, $isEdit);

        $this->db->TaskRepository->save($task);
        return true;
    }
}

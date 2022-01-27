<?php
namespace App\services;

use App\dto\CreateTaskDTO;
use App\dto\PaginatorDTO;
use App\dto\UpdateTaskDTO;
use App\entities\Task;
use App\forms\UpdateTaskForm;

class TaskService extends Service
{
    public function getTask($taskId)
    {
        return $this->db->taskRepository->getOne($taskId);
    }

    public function getTasks(PaginatorDTO $paginatorDTO)
    {
        return $this->db->taskRepository->getAllByPagination($paginatorDTO);
    }

    public function save(CreateTaskDTO $createTaskDTO)
    {
        $task = $this->getFilledTask($createTaskDTO);
        $this->db->taskRepository->save($task);
    }

    protected function getFilledTask(CreateTaskDTO|UpdateTaskDTO $taskDTO, Task|Null $task = null)
    {
        if (empty($task)) {
            $task = $this->db->taskRepository->getNewEntity();
        }

        $task->email = $taskDTO->email;
        $task->text = $taskDTO->text;
        $task->user_name = $taskDTO->user_name;
        $task->status = Task::STATUS_NEW;
        if (!empty($taskDTO->is_done)) {
            $task->status = Task::STATUS_DONE;
        }

        return $task;
    }

    public function update(UpdateTaskDTO $updateTaskDTO)
    {
        $task = $this->db->taskRepository->getOne($updateTaskDTO->id);
        if (empty($task)) {
            return false;
        }

        $task = $this->getFilledTask($updateTaskDTO, $task);

        $this->db->taskRepository->save($task);
        return true;
    }
}

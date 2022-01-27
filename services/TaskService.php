<?php
namespace App\services;

use App\dto\CreateTaskDTO;
use App\dto\PaginatorDTO;

class TaskService extends Service
{
    public function getTasks(PaginatorDTO $paginatorDTO)
    {
        return $this->db->taskRepository->getAllByPagination($paginatorDTO);
    }

    public function save(CreateTaskDTO $createTaskDTO)
    {
        $task = $this->db->taskRepository->getNewEntity();
        $task->email = $createTaskDTO->email;
        $task->text = $createTaskDTO->text;
        $task->user_name = $createTaskDTO->user_name;
        $this->db->taskRepository->save($task);
    }
}

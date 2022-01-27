<?php
namespace App\repositories;

use App\entities\Task;

/**
 * @method Task getOne($id)
 * @method Task[] getAll()
 * @method Task getNewEntity()
 */
class TaskRepository extends Repository
{
    public function getTableName(): string
    {
        return 'tasks';
    }

    protected function getEntityClass()
    {
        return Task::class;
    }
}

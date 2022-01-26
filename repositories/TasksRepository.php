<?php
namespace App\repositories;

use App\entities\Task;

/**
 * @method Task getOne($id)
 */
class TasksRepository extends Repository
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

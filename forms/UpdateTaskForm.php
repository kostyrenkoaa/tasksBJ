<?php

namespace App\forms;

use App\dto\UpdateTaskDTO;

/**
 * @method UpdateTaskDTO getDataForm()
 */
class UpdateTaskForm extends CreateTaskForm
{
    public function getDTOClass(): string
    {
        return UpdateTaskDTO::class;
    }
}
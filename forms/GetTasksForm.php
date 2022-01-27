<?php

namespace App\forms;

use App\dto\PaginatorDTO;

/**
 * @method PaginatorDTO getDataForm()
 */
class GetTasksForm extends Form
{
    public function getDTOClass(): string
    {
        return PaginatorDTO::class;
    }
}
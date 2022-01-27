<?php

namespace App\forms;

use App\dto\PaginatorDTO;

class GetTasksForm extends Form
{
    public function getDTOClass(): string
    {
        return PaginatorDTO::class;
    }
}
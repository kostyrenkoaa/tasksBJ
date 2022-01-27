<?php

namespace App\dto;

class UpdateTaskDTO extends CreateTaskDTO
{
    public $id;
    public $is_done = false;
}
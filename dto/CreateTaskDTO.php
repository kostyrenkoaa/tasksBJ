<?php

namespace App\dto;

class CreateTaskDTO extends DTO
{
    public $user_name;
    public $email;
    public $text;
    public $is_done;
}
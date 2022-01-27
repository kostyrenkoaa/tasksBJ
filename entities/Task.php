<?php
namespace App\entities;

class Task extends Entity
{
    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';

    public $id;
    public $user_name;
    public $text;
    public $status;
    public $email;
}

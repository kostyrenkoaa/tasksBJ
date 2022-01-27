<?php

namespace App\forms;


use App\dto\CreateTaskDTO;

class CreateTaskForm extends Form
{
    protected array $validateRules = [
        'email' => [
            'email' => 'Емайл не валиден',
        ],
        'user_name' => [
            'stringNotEmpty' => 'Имя пользователя не должно быть пустым'
        ],
        'text' => [
            'stringNotEmpty' => 'Описание задачи не должно быть пустым'
        ]
    ];

    public function getDTOClass(): string
    {
        return CreateTaskDTO::class;
    }
}
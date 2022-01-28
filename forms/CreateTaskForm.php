<?php

namespace App\forms;

use App\dto\CreateTaskDTO;

/**
 * @method CreateTaskDTO getDataForm()
 */
class CreateTaskForm extends Form
{
    protected array $validateRules = [
        'email' => [
            'email' => 'Email не валиден',
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
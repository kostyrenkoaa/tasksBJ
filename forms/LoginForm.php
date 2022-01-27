<?php

namespace App\forms;


use App\dto\LoginDTO;

/**
 * @method LoginDTO getDataForm()
 */
class LoginForm extends Form
{
    protected array $validateRules = [
        'login' => [
            'stringNotEmpty' => 'Логин не должен быть пустым'
        ],
        'password' => [
            'stringNotEmpty' => 'Пароль не должен быть пустым'
        ]
    ];

    public function getDTOClass(): string
    {
        return LoginDTO::class;
    }
}
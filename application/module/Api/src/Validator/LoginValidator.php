<?php

namespace Api\Validator;

use Main\Validator\BaseValidator;

class LoginValidator extends BaseValidator
{
    /**
     * @var array
     */
    protected $filters = [
        'email' => ['trimFilter'],
        'password' => ['trimFilter'],
    ];

    protected $validators = [
        'email' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 100,
                'message' => 'Длина должна быть от 0 до 100 символов'
            ],
        ],
        'password' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 100,
                'message' => 'Длина должна быть от 0 до 100 символов'
            ],
        ],
    ];
}
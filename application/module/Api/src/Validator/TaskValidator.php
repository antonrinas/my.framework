<?php

namespace Api\Validator;

use Main\Validator\BaseValidator;

class TaskValidator extends BaseValidator
{
    /**
     * @var array
     */
    protected $filters = [
        'user_name' => ['trimFilter', 'stripSlashesFilter'],
        'email' => ['trimFilter', 'stripSlashesFilter'],
        'description' => ['trimFilter', 'stripSlashesFilter'],
        'status' => ['trimFilter'],
    ];

    protected $validators = [
        'user_name' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 255,
                'message' => 'Длина должна быть от 0 до 255 символов'
            ],
        ],
        'email' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 255,
                'message' => 'Длина должна быть от 0 до 255 символов'
            ],
            [
                'name' => 'emailAddressValidator',
                'message' => 'Неверный формат email адреса'
            ],
        ],
        'description' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 2000,
                'message' => 'Длина должна быть от 0 до 2000 символов'
            ],
        ],
        'status' => [
            [
                'name' => 'regexValidator',
                'message' => 'Неверный формат данных', 'regex' => '/^(1|2)*$/'
            ],
        ],
    ];
}
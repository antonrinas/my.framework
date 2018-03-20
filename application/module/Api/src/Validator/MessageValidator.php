<?php

namespace Api\Validator;

use Main\Validator\BaseValidator;

class MessageValidator extends BaseValidator
{
    /**
     * @var array
     */
    protected $filters = [
        'content' => ['trimFilter', 'stripSlashesFilter'],
    ];

    protected $validators = [
        'content' => [
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
    ];
}
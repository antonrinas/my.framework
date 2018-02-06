<?php

namespace Api\Validator;

use Framework\Validator\Validator;
use Framework\Validator\ValidatorInterface;

class TaskValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var array
     */
    private $filters = [
        'user_name' => array('trimFilter', 'stripSlashesFilter'),
        'email' => array('trimFilter', 'stripSlashesFilter'),
        'description' => array('trimFilter', 'stripSlashesFilter'),
    ];

    private $validators = [
        'user_name' => array(
            array('name' => 'notEmptyValidator', 'message' => 'Поле не может быть пустым'),
            array('name' => 'stringLengthValidator', 'min' => 0, 'max' => 255, 'message' => 'Длина должна быть от 0 до 255 символов'),
        ),
        'email' => array(
            array('name' => 'notEmptyValidator', 'message' => 'Поле не может быть пустым'),
            array('name' => 'stringLengthValidator', 'min' => 0, 'max' => 255, 'message' => 'Длина должна быть от 0 до 255 символов'),
            array('name' => 'emailAddressValidator', 'message' => 'Неверный формат email адреса'),
        ),
        'description' => array(
            array('name' => 'notEmptyValidator', 'message' => 'Поле не может быть пустым'),
            array('name' => 'stringLengthValidator', 'min' => 0, 'max' => 2000, 'message' => 'Длина должна быть от 0 до 2000 символов'),
        ),
    ];

    /**
     * @var array
     */
    private $errors;

    public function __construct($data)
    {
        $this->validator = new Validator();
        $this->validator->setFormElements($data);
        $this->validator->setElementsFilters($this->filters);
        $this->validator->setElementsValidators($this->validators);
    }

    public function isValid()
    {
        if ($this->validator->isValid()) {
            return true;
        }
        $this->errors = $this->validator->getElementsErrors();
        foreach ($this->errors as $elementName => $errors) {
            $this->errors[$elementName] = implode(', ', $errors);
        }
        return false;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
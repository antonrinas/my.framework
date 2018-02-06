<?php

namespace Api\Validator;

use Framework\Validator\Validator;
use Framework\Validator\ValidatorInterface;

class LoginValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var array
     */
    private $filters = [
        'email' => array('trimFilter'),
        'password' => array('trimFilter'),
    ];

    private $validators = [
        'email' => array(
            array('name' => 'notEmptyValidator', 'message' => 'Поле не может быть пустым'),
            array('name' => 'stringLengthValidator', 'min' => 0, 'max' => 100, 'message' => 'Длина должна быть от 0 до 100 символов'),
        ),
        'password' => array(
            array('name' => 'notEmptyValidator', 'message' => 'Поле не может быть пустым'),
            array('name' => 'stringLengthValidator', 'min' => 0, 'max' => 100, 'message' => 'Длина должна быть от 0 до 100 символов'),
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
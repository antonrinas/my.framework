<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;

class TestController extends BaseController
{
    public function __construct()
    {

    }

    public function index($id1, $id2, $id3)
    {
        print_r($this->getRequest());exit();
    }

    public function someMethod()
    {
        return $this->getView()->setParams([
            'name' => 'Антон',
            'surname' => 'Ринас',
        ])->render();
    }
}
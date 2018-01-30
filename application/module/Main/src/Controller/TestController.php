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
        print_r('someMethod');exit();
    }
}
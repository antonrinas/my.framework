<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;

class IndexController extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        return $this->getView()->setParams([])->render();
    }
}
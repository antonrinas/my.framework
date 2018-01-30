<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return $this->getView()->setParams([])->render();
    }
}
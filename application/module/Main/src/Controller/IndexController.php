<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;
use Framework\Mvc\Model\ModelFactory;

class IndexController extends BaseController
{
    public function index()
    {
        return $this->getView()->render();
    }
}
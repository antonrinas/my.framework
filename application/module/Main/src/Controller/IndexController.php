<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;
use Framework\Mvc\Model\ModelFactory;

class IndexController extends BaseController
{
    public function index()
    {
        $userModel = ModelFactory::init(
            \Main\Model\User::class,
            \Main\Entity\User::class)->retrieveModel();

        var_dump($userModel->find(1));exit();

        return $this->getView()->setParams([])->render();
    }
}
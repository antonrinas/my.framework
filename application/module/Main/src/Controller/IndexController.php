<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;
use \PDO;
use Framework\Mvc\Model\ModelFactory;

class IndexController extends BaseController
{
    public function index()
    {
        $userModel = ModelFactory::init(
            \Main\Model\User::class,
            \Main\Entity\User::class)->retrieveModel();

        print_r($userModel->testQueryBuilder());exit();

        return $this->getView()->setParams([])->render();
    }
}
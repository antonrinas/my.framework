<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;
use \PDO;
use Framework\Mvc\Model\ModelFactory;

class IndexController extends BaseController
{
    public function index()
    {
        //$this->getResponse()->setCookie('testCookie', 'Это тестовая кука', time()+60*60*24*30);
        //print_r($this->getRequest()->getCookies());exit();

        $userModel = ModelFactory::init(
            \Main\Model\User::class,
            \Main\Entity\User::class)->retrieveModel();



        //print_r($userModel->fetchAll());exit();
        //print_r($userModel->find(2));exit();

        return $this->getView()->setParams([])->render();
    }
}
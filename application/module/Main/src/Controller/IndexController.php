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



        //print_r($userModel->fetchAll());exit();
        print_r($userModel->find(2));exit();


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        do {
            $row = $stmt->fetchObject('\Main\Controller\User');
            print_r($row->getName());exit();
        } while ($row);

        return $this->getView()->setParams([])->render();
    }
}
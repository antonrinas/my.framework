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
        $this->getView()->setParams([
            'name' => 'Антон',
            'surname' => 'Ринас',
        ])->setLayoutName('default')->render();
    }
}
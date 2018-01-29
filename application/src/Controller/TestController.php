<?php

namespace Application\Controller;


class TestController
{
    public function __construct()
    {

    }

    public function index($id1, $id2, $id3)
    {
        print_r($id3);exit();
    }

    public function someMethod()
    {
        print_r('someMethod');exit();
    }
}
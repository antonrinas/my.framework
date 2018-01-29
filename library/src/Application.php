<?php

namespace Framework;

class Application
{
    private function __construct()
    {

    }

    public static function init($config)
    {
        return new Application($config);
    }

    private function start()
    {

    }
}
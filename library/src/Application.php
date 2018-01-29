<?php

namespace Framework;

use Framework\Mvc\Controller\FrontController;

class Application
{
    private $config;

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     *
     * @return Application
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }


    public function __construct($config)
    {
        $this->setConfig($config);
        $frontController = new FrontController($config);
        $this->init();
    }

    private function init()
    {
        if (!isset($_SESSION)){
            session_start();
        }
    }
}
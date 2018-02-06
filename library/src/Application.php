<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerInterface;

class Application implements ApplicationInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var FrontControllerInterface
     */
    private $frontController;

    public function __construct($config, FrontControllerInterface $frontController)
    {
        $this->checkConfig($config);
        $this->config = $config;
        $this->frontController = $frontController;
    }

    private function checkConfig($config)
    {
        if (!array_key_exists('development', $config)){
            throw new ControllerException("Environment settings is required. You must provide 'development' key in the config.");
        }
        if (!array_key_exists('routes', $config)){
            throw new ControllerException("Routes settings is required. You must provide 'routes' key in the config.");
        }
    }

    public function start()
    {
        $response = $this->frontController->handleRequest();
        echo $response;
    }
}
<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerFactory;

class ApplicationFactory implements FactoryInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $routes = require_once (ROOT . DS . 'config' . DS . 'routes.php');
        $generalConfig = require_once (ROOT . DS . 'config' . DS . 'config.php');
        $config = array_merge_recursive($routes, $generalConfig);
        $this->config = $config;
    }

    public function getInstance()
    {
        $frontControllerFactory = new FrontControllerFactory($this->config);

        return new Application($this->config, $frontControllerFactory->getInstance());
    }
}
<?php

namespace Framework;

use Framework\Mvc\Controller\FrontController;

class Application implements ApplicationInterface
{
    private $config;

    public function __construct()
    {
        $dbConfig = require_once (ROOT . DS . 'config' . DS . 'db.php');
        $routes = require_once (ROOT . DS . 'config' . DS . 'routes.php');
        $generalConfig = require_once (ROOT . DS . 'config' . DS . 'config.php');
        $config = array_merge_recursive($dbConfig, $routes, $generalConfig);
        $this->checkConfig($config);
        $this->config = $config;
    }

    private function checkConfig($config)
    {
        if (!array_key_exists('development', $config)){
            throw new ControllerException("Environment settings is required. You must provide 'development' key in the config.");
        }
        if (!array_key_exists('db', $config)){
            throw new ControllerException("Database settings is required. You must provide 'db' key in the config.");
        }
        if (!array_key_exists('routes', $config)){
            throw new ControllerException("Routes settings is required. You must provide 'routes' key in the config.");
        }
    }

    public function start()
    {
        $this->initSession();
        $this->initEnviroment();
        new FrontController($this->config);
    }

    private function initSession()
    {
        if (!isset($_SESSION)){
            session_start();
        }
    }

    private function initEnviroment()
    {
        if ($this->config['development']){
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
        }
    }
}
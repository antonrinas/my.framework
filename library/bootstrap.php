<?php

require_once(__DIR__ . '/src/Autoloader/NamespaceAutoloader.php');

$autoloader = new NamespaceAutoloader();
$autoloader->addNamespace('Framework', ROOT . DS . 'library' . DS . 'src');
$autoloader->addNamespace('Application', ROOT . DS . 'application' . DS . 'src');
$autoloader->register();

if (!isset($_SESSION)){
    session_start();
}

$dbConfig = require_once (ROOT . DS . 'config' . DS . 'db.php');
$routes = require_once (ROOT . DS . 'config' . DS . 'routes.php');
$generalConfig = require_once (ROOT . DS . 'config' . DS . 'config.php');

$config = array_merge_recursive($dbConfig, $routes, $generalConfig);
\Framework\Application::init($config)->start();

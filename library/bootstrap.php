<?php

require_once(__DIR__ . '/src/Autoloader/NamespaceAutoloader.php');

$autoloader = new NamespaceAutoloader();
$autoloader->addNamespace('Framework', ROOT . DS . 'library' . DS . 'src');
$autoloader->addNamespace('Application', ROOT . DS . 'application' . DS . 'src');
$autoloader->register();

if (!isset($_SESSION)){
    session_start();
}
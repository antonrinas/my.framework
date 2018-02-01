<?php

require_once(__DIR__ . '/src/Autoloader/NamespaceAutoloader.php');

$autoloader = new NamespaceAutoloader();
$autoloader->register();

$applicationFactory  = new \Framework\ApplicationFactory();
$applicationFactory->getInstance()->start();

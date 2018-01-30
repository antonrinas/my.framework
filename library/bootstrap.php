<?php

require_once(__DIR__ . '/src/Autoloader/NamespaceAutoloader.php');

$autoloader = new NamespaceAutoloader();
$autoloader->register();

$application  = new \Framework\Application();
$application->start();

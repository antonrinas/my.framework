<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Router\Router;
use Framework\Mvc\Controller\Router\RouterInterface;

class FrontController
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct($config)
    {
        $this->router = new Router($config['routes']);
        $this->dispatch();
    }

    private function dispatch()
    {
        $matchedRoute = $this->router->getMatchedRoute();
        $controllerNamespace = $matchedRoute['namespace'];
        $controllerName = $matchedRoute['controller'];
        $className = $controllerNamespace . '\\' . $controllerName;
        $methodName = $matchedRoute['method'];
        if (!class_exists($className)) {
            throw new ControllerException(sprintf("Controller %s was not found",
                $className
            ));
        }
        if (!method_exists($className, $methodName)) {
            throw new ControllerException(sprintf("Controller method %s was not found",
                $methodName
            ));
        }
        $controller = new $className;
        call_user_func_array([$controller, $methodName], $this->router->getParams());
    }
}
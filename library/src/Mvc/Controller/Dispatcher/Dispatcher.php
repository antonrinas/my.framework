<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Request\RequestInterface;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var RequestInterface
     */
    private $request;


    public function __construct($config, RequestInterface $request)
    {
        $this->checkConfig($config);
        $this->config = $config;
        $this->request = $request;
    }

    private function checkConfig($config)
    {
        if (!array_key_exists('module', $config)){
            throw new DispatcherException("Module setting is required. You must provide 'module' key in the route config.");
        }
        if (!array_key_exists('namespace', $config)){
            throw new DispatcherException("Namespace setting is required. You must provide 'namespace' key in the route config.");
        }
        if (!array_key_exists('controller', $config)){
            throw new DispatcherException("Controller name setting is required. You must provide 'controller' key in the route config.");
        }
        if (!array_key_exists('method', $config)){
            throw new DispatcherException("Method mane setting is required. You must provide 'method' key in the route config.");
        }
    }

    public function dispatch()
    {
        $route = $this->config;
        $moduleName = $route['module'];
        $controllerNamespace = $route['namespace'];
        $controllerName = $route['controller'];
        $className = '\\' . $moduleName . '\\' . $controllerNamespace . '\\' . $controllerName;

        $methodName = $route['method'];
        if (!class_exists($className)) {
            throw new DispatcherException(sprintf("Controller %s was not found",
                $className
            ));
        }
        if (!method_exists($className, $methodName)) {
            throw new DispatcherException(sprintf("Controller method %s was not found",
                $methodName
            ));
        }
        $controller = new $className;
        $controller->setRequest($this->request);
        call_user_func_array([$controller, $methodName], $this->request->getParams());
    }
}
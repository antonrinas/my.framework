<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Router\Router;
use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;
use Framework\Mvc\Controller\Dispatcher\Dispatcher;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Request\Request;
use Framework\Mvc\Controller\Response\ResponseInterface;

class FrontController implements FrontControllerInterface
{
    private $config;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct($config)
    {
        $this->config = $config['routes'];
    }

    /**
     * @return ResponseInterface
     */
    public function handleRequest()
    {
        $this->initRouting();
        $this->initRequest();

        return $this->dispatch();
    }

    private function initRouting()
    {
        $this->router = new Router($this->config);
    }

    private function initRequest()
    {
        $this->request = new Request();
        $this->request->setRequestMethod($_SERVER['REQUEST_METHOD']);
        $this->request->setGetParams($this->router->getGetParams());
        $this->request->setParams($this->router->getParams());
        $this->request->setPostParams($_POST);
    }

    /**
     * @return ResponseInterface
     */
    private function dispatch()
    {
        $this->dispatcher = new Dispatcher($this->router->getMatchedRoute(), $this->request);

        return $this->dispatcher->dispatch();
    }
}
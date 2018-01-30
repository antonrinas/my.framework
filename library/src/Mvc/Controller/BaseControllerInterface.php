<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\View\ViewModelInterface;

interface BaseControllerInterface
{
    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function setRequest($request);

    /**
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function setResponse($response);

    /**
     * @return array
     */
    public function getModuleConfig();

    /**
     * @param array $moduleConfig
     *
     * @return ResponseInterface
     */
    public function setModuleConfig($moduleConfig);

    /**
     * @return ViewModelInterface
     */
    public function getView();

    /**
     * @param ViewModelInterface $view
     *
     * @return ResponseInterface
     */
    public function setView($view);

    /**
     * @return string
     */
    public function getContentType();
}
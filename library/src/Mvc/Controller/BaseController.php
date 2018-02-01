<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Session\SessionInterface;

abstract class BaseController implements BaseControllerInterface
{
    /**
     * @var string - possible values:
     *                  - application/json - application returns json for API calls
     *                  - text/html - application returns html
     */
    protected $contentType = 'text/html';

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    protected $moduleConfig;

    /**
     * @var ViewModelInterface
     */
    protected $view;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return BaseController
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return BaseController
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return array
     */
    public function getModuleConfig()
    {
        return $this->moduleConfig;
    }

    /**
     * @param array $moduleConfig
     *
     * @return BaseController
     */
    public function setModuleConfig($moduleConfig)
    {
        $this->moduleConfig = $moduleConfig;
        return $this;
    }

    /**
     * @return ViewModelInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param ViewModelInterface $view
     *
     * @return BaseController
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param SessionInterface $session
     *
     * @return BaseController
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }
}
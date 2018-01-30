<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\View\ViewModelInterface;

abstract class BaseController implements BaseControllerInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $moduleConfig;

    /**
     * @var ViewModelInterface
     */
    protected $view;

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
}
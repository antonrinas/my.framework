<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;
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
     * @return BaseController
     */
    public function setRequest($request);

    /**
     * @return array
     */
    public function getModuleConfig();

    /**
     * @param array $moduleConfig
     *
     * @return BaseController
     */
    public function setModuleConfig($moduleConfig);

    /**
     * @return ViewModelInterface
     */
    public function getView();

    /**
     * @param ViewModelInterface $view
     *
     * @return BaseController
     */
    public function setView($view);

    /**
     * @return string
     */
    public function getContentType();
}
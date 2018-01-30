<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;

abstract class BaseController
{
    /**
     * @var RequestInterface
     */
    protected $request;

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


}
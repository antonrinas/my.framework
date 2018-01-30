<?php

namespace Framework\Mvc\Controller\Request;

class Request implements RequestInterface
{
    /**
     * @var string
     */
    private $requestMethod;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var array
     */
    private $getParams = [];

    /**
     * @var array
     */
    private $postParams = [];

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @param string $requestMethod
     * @return Request
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * Get route match params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set route match params
     *
     * @param array $params
     *
     * @return RequestInterface
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getParam($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->params)){
            return $this->params;
        }
        return $defaultValue;
    }

    /**
     * Get $_GET params
     *
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * Set $_GET params
     *
     * @param array $getParams
     *
     * @return RequestInterface
     */
    public function setGetParams($getParams)
    {
        $this->getParams = $getParams;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getGetParam($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->getParams)){
            return $this->getParams;
        }
        return $defaultValue;
    }

    /**
     * Get $_POST params
     *
     * @return array
     */
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     * Set $_POST params
     *
     * @param array $postParams
     *
     * @return RequestInterface
     */
    public function setPostParams($postParams)
    {
        $this->postParams = $postParams;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getPostParam($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->postParams)){
            return $this->postParams;
        }
        return $defaultValue;
    }
}
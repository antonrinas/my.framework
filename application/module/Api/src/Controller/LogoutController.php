<?php

namespace Api\Controller;

use Framework\Mvc\Controller\BaseController;
use Api\Core\Constants;

class LogoutController extends BaseController
{
    /**
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * @return string
     */
    public function store()
    {
        try {
            $this->getSession()->clear();
            $this->getResponse()->setStatusCode(201);
            return $this->getView()->setParams(['status' => Constants::OK_STATUS,])->render();
        } catch(\Exception $e) {
            $this->getResponse()->setStatusCode($e->getCode());
            return $this->getView()->setParams([
                'status' => Constants::ERROR_STATUS,
                'message' => Constants::GENERAL_ERROR_MESSAGE,
                'message_for_developer' => $e->getMessage(),
            ])->render();
        }
    }
}
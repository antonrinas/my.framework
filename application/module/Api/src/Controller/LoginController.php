<?php

namespace Api\Controller;

use Framework\Mvc\Model\ModelFactory;
use Main\Model\BaseModelInterface;
use Main\Model\User as UserModel;
use Main\Entity\User as UserEntity;
use Api\Validator\LoginValidator;
use Api\Core\Constants;

class LoginController extends BaseApiController
{
    /**
     * @var BaseModelInterface
     */
    private $userModel;

    public function __construct()
    {
        $this->userModel = ModelFactory::init(UserModel::class, UserEntity::class)->retrieveModel();
    }

    /**
     * @return string
     */
    public function store()
    {
        try {
            $postParams = $this->getRequest()->getPostParams();

            $validator = new LoginValidator($postParams);
            if (!$validator->isValid()){
                return $this->getWarningResponse($validator->getErrors());
            }
            $user = $this->userModel->findByParams(['email' => $postParams['email']]);
            if (!$user){
                return $this->getWarningResponse([], Constants::GENERAL_LOGIN_ERROR);
            }
            if (!password_verify($postParams['password'], $user->getPassword())) {
                return $this->getWarningResponse([], Constants::GENERAL_LOGIN_ERROR);
            };
            $this->getSession()->setUserData($user);
            $user->setUpdated(date('Y-m-d H:i:s'));
            $this->userModel->save($user);
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

    /**
     * @param $messages
     * @param string $generalMessage
     *
     * @return string
     */
    protected function getWarningResponse($messages, $generalMessage = null)
    {
        return $this->getView()->setParams([
            'status' => Constants::WARNING_STATUS,
            'messages' => $messages,
            'general_message' => $generalMessage,
        ])->render();
    }
}
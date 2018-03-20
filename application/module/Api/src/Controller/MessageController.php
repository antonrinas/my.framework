<?php

namespace Api\Controller;

use Framework\Mvc\Model\ModelFactory;
use Main\Exception\ControllerException;
use Main\Model\BaseModelInterface;
use Api\Core\Constants;
use Api\Model\Message as MessageModel;
use Api\Entity\Message as MessageEntity;
use Api\Validator\MessageValidator;

class MessageController extends BaseApiController
{
    const MESSAGES_PER_PAGE = 20;

    /**
     * @var BaseModelInterface
     */
    private $messageModel;

    public function __construct()
    {
        $this->messageModel = ModelFactory::init(
            MessageModel::class,
            MessageEntity::class
        )->retrieveModel();
    }

    /**
     * Retrieve tasks list
     *
     * @return string
     */
    public function index()
    {
        try {
            $this->isAuthenticated();
            $page = (int) $this->getRequest()->getGetParam('page');
            $filters = [
                'limit' => self::MESSAGES_PER_PAGE,
                'offset' => self::MESSAGES_PER_PAGE * ($page - 1),
            ];

            return $this->getView()->setParams(
                [
                    'status' => Constants::OK_STATUS,
                    'data' => $this->messageModel->fetchAllByFilters($filters),
                    'per_page' => self::MESSAGES_PER_PAGE,
                    'total_rows' => $this->messageModel->countAll()
                ]
            )->render();
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
     * Add task
     *
     * @return string
     */
    public function store()
    {
        try {
            $this->isAuthenticated();
            $postParams = $this->getRequest()->getPostParams();
            $validator = new MessageValidator($postParams);
            if (!$validator->isValid()){
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }

            $message = new MessageEntity();
            $message->exchangeArray($postParams)
                    ->setUserId($this->getSession()->getUserData()->getId())
                    ->setCreated(date('Y-m-d H:i:s'))
                    ->setUpdated(date('Y-m-d H:i:s'));
            $id = $this->messageModel->save($message);
            $this->getResponse()->setStatusCode(201);
            $this->getResponse()->setHeader('Location', '/api/messages/' . $id);

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
<?php

namespace Api\Controller;

use Framework\Mvc\Controller\BaseController;
use Framework\Mvc\Model\ModelFactory;
use Main\Exception\ControllerException;
use Main\Model\BaseModelInterface;
use Api\Core\Constants;
use Api\Model\Task as TaskModel;
use Api\Entity\Task as TaskEntity;

class TaskController extends BaseController
{
    const ENTITIES_PER_PAGE = 2;

    protected $contentType = 'application/json';

    /**
     * @var BaseModelInterface
     */
    private $model;

    public function __construct()
    {
        $this->model = ModelFactory::init(TaskModel::class, TaskEntity::class)->retrieveModel();
    }

    public function index()
    {
        try {
            $page = (int) $this->getRequest()->getGetParam('page');
            $filters = [
                'limit' => self::ENTITIES_PER_PAGE,
                'offset' => self::ENTITIES_PER_PAGE * ($page - 1),
                'sortBy' => $this->getRequest()->getGetParam('sortBy'),
                'sortDesc' => $this->getRequest()->getGetParam('sortDesc'),
            ];
            $data = $this->model->fetchAllByFilters($filters);
            foreach ($data as $key => $row) {
                $row['status'] = $row['status'] === '1' ? 'Не выполнено' : 'Выполнено';
                $data[$key] = $row;
            }

            return $this->getView()->setParams(
                [
                    'status' => Constants::OK_STATUS,
                    'data' => $data,
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

    public function store()
    {
        try {
            $postParams = $this->getRequest()->getPostParams();
            $files = $this->getRequest()->getFiles();

            /**
             * СДЕЛАТЬ ВАЛИДАЦИЮ
             */

            $task = new TaskEntity();
            $task->exchangeArray($postParams);
            $id = $this->model->save($task);
            $this->getResponse()->setStatusCode(201);
            $this->getResponse()->setHeader('Location', '/api/tasks/' . $id);

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

    public function edit($taskId)
    {
        try {
            $task = $this->model->find((int) $taskId);
            if (!$task) {
                $exception = new ControllerException(sprintf("Task with ID %s was not found",
                    $taskId
                ));
                $exception->setCode(404);
                throw $exception;
            }
            return $this->getView()->setParams(
                [
                    'status' => Constants::OK_STATUS,
                    'data' => $task,
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

    public function update($taskId)
    {

    }

    public function destroy($taskId)
    {

    }
}
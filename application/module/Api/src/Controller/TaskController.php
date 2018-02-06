<?php

namespace Api\Controller;

use Framework\Mvc\Controller\BaseController;
use Framework\Mvc\Model\ModelFactory;
use Main\Exception\ControllerException;
use Main\Model\BaseModelInterface;
use Api\Core\Constants;
use Api\Model\Task as TaskModel;
use Api\Entity\Task as TaskEntity;
use Api\Model\Image as ImageModel;
use Api\Entity\Image as ImageEntity;
use Api\Validator\TaskValidator;
use Main\Service\FileUploaderService;
use Main\Service\ImageTranformationService;

class TaskController extends BaseController
{
    const ENTITIES_PER_PAGE = 3;

    /**
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * @var BaseModelInterface
     */
    private $taskModel;

    /**
     * @var BaseModelInterface
     */
    private $imageModel;

    public function __construct()
    {
        $this->taskModel = ModelFactory::init(TaskModel::class, TaskEntity::class)->retrieveModel();
        $this->imageModel = ModelFactory::init(ImageModel::class, ImageEntity::class)->retrieveModel();
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

            return $this->getView()->setParams(
                [
                    'status' => Constants::OK_STATUS,
                    'data' => $this->taskModel->fetchAllByFilters($filters),
                    'per_page' => self::ENTITIES_PER_PAGE,
                    'total_rows' => $this->taskModel->countAll()
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
            $validator = new TaskValidator($postParams);
            if (!$validator->isValid()){
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }
            $image_id = null;
            if ($this->getRequest()->getFiles()) {
                $uploadResult = $this->uploadImage();
                if ($uploadResult['status'] === 'error'){
                    return $this->getWarningResponse(['image' => $uploadResult['message']]);
                }
                $resizeResult = $this->makeThumb($uploadResult['file_path']);
                if ($resizeResult['status'] === 'error'){
                    $this->unlinkFile(PUBLIC_PATH . $uploadResult['file_path']);
                    return $this->getWarningResponse(['image' => $resizeResult['message']]);
                }
                $image = new ImageEntity();
                $image->setPath($uploadResult['file_path'])
                    ->setPathThumb1($resizeResult['file_path'])
                    ->setCreated(date('Y-m-d H:i:s'))
                    ->setUpdated(date('Y-m-d H:i:s'));
                $image_id = $this->imageModel->save($image);
            }
            $task = new TaskEntity();
            $task->exchangeArray($postParams)
                 ->setImageId($image_id)
                 ->setCreated(date('Y-m-d H:i:s'))
                 ->setUpdated(date('Y-m-d H:i:s'));
            $id = $this->taskModel->save($task);
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
            $task = $this->taskModel->find((int) $taskId, ['*'], true);
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
        try {
            $task = $this->taskModel->find((int) $taskId, ['*']);
            if (!$task) {
                $exception = new ControllerException(sprintf("Task with ID %s was not found",
                    $taskId
                ));
                $exception->setCode(404);
                throw $exception;
            }
            $postParams = $this->getRequest()->getPostParams();
            $validator = new TaskValidator($postParams);
            if (!$validator->isValid()){
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }

            $image_id = $task->getImageId();
            if ($this->getRequest()->getFiles()) {
                $uploadResult = $this->uploadImage();
                if ($uploadResult['status'] === 'error'){
                    return $this->getWarningResponse(['image' => $uploadResult['message']]);
                }
                $resizeResult = $this->makeThumb($uploadResult['file_path']);
                if ($resizeResult['status'] === 'error'){
                    $this->unlinkFile(PUBLIC_PATH . $uploadResult['file_path']);
                    return $this->getWarningResponse(['image' => $resizeResult['message']]);
                }
                $image = new ImageEntity();
                $image->setPath($uploadResult['file_path'])
                    ->setPathThumb1($resizeResult['file_path'])
                    ->setCreated(date('Y-m-d H:i:s'))
                    ->setUpdated(date('Y-m-d H:i:s'));
                $image_id = $this->imageModel->save($image);
                if ($task->getImageId()) {
                    $this->imageModel->delete($task->getImageId());
                }
            }

            $task->exchangeArray($postParams)
                ->setImageId($image_id)
                ->setUpdated(date('Y-m-d H:i:s'));
            $id = $this->taskModel->save($task);

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

    public function destroy($taskId)
    {

    }

    private function getWarningResponse($messages)
    {
        return $this->getView()->setParams([
            'status' => Constants::WARNING_STATUS,
            'messages' => $messages,
        ])->render();
    }

    private function uploadImage()
    {
        $fileUploaderService = new FileUploaderService();
        $fileUploaderService->setUploadPath('/uploaded/tasks/')
            ->setAllowedTypes('jpg|jpeg|png|gif')
            ->setAllowedMimes([
                'bmp'   => ['image/bmp', 'image/x-windows-bmp', 'inode/x-empty'],
                'gif'   => 'image/gif',
                'jpeg'  => ['image/jpeg', 'image/pjpeg'],
                'jpg'   => ['image/jpeg', 'image/pjpeg'],
                'jpe'   => ['image/jpeg', 'image/pjpeg'],
                'png'   => ['image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg'],
            ])
            ->setMaxSize(4096)
            ->setEncryptName(true)
            ->setFileElementName('image');
        $uploadResult = $fileUploaderService->upload();

        return $uploadResult;
    }

    private function makeThumb($photoPath)
    {
        $imageTranformationService = new ImageTranformationService();
        return $imageTranformationService->setImageLibrary('gd2')
            ->setSourceImage($photoPath)
            ->setCreateThumb(true)
            ->setMaintainRatio(true)
            ->setWidth(320)
            ->setHeight(240)
            ->setThumbMarker('_thumb_1')
            ->resize();

    }

    private function unlinkFile($filePath)
    {
        if (is_file($filePath)){
            unlink($filePath);
        }
    }
}
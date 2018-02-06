<?php

namespace Main\Service;

use Main\Service\UploadService;

class FileUploaderService
{
    /**
     * @var UploadService 
     */
    private $uploadService;
    /**
     * @var string
     */
    private $uploadPath;
    /**
     * @var string
     */
    private $allowedTypes;
    /**
     * @var string
     */
    private $allowedMimes;
    /**
     * @var int
     */
    private $maxSize;
    /**
     * @var bool
     */
    private $encryptName;
    /**
     * @var string
     */
    private $fileElementName;

    public function __construct()
    {
        $this->uploadService = new UploadService();
    }
    
    public function setPhotoRepository($photoRepository)
    {
        $this->photoRepository = $photoRepository;
        return $this;
    }

    public function setUploadService($uploadService)
    {
        $this->uploadService = $uploadService;
        return $this;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
        return $this;
    }

    public function setAllowedTypes($allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
        return $this;
    }

    public function setAllowedMimes($allowedMimes)
    {
        $this->allowedMimes = $allowedMimes;
        return $this;
    }

    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    public function setEncryptName($encryptName)
    {
        $this->encryptName = $encryptName;
        return $this;
    }
    
    public function setFileElementName($fileElementName)
    {
        $this->fileElementName = $fileElementName;
        return $this;
    }

    
    public function upload()
    {
        $config = [];
        $config['upload_path'] = PUBLIC_PATH.$this->uploadPath;
        $config['allowed_types'] = $this->allowedTypes;
        $config['mimes'] = $this->allowedMimes;
        $config['max_size'] = $this->maxSize;
        $config['encrypt_name'] = $this->encryptName;
        $this->uploadService->initialize($config);
        
        if (!$this->uploadService->doUpload($this->fileElementName)){
            return [
                'status' => 'error', 
                'message' => $this->uploadService->display_errors('', ''),
            ];
        } else {
            $data = $this->uploadService->data();
            return [
                'status' => 'success', 
                'file_path' => $this->uploadPath.$data['file_name'],
            ];
        }
    }
}

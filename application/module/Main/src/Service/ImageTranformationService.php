<?php

namespace Main\Service;

use Main\Service\ImageService;

class ImageTranformationService
{
    /**
     * @var ImageService 
     */
    private $imageService;
    /**
     * @var string - gd2, imagemagick, netpbm, gd
     */
    private $imageLibrary = 'gd2';
    /**
     * @var string
     */
    private $sourceImage;
    /**
     * @var bool
     */
    private $createThumb = true;
    /**
     * @var bool 
     */
    private $maintainRatio = true;
    /**
     * @var int
     */
    private $width = 200;
    /**
     * @var int
     */
    private $height = 200;
    /**
     * @param string
     */
    private $thumbMarker = '_thumb';

    public function __construct()
    {
        $this->imageService = new ImageService();
    }
    
    public function setImageService(ImageService $imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    public function setImageLibrary($imageLibrary)
    {
        $this->imageLibrary = $imageLibrary;
        return $this;
    }

    public function setSourceImage($sourceImage)
    {
        $this->sourceImage = $sourceImage;
        return $this;
    }

    public function setCreateThumb($createThumb)
    {
        $this->createThumb = $createThumb;
        return $this;
    }

    public function setMaintainRatio($maintainRatio)
    {
        $this->maintainRatio = $maintainRatio;
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    
    public function setThumbMarker($thumbMarker)
    {
        $this->thumbMarker = $thumbMarker;
        return $this;
    }

            
    public function resize()
    {
        $config = [];
        $config['image_library'] = $this->imageLibrary;
        $config['source_image'] = PUBLIC_PATH.$this->sourceImage;
        $config['create_thumb'] = $this->createThumb;
        $config['maintain_ratio'] = $this->maintainRatio;
        $config['width'] = $this->width;
        $config['height'] = $this->height;
        $config['thumb_marker'] = $this->thumbMarker;
        $this->imageService->initialize($config);
        
        if ($this->imageService->resize()){
            $sourceInfo = pathinfo($this->sourceImage);
            $dirName = $sourceInfo['dirname'];
            return [
                'status' => 'success', 
                'file_path' => $dirName.'/'.pathinfo($this->imageService->full_dst_path, PATHINFO_BASENAME),
            ];
        } else {
            return [
                'status' => 'error', 
                'message' => $this->imageService->display_errors('', ''),
            ];
        }
    }
}
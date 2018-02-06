<?php

namespace Api\Entity;

use Main\Entity\BaseEntity;

class Image extends BaseEntity
{
    /**
     * @var string | int
     */
    protected $id;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $path_thumb_1;

    /**
     * @var string
     */
    protected $path_thumb_2;

    /**
     * @var string
     */
    protected $path_thumb_3;

    /**
     * @var string
     */
    protected $path_thumb_4;

    /**
     * @var string
     */
    protected $path_thumb_5;

    /**
     * @var string
     */
    protected $created;

    /**
     * @var string
     */
    protected $updated;

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumb1()
    {
        return $this->path_thumb_1;
    }

    /**
     * @param string $path_thumb_1
     *
     * @return Image
     */
    public function setPathThumb1($path_thumb_1)
    {
        $this->path_thumb_1 = $path_thumb_1;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumb2()
    {
        return $this->path_thumb_2;
    }

    /**
     * @param string $path_thumb_2
     *
     * @return Image
     */
    public function setPathThumb2($path_thumb_2)
    {
        $this->path_thumb_2 = $path_thumb_2;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumb3()
    {
        return $this->path_thumb_3;
    }

    /**
     * @param string $path_thumb_3
     *
     * @return Image
     */
    public function setPathThumb3($path_thumb_3)
    {
        $this->path_thumb_3 = $path_thumb_3;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumb4()
    {
        return $this->path_thumb_4;
    }

    /**
     * @param string $path_thumb_4
     *
     * @return Image
     */
    public function setPathThumb4($path_thumb_4)
    {
        $this->path_thumb_4 = $path_thumb_4;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumb5()
    {
        return $this->path_thumb_5;
    }

    /**
     * @param string $path_thumb_5
     *
     * @return Image
     */
    public function setPathThumb5($path_thumb_5)
    {
        $this->path_thumb_5 = $path_thumb_5;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     *
     * @return Image
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param string $updated
     *
     * @return Image
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
}
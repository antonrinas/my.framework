<?php

namespace Api\Entity;

use Main\Entity\BaseEntity;

class Message extends BaseEntity
{
    /**
     * @var string | int
     */
    protected $id;
    /**
     * @var string | int
     */
    protected $from_user_id;
    /**
     * @var string | int
     */
    protected $to_user_id;
    /**
     * @var string
     */
    protected $content;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     * @return Message
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     * @return Message
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
     * @return Message
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
}
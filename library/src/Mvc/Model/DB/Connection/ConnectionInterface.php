<?php

namespace Framework\Mvc\Model\DB\Connection;


interface ConnectionInterface
{
    /**
     * @return mixed
     */
    public function getConnection();
}
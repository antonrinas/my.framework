<?php

namespace Framework\Mvc\Model;

use Framework\Mvc\Model\DB\TableAdapter\TableAdapterInterface;

interface ModelInterface
{
    /**
     * @return mixed
     */
    public function getConnection();

    /**
     * @return TableAdapterInterface
     */
    public function getTableAdapter();
}
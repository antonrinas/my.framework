<?php

namespace Framework\Mvc\Model;

use Framework\Mvc\Model\DB\TableAdapter\TableAdapterInterface;
use Framework\QueryBuilder\QueryBuilderInterface;

interface ModelInterface
{
    /**
     * @return TableAdapterInterface
     */
    public function getTableAdapter();

    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder();
}
<?php

namespace Main\Model;

use Framework\Mvc\Model\DB\TableAdapter\TableAdapterInterface;
use Framework\QueryBuilder\QueryBuilderInterface;
use Framework\Mvc\Model\ModelInterface;

class Base implements ModelInterface
{
    /**
     * @var TableAdapterInterface
     */
    protected $tableAdapter;

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    public function __construct(TableAdapterInterface $tableAdapter, QueryBuilderInterface $queryBuilder)
    {
        $this->tableAdapter = $tableAdapter;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return TableAdapterInterface
     */
    public function getTableAdapter()
    {
        return $this->tableAdapter;
    }

    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }
}
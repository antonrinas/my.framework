<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class WhereIsNotNull implements QueryPartInterface
{
    /**
     * @var string
     */
    private $columnName;

    public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [];
    }

    public function compileQueryPart()
    {
        $query  = "$this->columnName IS NOT NULL\n";

        return $query;
    }
}
<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class GroupBy implements QueryPartInterface
{
    /**
     * @var array
     */
    private $columns;

    public function __construct($columns)
    {
        $this->columns = $columns;
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
        $query  = implode(', ', $this->columns) . "\n";
        return $query;
    }
}
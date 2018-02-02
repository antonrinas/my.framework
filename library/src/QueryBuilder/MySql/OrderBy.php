<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class OrderBy implements QueryPartInterface
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
        $directions = [];
        foreach ($this->columns as $columnName => $direction) {
            $directions[] = $columnName . ' ' . $direction;
        }
        $query  = implode(', ', $directions) . "\n";
        return $query;
    }
}
<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class GroupBy implements QueryPartInterface
{
    /**
     * @var array
     */
    private $columns;

    /**
     * GroupBy constructor.
     *
     * @param array $columns
     */
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

    /**
     * @return string
     */
    public function compileQueryPart()
    {
        $query  = implode(', ', $this->columns) . "\n";
        return $query;
    }
}
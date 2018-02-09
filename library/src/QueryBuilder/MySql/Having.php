<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Having implements QueryPartInterface
{
    /**
     * @var string
     */
    private $condition;

    /**
     * Having constructor.
     *
     * @param string $condition
     */
    public function __construct($condition)
    {
        $this->condition = $condition;
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
        $query  = "$this->condition\n";

        return $query;
    }
}
<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Join implements QueryPartInterface
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $on;

    /**
     * @var string
     */
    private $type = 'INNER';

    /**
     * Join constructor.
     *
     * @param string $tableName
     * @param string $on
     * @param string $type
     */
    public function __construct($tableName, $on, $type)
    {
        $this->tableName = $tableName;
        $this->on = $on;
        $this->type = strtoupper($type);
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
        if ($this->type === 'INNER') {
            $query  = "INNER JOIN $this->tableName ON $this->on\n";
        }
        if ($this->type === 'LEFT') {
            $query  = "LEFT JOIN $this->tableName ON $this->on\n";
        }
        if ($this->type === 'RIGHT') {
            $query  = "RIGHT JOIN $this->tableName ON $this->on\n";
        }

        return $query;
    }
}
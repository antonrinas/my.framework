<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Select implements QueryPartInterface
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var string
     */
    private $distinct = '';

    public function __construct($tableName, $columns = [], $distinct = false)
    {
        $this->tableName = $tableName;
        $this->columns = $columns;
        if ($distinct){
            $this->distinct = 'DISTINCT';
        }
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
        $columns = '*';
        if ($this->columns){
            $columns  = implode(", ", $this->columns);
        }

        $query  = "SELECT $this->distinct $columns \nFROM $this->tableName \n";

        return $query;
    }
}
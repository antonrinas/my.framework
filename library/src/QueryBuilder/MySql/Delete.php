<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Delete implements QueryPartInterface
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * Delete constructor.
     *
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function compileQueryPart()
    {
        $query  = "DELETE FROM $this->tableName \n";

        return $query;
    }
}
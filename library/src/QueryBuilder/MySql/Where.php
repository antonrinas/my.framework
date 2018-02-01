<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Where implements QueryPartInterface
{
    /**
     * @var string
     */
    private $columnName;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var array
     */
    private $params = [];

    public function __construct($columnName, $value, $operator = '=')
    {
        $this->columnName = $columnName;
        $this->value = $value;
        $this->operator = $operator;

        $hash = md5($this->columnName . $this->value);
        $paramName = ':'.$this->columnName . '_' . $hash;
        $this->params[$paramName] = $this->value;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function compileQueryPart()
    {
        reset($this->params);
        $paramName = key($this->params);
        $query  = "$this->columnName $this->operator $paramName";

        return $query;
    }
}
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

    /**
     * Where constructor.
     *
     * @param string $columnName
     * @param int|string $value
     * @param string $operator
     * @param mixed $objectIndex
     */
    public function __construct($columnName, $value, $operator = '=', $objectIndex)
    {
        $this->columnName = $columnName;
        $this->value = $value;
        $this->operator = $operator;

        $changedColumnName = str_replace('.', '_', $columnName);
        $hash = md5( $columnName . $this->value. $objectIndex);
        $paramName = ':'.$changedColumnName . '_' . $hash;
        $this->params[$paramName] = $this->value;
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
        reset($this->params);
        $paramName = key($this->params);
        $query  = "$this->columnName $this->operator $paramName\n";

        return $query;
    }
}
<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class WhereBetween implements QueryPartInterface
{
    /**
     * @var string
     */
    private $columnName;

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $params = [];

    /**
     * WhereBetween constructor.
     *
     * @param string $columnName
     * @param string|int $leftValue
     * @param string|int $rightValue
     * @param mixed $objectIndex
     */
    public function __construct($columnName, $leftValue, $rightValue, $objectIndex)
    {
        $this->columnName = $columnName;
        $changedColumnName = str_replace('.', '_', $columnName);
        $hash = md5($columnName . $leftValue . 1 . $objectIndex);
        $paramName = ':'.$changedColumnName . '_' . $hash;
        $this->params[$paramName] = $leftValue;
        $hash = md5($columnName . $rightValue . 2 . $objectIndex);
        $paramName = ':'.$changedColumnName . '_' . $hash;
        $this->params[$paramName] = $rightValue;
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
        $params = array_keys($this->params);
        $query  = "($this->columnName BETWEEN $params[0] AND $params[1])\n";
        return $query;
    }
}
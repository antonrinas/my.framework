<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class WhereLike implements QueryPartInterface
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
     * @var array
     */
    private $params = [];

    public function __construct($columnName, $value, $percent, $objectIndex)
    {
        $this->columnName = $columnName;
        $this->value = '%' . $value . '%';
        if ($percent === 'left'){
            $this->value = '%' . $value;
        }
        if ($percent === 'right'){
            $this->value = $value . '%';
        }

        $changedColumnName = str_replace('.', '_', $columnName);
        $hash = md5($columnName . $this->value . $objectIndex);
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

    public function compileQueryPart()
    {
        reset($this->params);
        $paramName = key($this->params);
        $query  = "$this->columnName LIKE $paramName\n";

        return $query;
    }
}
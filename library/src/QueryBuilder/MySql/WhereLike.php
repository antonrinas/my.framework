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

    /**
     * WhereLike constructor.
     *
     * @param string $columnName
     * @param string|int $value
     * @param string $percent - 'left' or 'right' or none for both
     * @param $objectIndex
     */
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

    /**
     * @return string
     */
    public function compileQueryPart()
    {
        reset($this->params);
        $paramName = key($this->params);
        $query  = "$this->columnName LIKE $paramName\n";

        return $query;
    }
}
<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class WhereIn implements QueryPartInterface
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
     * WhereIn constructor.
     *
     * @param string $columnName
     * @param array $values
     * @param mixed $objectIndex
     */
    public function __construct($columnName, $values, $objectIndex)
    {
        $this->columnName = $columnName;
        $this->values = $values;
        $changedColumnName = str_replace('.', '_', $columnName);
        foreach ($values as $key => $value) {
            $hash = md5($columnName . $value . $key . $objectIndex);
            $paramName = ':'.$changedColumnName . '_' . $hash;
            $this->params[$paramName] = $value;
        }
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
        $query  = "$this->columnName IN (" . implode(', ', array_keys($this->params)) . ")\n";
        return $query;
    }
}
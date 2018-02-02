<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Update implements QueryPartInterface
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $sets;

    /**
     * @var array
     */
    private $params = [];

    public function __construct($tableName, $values, $objectIndex)
    {
        $this->tableName = $tableName;
        foreach ($values as $columnName => $value){
            $changedColumnName = str_replace('.', '_', $columnName);
            $hash = md5($columnName . $value . $objectIndex);
            $paramName = ':'.$changedColumnName . '_' . $hash;
            $this->params[$paramName] = $value;

            $this->sets[] = "$columnName = $paramName";
        }
        $this->values = $values;
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
        $query  = "UPDATE $this->tableName SET " . implode(", ", $this->sets) . "\n";

        return $query;
    }
}
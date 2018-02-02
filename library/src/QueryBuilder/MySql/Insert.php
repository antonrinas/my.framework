<?php

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Insert implements QueryPartInterface
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
    private $params = [];

    public function __construct($tableName, $values, $objectIndex)
    {
        $this->tableName = $tableName;
        foreach ($values as $columnName => $value){
            $columnName = str_replace('.', '_', $columnName);
            $hash = md5($columnName . $value . $objectIndex);
            $this->params[':'.$columnName . '_' . $hash] = $value;
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
        $columns = array_keys($this->values);

        $query  = "INSERT INTO $this->tableName (" . implode(", ", $columns) . ")\n".
                  "VALUES (" . implode(", ", array_keys($this->params)) . ")\n";

        return $query;
    }
}
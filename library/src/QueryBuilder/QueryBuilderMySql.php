<?php

namespace Framework\QueryBuilder;

use Framework\QueryBuilder\MySql\Insert;
use Framework\QueryBuilder\MySql\Update;
use Framework\QueryBuilder\MySql\Delete;
use Framework\QueryBuilder\MySql\Select;
use Framework\QueryBuilder\MySql\Where;
use Framework\QueryBuilder\MySql\WhereIsNull;
use Framework\QueryBuilder\MySql\WhereIsNotNull;
use Framework\QueryBuilder\MySql\WhereLike;
use Framework\QueryBuilder\MySql\WhereIn;
use Framework\QueryBuilder\MySql\WhereBetween;
use Framework\QueryBuilder\MySql\OrderBy;
use Framework\QueryBuilder\MySql\Join;
use Framework\QueryBuilder\MySql\GroupBy;
use Framework\QueryBuilder\MySql\Having;

class QueryBuilderMySql implements QueryBuilderInterface
{
    private $params = [];
    private $insert;
    private $update;
    private $delete;
    private $select;
    private $where = [];
    private $whereIsNull = [];
    private $whereIsNotNull = [];
    private $whereLike = [];
    private $whereIn = [];
    private $whereBetween = [];
    private $orderBy;
    private $join = [];
    private $groupBy;
    private $having = [];

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function insert($tableName, $values)
    {
        $insert = new Insert($tableName, $values);
        $params = $insert->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->insert = $insert;
    }

    public function update($tableName, $values)
    {
        $update = new Update($tableName, $values);
        $params = $update->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->update = $update;
    }

    public function delete($tableName)
    {
        $delete = new Delete($tableName);
        $this->delete = $delete;
    }

    public function select($tableName, $columns = [], $distinct = false)
    {
        $select = new Select($tableName, $columns, $distinct);
        $this->select = $select;

        print_r($select->compileQueryPart());exit();
    }

    public function where($columnName, $value, $operator = '=')
    {
        $where = new Where($columnName, $value, $operator);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;
    }

    public function whereIsNull($columnName)
    {
        $where = new WhereIsNull($columnName);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->whereIsNull[] = $where;

        print_r($where->compileQueryPart());exit();
    }

    public function whereIsNotNull($columnName)
    {
        $where = new WhereIsNotNull($columnName);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->whereIsNotNull[] = $where;
    }

    public function whereLike($columnName, $value, $percent = 'both')
    {

    }

    public function whereIn($columnName, $values)
    {

    }

    public function whereBetween($columnName, $leftValue, $rightValue)
    {

    }

    public function orderBy($columns)
    {

    }

    public function join($tableName, $on, $type = 'INNER')
    {

    }

    public function groupBy($columns)
    {

    }

    public function having($condition)
    {

    }
}
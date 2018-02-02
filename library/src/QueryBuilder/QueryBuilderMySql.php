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
use Framework\QueryBuilder\MySql\Limit;
use Framework\QueryBuilder\MySql\Having;

class QueryBuilderMySql implements QueryBuilderInterface
{
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var Insert
     */
    private $insert;
    /**
     * @var Update
     */
    private $update;
    /**
     * @var Delete
     */
    private $delete;
    /**
     * @var Select
     */
    private $select;
    /**
     * @var [Where]
     */
    private $where = [];
    /**
     * @var [OrderBy]
     */
    private $orderBy = [];
    /**
     * @var [Join]
     */
    private $join = [];
    /**
     * @var [GroupBy]
     */
    private $groupBy = [];
    /**
     * @var Limit
     */
    private $limit;
    /**
     * @var [Having]
     */
    private $having = [];
    /**
     * @var int
     */
    private $partsCounter = 0;

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function reset()
    {
        $this->params = [];
        $this->insert = null;
        $this->update = null;
        $this->delete = null;
        $this->select = null;
        $this->where = [];
        $this->orderBy = [];
        $this->join = [];
        $this->groupBy = [];
        $this->limit = null;
        $this->having = [];
        $this->partsCounter = 0;
    }

    /**
     * @return array
     */
    public function compileQuery()
    {
        $query = '';
        if ($this->insert){
            $query .= $this->insert->compileQueryPart();
        }
        if ($this->update){
            $query .= $this->update->compileQueryPart();
        }
        if ($this->delete){
            $query .= $this->delete->compileQueryPart();
        }
        if ($this->select){
            $query .= $this->select->compileQueryPart();
        }
        if ($this->join){
            foreach ($this->join as $join) {
                $query .= $join->compileQueryPart();
            }
        }
        if ($this->where){
            foreach ($this->where as $key => $where){
                if (is_string($where)){
                    continue;
                }
                $this->where[$key] = $where->compileQueryPart();
            }
            $query .= "WHERE " . implode("AND\n", $this->where);
        }
        if ($this->groupBy){
            foreach ($this->groupBy as $key => $groupBy){
                $this->groupBy[$key] = $groupBy->compileQueryPart();
            }
            $query .= "GROUP BY " . implode(", \n", $this->groupBy);
        }
        if ($this->orderBy){
            foreach ($this->orderBy as $key => $orderBy){
                $this->orderBy[$key] = $orderBy->compileQueryPart();
            }
            $query .= "ORDER BY " . implode(", \n", $this->orderBy);
        }
        if ($this->having){
            foreach ($this->having as $key => $having){
                $this->having[$key] = $having->compileQueryPart();
            }
            $query .= "HAVING " . implode("AND\n", $this->having);
        }
        if ($this->limit){
            $query .= $this->limit->compileQueryPart();
        }

        return [
            'query' => $query,
            'params' => $this->getParams(),
        ];
    }

    /**
     * @param string $tableName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function insert($tableName, $values)
    {
        $this->partsCounter++;
        $insert = new Insert($tableName, $values, $this->partsCounter);
        $params = $insert->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->insert = $insert;

        return $this;
    }

    /**
     * @param string $tableName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function update($tableName, $values)
    {
        $this->partsCounter++;
        $update = new Update($tableName, $values, $this->partsCounter);
        $params = $update->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->update = $update;

        return $this;
    }

    /**
     * @param string $tableName
     *
     * @return QueryBuilderInterface
     */
    public function delete($tableName)
    {
        $delete = new Delete($tableName);
        $this->delete = $delete;

        return $this;
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param bool $distinct
     *
     * @return QueryBuilderInterface
     */
    public function select($tableName, $columns = [], $distinct = false)
    {
        $select = new Select($tableName, $columns, $distinct);
        $this->select = $select;

        return $this;
    }

    /**
     * @param string $columnName
     * @param mixed $value
     * @param string $operator
     *
     * @return QueryBuilderInterface
     */
    public function where($columnName, $value, $operator = '=')
    {
        $this->partsCounter++;
        $where = new Where($columnName, $value, $operator, $this->partsCounter);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return QueryBuilderInterface
     */
    public function whereClause($clause)
    {
        $this->where[] = $clause;

        return $this;
    }

    /**
     * @param string $columnName
     *
     * @return QueryBuilderInterface
     */
    public function whereIsNull($columnName)
    {
        $where = new WhereIsNull($columnName);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param string $columnName
     *
     * @return QueryBuilderInterface
     */
    public function whereIsNotNull($columnName)
    {
        $where = new WhereIsNotNull($columnName);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param string $columnName
     * @param mixed $value
     * @param string $percent - 'both', 'left', 'right'
     *
     * @return QueryBuilderInterface
     */
    public function whereLike($columnName, $value, $percent = 'both')
    {
        $this->partsCounter++;
        $where = new WhereLike($columnName, $value, $percent, $this->partsCounter);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param string $columnName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function whereIn($columnName, $values)
    {
        $this->partsCounter++;
        $where = new WhereIn($columnName, $values, $this->partsCounter);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param string $columnName
     * @param mixed $leftValue
     * @param mixed $rightValue
     *
     * @return QueryBuilderInterface
     */
    public function whereBetween($columnName, $leftValue, $rightValue)
    {
        $this->partsCounter++;
        $where = new WhereBetween($columnName, $leftValue, $rightValue, $this->partsCounter);
        $params = $where->getParams();
        $this->params = array_merge_recursive($params, $this->params);
        $this->where[] = $where;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return QueryBuilderInterface
     */
    public function orderBy($columns)
    {
        $orderBy = new OrderBy($columns);
        $this->orderBy[] = $orderBy;

        return $this;
    }

    /**
     * @param string $tableName
     * @param string $on
     * @param string $type - 'INNER', 'LEFT', 'RIGHT'
     *
     * @return QueryBuilderInterface
     */
    public function join($tableName, $on, $type = 'INNER')
    {
        $join = new Join($tableName, $on, $type);
        $this->join[] = $join;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return QueryBuilderInterface
     */
    public function groupBy($columns)
    {
        $groupBy = new GroupBy($columns);
        $this->groupBy[] = $groupBy;

        return $this;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QueryBuilderInterface
     */
    public function limit($limit, $offset = 0)
    {
        $limit = new Limit($limit, $offset);
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return QueryBuilderInterface
     */
    public function having($condition)
    {
        $having = new Having($condition);
        $this->having[] = $having;

        return $this;
    }
}
<?php

namespace Framework\QueryBuilder;

interface QueryBuilderInterface
{
    /**
     * @return array
     */
    public function getParams();

    /**
     * @return array
     */
    public function compileQuery();

    /**
     * @return QueryBuilderInterface
     */
    public function reset();

    /**
     * @param string $tableName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function insert($tableName, $values);

    /**
     * @param string $tableName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function update($tableName, $values);

    /**
     * @param string $tableName
     *
     * @return QueryBuilderInterface
     */
    public function delete($tableName);

    /**
     * @param string $tableName
     * @param array $columns
     * @param bool $distinct
     *
     * @return QueryBuilderInterface
     */
    public function select($tableName, $columns, $distinct);

    /**
     * @param string $columnName
     * @param mixed $value
     * @param string $operator
     *
     * @return QueryBuilderInterface
     */
    public function where($columnName, $value, $operator);

    /**
     * @param string $clause
     *
     * @return QueryBuilderInterface
     */
    public function whereClause($clause);

    /**
     * @param string $columnName
     *
     * @return QueryBuilderInterface
     */
    public function whereIsNull($columnName);

    /**
     * @param string $columnName
     *
     * @return QueryBuilderInterface
     */
    public function whereIsNotNull($columnName);

    /**
     * @param string $columnName
     * @param mixed $value
     * @param string $percent - 'both', 'left', 'right'
     *
     * @return QueryBuilderInterface
     */
    public function whereLike($columnName, $value, $percent);

    /**
     * @param string $columnName
     * @param array $values
     *
     * @return QueryBuilderInterface
     */
    public function whereIn($columnName, $values);

    /**
     * @param string $columnName
     * @param mixed $leftValue
     * @param mixed $rightValue
     *
     * @return QueryBuilderInterface
     */
    public function whereBetween($columnName, $leftValue, $rightValue);

    /**
     * @param array $columns
     *
     * @return QueryBuilderInterface
     */
    public function orderBy($columns);

    /**
     * @param string $tableName
     * @param string $on
     * @param string $type - 'INNER', 'LEFT', 'RIGHT'
     *
     * @return QueryBuilderInterface
     */
    public function join($tableName, $on, $type);

    /**
     * @param array $columns
     *
     * @return QueryBuilderInterface
     */
    public function groupBy($columns);

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QueryBuilderInterface
     */
    public function limit($limit, $offset);

    /**
     * @param string $condition
     *
     * @return QueryBuilderInterface
     */
    public function having($condition);
}
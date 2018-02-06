<?php

namespace Main\Model;

class User extends Base
{
    protected $tableName = 'users';

    /**
     * @param array $params
     * @param array $columns
     *
     * @return bool|mixed
     */
    public function findByParams($params = [], $columns = ['*'])
    {
        if (!$params){
            return false;
        }
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, $columns);
        foreach ($params as $columnName => $value) {
            $queryBuilder->where($columnName, $value);
        }
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetch($queryBuilderResult['query'], $queryBuilderResult['params']);
    }
}
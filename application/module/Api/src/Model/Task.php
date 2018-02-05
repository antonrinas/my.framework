<?php

namespace Api\Model;

use Main\Model\Base;

class Task extends Base
{
    protected $tableName = 'tasks';

    public function fetchAllByFilters($filters)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, ['*'])
                     ->limit($filters['limit'], $filters['offset']);
        if ($filters['sortBy'] && $filters['sortDesc']){
            $queryBuilder->orderBy([$filters['sortBy'] => $filters['sortDesc']]);
        }
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetchAll($queryBuilderResult['query'], $queryBuilderResult['params'], true);
    }
}
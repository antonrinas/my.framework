<?php

namespace Api\Model;

use Main\Model\Base;

class Task extends Base
{
    protected $tableName = 'tasks';

    /**
     * @param array $filters
     *
     * @return mixed
     */
    public function fetchAllByFilters($filters)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, [
            'tasks.id AS id',
            'tasks.user_name AS user_name',
            'tasks.email AS email',
            'tasks.description AS description',
            'tasks.image_id AS image_id',
            'tasks.status AS status',
            'tasks.created AS created',
            'tasks.created AS updated',
            'images.path AS path',
            'images.path_thumb_1 AS path_thumb_1',
        ])->join('images', 'tasks.image_id = images.id', 'LEFT')
          ->limit($filters['limit'], $filters['offset']);

        if ($filters['sortBy'] && $filters['sortDesc']){
            $queryBuilder->orderBy([$filters['sortBy'] => $filters['sortDesc']]);
        }
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetchAll($queryBuilderResult['query'], $queryBuilderResult['params'], true);
    }
}
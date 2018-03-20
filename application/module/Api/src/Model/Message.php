<?php

namespace Api\Model;

use Main\Model\Base;

class Message extends Base
{
    protected $tableName = 'messages';

    /**
     * @param array $filters
     *
     * @return mixed
     */
    public function fetchAllByFilters($filters)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, [
            'messages.id AS id',
            'messages.from_user_id AS from_user_id',
            'messages.content AS content',
            'messages.created AS created',
            'users.name AS user_name',
        ])->join('users', 'messages.from_user_id = users.id', 'LEFT')
            ->orderBy(['messages.created' => 'DESC'])
            ->limit($filters['limit'], $filters['offset']);
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetchAll($queryBuilderResult['query'], $queryBuilderResult['params'], true);
    }
}
<?php

namespace Main\Model;

use Framework\Mvc\Model\DB\TableAdapter\TableAdapterInterface;
use Framework\QueryBuilder\QueryBuilderInterface;
use Framework\Mvc\Model\ModelInterface;
use Main\Entity\EntityInterface;
use Main\Exception\ModelException;

class Base implements ModelInterface, BaseModelInterface
{
    protected $tableName;
    protected $primaryKey = 'id';
    protected $asArray = false;

    /**
     * @var TableAdapterInterface
     */
    protected $tableAdapter;

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    public function __construct(TableAdapterInterface $tableAdapter, QueryBuilderInterface $queryBuilder)
    {
        $this->tableAdapter = $tableAdapter;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return TableAdapterInterface
     */
    public function getTableAdapter()
    {
        return $this->tableAdapter;
    }

    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param bool $asArray
     *
     * @return Base
     */
    public function setAsArray($asArray)
    {
        $this->asArray = $asArray;
        return $this;
    }

    /**
     * @return int
     */
    public function countAll()
    {

    }

    /**
     * @param mixed $id
     * @param array $columns
     *
     * @return EntityInterface | null
     */
    public function find($id, $columns = ['*'])
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, $columns)
                     ->where($this->primaryKey, $id);
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetch($queryBuilderResult['query'], $queryBuilderResult['params']);
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return [EntityInterface]|[]
     */
    public function fetchAll($limit = null, $offset = 0, $asArray = false)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select($this->tableName, ['*']);
        if ($limit){
            $queryBuilder->limit($limit, $offset);
        }
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();

        return $this->getTableAdapter()->fetchAll($queryBuilderResult['query'], $queryBuilderResult['params'], $asArray);
    }

    /**
     * @param EntityInterface $entity
     *
     * @return int|mixed
     *
     * @throws ModelException
     */
    public function save(EntityInterface $entity)
    {
        $data = $entity->getArrayCopy();
        $queryBuilder = $this->getQueryBuilder();
        if (array_key_exists($this->primaryKey, $data)){
            $id = $data[$this->primaryKey] ? $data[$this->primaryKey] : 0;
        } else {
            $id = 0;
        }
        if (array_key_exists($this->primaryKey, $data)){
            unset($data[$this->primaryKey]);
        }

        if (!$id) {
            $queryBuilder->insert($this->tableName, $data);
            $queryBuilderResult = $queryBuilder->compileQuery();
            $queryBuilder->reset();
            $this->getTableAdapter()->execute($queryBuilderResult['query'], $queryBuilderResult['params']);
            return $this->getTableAdapter()->retrieveLastInsertId();

        }
        if ($this->find($id, [$this->primaryKey])){
            $queryBuilder->update($this->tableName, $data)->where($this->primaryKey, $id);
            $queryBuilderResult = $queryBuilder->compileQuery();
            $queryBuilder->reset();
            $this->getTableAdapter()->execute($queryBuilderResult['query'], $queryBuilderResult['params']);
        } else {
            throw new ModelException(sprintf("Row with ID '%s' was not found in '%s'",
                $id,
                $this->tableName
            ));
        }

        return $id;
    }

    /**
     * @param mixed $id
     */
    public function delete($id)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->tableName)->where($this->primaryKey, $id);
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();
        $this->getTableAdapter()->execute($queryBuilderResult['query'], $queryBuilderResult['params']);
    }
}
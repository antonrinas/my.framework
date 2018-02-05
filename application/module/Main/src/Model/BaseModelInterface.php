<?php

namespace Main\Model;

use Main\Entity\EntityInterface;

interface BaseModelInterface
{
    /**
     * @param bool $asArray
     *
     * @return BaseModelInterface
     */
    public function setAsArray($asArray);

    /**
     * @return int
     */
    public function countAll();

    /**
     * @param mixed $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns);

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return [EntityInterface]|[]
     */
    public function fetchAll($limit, $offset);

    /**
     * @param EntityInterface $entity
     *
     * @return mixed
     */
    public function save(EntityInterface $entity);

    /**
     * @param mixed $id
     */
    public function delete($id);
}
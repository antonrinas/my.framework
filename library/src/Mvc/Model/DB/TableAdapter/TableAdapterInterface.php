<?php

namespace Framework\Mvc\Model\DB\TableAdapter;


interface TableAdapterInterface
{
    public function getConnection();

    /**
     * Fetch single row and return it as an Object or array
     *
     * @param string $sql
     * @param array $params
     * @param bool $asArray
     *
     * @return mixed
     */
    public function fetch($sql, $params, $asArray);

    /**
     * Fetch all rows and return it as array of objects or arrays
     *
     * @param string $sql
     * @param array $params
     * @param bool $asArray
     *
     * @return mixed
     */
    public function fetchAll($sql, $params, $asArray);

    /**
     * @param string $sql
     * @param array $params
     */
    public function execute($sql, $params);

    /**
     * @return mixed
     */
    public function retrieveLastInsertId();
}
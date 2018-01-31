<?php

namespace Framework\Mvc\Model\DB\TableAdapter;


interface TableAdapterInterface
{
    public function getConnection();

    /**
     * Fetch single row and return it as an Object
     *
     * @param string $sql
     */
    public function fetch($sql);

    /**
     * Fetch all rows and return it as array of objects
     *
     * @param string $sql
     */
    public function fetchAll($sql);

    /**
     * @param string $sql
     */
    public function execute($sql);
}
<?php

namespace Framework\Mvc\Model\DB\TableAdapter;

use \PDO;

class MySqlPdoTableAdapter implements TableAdapterInterface
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var string
     */
    private $entityClassName;

    /**
     * @param PDO $connection
     * @param string $entityClassName
     */
    public function __construct($connection, $entityClassName)
    {
        $this->connection = $connection;
        $this->entityClassName = $entityClassName;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param bool $asArray
     *
     * @return $this->entityClassName
     */
    public function fetch($sql, $params = [], $asArray = false)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($asArray){
            return $stmt->fetchAll();
        }

        return $stmt->fetchObject($this->entityClassName);
    }

    /**
     * @param string $sql
     * @param array $params
     * @param bool $asArray
     *
     * @return array
     */
    public function fetchAll($sql, $params = [], $asArray = false)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($asArray){
            return $stmt->fetchAll();
        }

        $result = [];
        do {
            $row = $stmt->fetchObject($this->entityClassName);
            if ($row){
                $result[] = $row;
            }
        } while ($row);

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     */
    public function execute($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * @return mixed
     */
    public function retrieveLastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
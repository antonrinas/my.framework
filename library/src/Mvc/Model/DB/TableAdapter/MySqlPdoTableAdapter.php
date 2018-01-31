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
     *
     * @return $this->entityClassName
     */
    public function fetch($sql)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchObject($this->entityClassName);
    }

    /**
     * @param string $sql
     *
     * @return array
     */
    public function fetchAll($sql)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

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
     */
    public function execute($sql)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}
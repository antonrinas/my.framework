<?php

namespace Framework\Mvc\Model\DB\Connection;

use \PDO;

class MySqlPdoConnection implements ConnectionInterface
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct($config)
    {
        $this->checkConfig($config);
        $this->connection = new PDO(
            "mysql:host=" . $config['db_host'] . ";dbname=" . $config['bd_name'],
            $config['bd_user'],
            $config['db_password']
        );
        $this->connection->exec("SET NAMES UTF8");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    private function checkConfig($config)
    {
        if (!array_key_exists('bd_name', $config)){
            throw new ConnectionException("Database name setting is required. You must provide 'bd_name' key in the 'mysql' config.");
        }
        if (!array_key_exists('bd_user', $config)){
            throw new ConnectionException("Database user setting is required. You must provide 'bd_user' key in the 'mysql' config.");
        }
        if (!array_key_exists('db_password', $config)){
            throw new ConnectionException("Database password setting is required. You must provide 'db_password' key in the 'mysql' config.");
        }
        if (!array_key_exists('db_host', $config)){
            throw new ConnectionException("Database host setting is required. You must provide 'db_host' key in the 'mysql' config.");
        }
    }
}
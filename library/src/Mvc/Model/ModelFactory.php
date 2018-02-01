<?php

namespace Framework\Mvc\Model;

use Framework\Mvc\Model\DB\Connection\MySqlPdoConnection;
use Framework\Mvc\Model\DB\TableAdapter\MySqlPdoTableAdapter;

class ModelFactory
{
    private $modelClassName;
    private $entityClassName;

    /**
     * @param string $modelClassName
     * @param string $entityClassName
     */
    public function __construct($modelClassName, $entityClassName)
    {
        $this->modelClassName = $modelClassName;
        $this->entityClassName = $entityClassName;
    }

    /**
     * @param string $modelClassName
     * @param string $entityClassName
     */
    public static function init($modelClassName, $entityClassName)
    {
        return new ModelFactory($modelClassName, $entityClassName);
    }

    /**
     * @return ModelInterface
     *
     * @throws ModelException
     */
    public function retrieveModel()
    {
        $dbConfig = require(ROOT . DS . 'config' . DS . 'db.php');
        $this->checkConfig($dbConfig);
        $defaultConnection = $dbConfig['db']['default'];
        if ($defaultConnection === 'mysql'){
            $mySqlPdoConnection = new MySqlPdoConnection($dbConfig['db']['mysql']);
            $connection = $mySqlPdoConnection->getConnection();
            $tableAdapter = new MySqlPdoTableAdapter($connection, $this->entityClassName);
            $modelClassName = $this->modelClassName;

            return new $modelClassName($tableAdapter);
        }

        throw new ModelException(
            sprintf("Connection type '%s' is not supported.",
                $defaultConnection
            )
        );
    }

    private function checkConfig($config)
    {
        if (!array_key_exists('db', $config)){
            throw new ModelException("Database settings is required. You must provide 'db' key in the config.");
        }
        if (!array_key_exists('default', $config['db'])){
            throw new ModelException("Default database settings is required. You must provide 'default' key in the 'db' config.");
        }

        if (!array_key_exists($config['db']['default'], $config['db'])){
            throw new ModelException(
                sprintf("Default database settings is required. You must provide '%s' key in the 'db' config.",
                    $config['db']['default']
                )
            );
        }
        if (!$config['db'][$config['db']['default']]){
            throw new ModelException(
                sprintf("Default database settings is required. You must provide settings key '%s' in the 'db' config.",
                    $config['db']['default']
                )
            );
        }
    }
}
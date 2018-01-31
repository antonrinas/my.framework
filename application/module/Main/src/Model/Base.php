<?php

namespace Main\Model;

use Framework\Mvc\Model\DB\TableAdapter\TableAdapterInterface;

class Base
{
    /**
     * @var TableAdapterInterface
     */
    private $tableAdapter;

    public function __construct(TableAdapterInterface $tableAdapter)
    {
        $this->tableAdapter = $tableAdapter;
    }

    /**
     * @return TableAdapterInterface
     */
    public function getTableAdapter()
    {
        return $this->tableAdapter;
    }
}
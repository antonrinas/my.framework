<?php
/**
 * Created by PhpStorm.
 * User: админ
 * Date: 02.02.2018
 * Time: 14:12
 */

namespace Framework\QueryBuilder\MySql;

use Framework\QueryBuilder\QueryPartInterface;

class Limit implements QueryPartInterface
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * Limit constructor.
     * @param int $limit
     * @param int $offset
     */
    public function __construct($limit, $offset = 0)
    {
        $this->limit = (int) $limit;
        $this->offset = (int) $offset;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [];
    }

    /**
     * @return string
     */
    public function compileQueryPart()
    {
        $query  = "LIMIT $this->limit OFFSET $this->offset\n";

        return $query;
    }
}
<?php

namespace Framework\QueryBuilder;

interface QueryPartInterface
{
    /**
     * @return string
     */
    public function compileQueryPart();

    /**
     * @return array
     */
    public function getParams();
}
<?php

namespace Main\Entity;

interface EntityInterface
{
    /**
     * @param array $data
     */
    public function exchangeArray($data);

    /**
     * @return array
     */
    public function getArrayCopy();
}
<?php

namespace Main\Entity;

interface EntityInterface
{
    /**
     * Retrieve protected and public entity properties
     *
     * @return array
     */
    public function getArrayCopy();

    /**
     * @param array $data - [$propertyName => $value, ...]
     *
     * @return EntityInterface
     */
    public function exchangeArray($data);
}
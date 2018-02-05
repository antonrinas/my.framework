<?php

namespace Main\Entity;

class BaseEntity implements EntityInterface
{
    /**
     * Retrieve protected and public entity properties
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @param array $data - [$propertyName => $value, ...]
     *
     * @return EntityInterface
     */
    public function exchangeArray($data)
    {
        foreach ($data as $propertyName => $value) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }

        return $this;
    }
}
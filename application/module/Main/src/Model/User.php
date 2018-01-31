<?php

namespace Main\Model;

class User extends Base
{
    public function fetchAll()
    {
        $sql = "SELECT * FROM `users`";
        return $this->getTableAdapter()->fetchAll($sql);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = " . $id;
        return $this->getTableAdapter()->fetch($sql);
    }
}
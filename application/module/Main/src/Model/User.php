<?php

namespace Main\Model;

class User extends Base
{
    public function testQueryBuilder()
    {
        /*
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select('users', ['*'])
                     ->where('id', 2)
                     ->where('email', 'anton.rinas@gmail.com')
                     ->orderBy(['id' => 'ASC']);
        $queryBuilder->insert('users', [
            'name' => 'Тест',
            'email' => 'test@gmail.com',
            'password' => 'asdgsdgasdkgwqtk;lqwekt;wqekt;lqwekt;lqwetk;qwet;q;w',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $queryBuilder->update('users', [
            'name' => 'Тест1',
            'email' => 'test1@gmail.com',
            'password' => '111asdgsdgasdkgwqtk;lqwekt;wqekt;lqwekt;lqwetk;qwet;q;w',
            'updated_at' => date('Y-m-d H:i:s'),
        ])->where('users.id', 3);
        $queryBuilder->select('users', ['*'])->limit(2, 1);
        $queryBuilder->select('users', ['*'])
                     ->whereBetween('created_at', '2018-01-16', '2018-01-20')
                     ->orderBy(['id' => 'DESC']);

        $queryBuilderResult = $queryBuilder->compileQuery();
        $result = $this->getTableAdapter()->fetchAll($queryBuilderResult['query'], $queryBuilderResult['params']);
        
        print_r($result);exit();
        */
    }
}
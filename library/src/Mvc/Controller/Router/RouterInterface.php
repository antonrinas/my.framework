<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 29.01.2018
 * Time: 22:47
 */

namespace Framework\Mvc\Controller\Router;


interface RouterInterface
{
    /**
     * @return array
     */
    public function getGetParams();

    /**
     * @return array
     */
    public function getParams();

    /**
     * @return array
     */
    public function getMatchedRoute();
}
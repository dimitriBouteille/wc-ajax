<?php

namespace Dbout\WcAjax\Facades;

/**
 * Class AbstractFacade
 * @package Dbout\WcAjax\Facades
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractFacade
{

    /**
     * @return mixed
     */
    protected abstract static function getInstance();

    /**
     * @param $name
     * @param $arguments
     * @return null
     */
    public static function __callStatic($name, $arguments)
    {
        $instance = static::getInstance();
        if($instance) {
            return $instance->{$name}(...$arguments);
        }

        return null;
    }

}
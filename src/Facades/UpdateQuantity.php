<?php

namespace Dbout\WcAjax\Facades;

/**
 * Class UpdateQuantity
 * @package Dbout\WcAjax\Facades
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class UpdateQuantity extends AbstractActionFacade
{

    /**
     * @return \Dbout\WcAjax\Actions\Cart\UpdateQuantity|mixed
     */
    protected static function getInstance()
    {
        return \Dbout\WcAjax\Actions\Cart\UpdateQuantity::getInstance();
    }

}
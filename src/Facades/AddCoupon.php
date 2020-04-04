<?php

namespace Dbout\WcAjax\Facades;

/**
 * Class AddCoupon
 * @package Dbout\WcAjax\Facades
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class AddCoupon extends AbstractActionFacade
{

    /**
     * @return \Dbout\WcAjax\Actions\Cart\AddCoupon|mixed
     */
    protected static function getInstance()
    {
        return \Dbout\WcAjax\Actions\Cart\AddCoupon::getInstance();
    }

}
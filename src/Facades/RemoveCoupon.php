<?php


namespace Dbout\WcAjax\Facades;

/**
 * Class RemoveCoupon
 * @package Dbout\WcAjax\Facades
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class RemoveCoupon extends AbstractActionFacade
{

    /**
     * @return \Dbout\WcAjax\Actions\Cart\RemoveCoupon|mixed
     */
    protected static function getInstance()
    {
        return \Dbout\WcAjax\Actions\Cart\RemoveCoupon::getInstance();
    }

}
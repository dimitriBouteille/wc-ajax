<?php

namespace Dbout\WcAjax\Facades;

use \Dbout\WcAjax\WcAjax as WcAjaxInstance;

/**
 * Class WcAjax
 * @package Dbout\WcAjax\Facades
 *
 * @method static WcAjaxInstance register()
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WcAjax extends AbstractFacade
{

    /**
     * @return WcAjaxInstance|mixed
     */
    protected static function getInstance()
    {
        return WcAjaxInstance::getInstance();
    }

}
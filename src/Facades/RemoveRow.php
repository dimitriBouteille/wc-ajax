<?php

namespace Dbout\WcAjax\Facades;

/**
 * Class RemoveRow
 * @package Dbout\WcAjax\Facades
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class RemoveRow extends AbstractActionFacade
{

    /**
     * @return \Dbout\WcAjax\Actions\Cart\RemoveRow|mixed
     */
    protected static function getInstance()
    {
        return \Dbout\WcAjax\Actions\Cart\RemoveRow::getInstance();
    }

}
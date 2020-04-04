<?php

namespace Dbout\WcAjax\Actions;

/**
 * Interface InterfaceAction
 * @package Dbout\WcAjax\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
interface InterfaceAction
{

    /**
     * Function getAction
     * Get ajax action name
     *
     * @return string
     */
    public function getAction(): string;

}
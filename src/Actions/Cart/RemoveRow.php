<?php

namespace Dbout\WcAjax\Actions\Cart;

use Dbout\WcAjax\Actions\AbstractAction;
use Dbout\WcAjax\Response\Response;
use Dbout\WcAjax\Response\ResponseInterface;

/**
 * Class RemoveRow
 * @package Dbout\WcAjax\Actions\Cart
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class RemoveRow extends AbstractAction
{

    protected $action = 'dbout_wc_ajax_cart_remove_product';
    protected $nonceName = 'dbout_wc_ajax_cart_remove_product_nonce';

    /**
     * @return ResponseInterface
     */
    protected function execute(): ResponseInterface
    {
        $response = new Response();
        $cartItemKey = $_REQUEST['key'] ?? null;

        if(is_null($cartItemKey) || !WC()->cart->remove_cart_item($cartItemKey)) {
            return $this->errorFilter(
                $response->setError("Impossible de supprimer ce produit du panier, veuillez réessayer."),
                'cant_remove'
            );
        }

        return $this->successFilter($response->setCode(200));
    }

}
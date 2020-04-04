<?php

namespace Dbout\WcAjax\Actions\Cart;

use Dbout\WcAjax\Actions\AbstractAction;
use Dbout\WcAjax\Response\Response;
use Dbout\WcAjax\Response\ResponseInterface;

/**
 * Class UpdateQuantity
 * @package Dbout\WcAjax\Actions\Cart
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class UpdateQuantity extends AbstractAction
{

    protected $action = 'dbout_wc_ajax_cart_update_quantity';
    protected $nonceName = 'dbout_wc_ajax_cart_update_quantity_nonce';

    /**
     * @return ResponseInterface
     */
    protected function execute(): ResponseInterface
    {
        $response = new Response();
        $newQuantity = $_REQUEST['quantity'] ?? null;
        $key = $_REQUEST['key'] ?? null;

        if(empty($key) || !is_numeric($newQuantity)) {
            return $this->errorFilter(
                $response->setError(__("Impossible de mettre à jour la quantité de ce produit.")),
                'invalid_data'
            );
        }

        /** @var \WC_Cart $cart */
        $cart = WC()->cart;
        $cartContent = $cart->cart_contents;
        if(!key_exists($key, $cartContent)) {
            return $this->errorFilter(
                $response->setError(__("Impossible de mettre à jour la quantité de ce produit. Le produit n'est pas dans le panier.")),
                'not_in_cart'
            );
        }

        $cartItem = $cartContent[$key];
        /** @var \WC_Product $product */
        $product = apply_filters( 'woocommerce_cart_item_product', $cartItem['data'], $cartItem, $key);
        if(!$product || !$product->exists()) {
            return $this->errorFilter(
                $response->setError(__("Impossible de mettre à jour la quantité de ce produit. Le produit n'existe pas.")),
                'product_not_exists'
            );
        }

        if(!$product->is_in_stock()) {
            return $this->errorFilter(
                $response->setError(__("Impossible de mettre à jour la quantité de ce produit. Le produit n'est plus en stock. Veuillez supprimer le produit du panier.")),
                'out_of_stock'
            );
        }

        $maxQuantity = $product->get_max_purchase_quantity();
        if($newQuantity > $maxQuantity) {
            return $this->errorFilter(
                $response->setError(__(sprintf("Impossible de mettre à jour la quantité de ce produit. La quantité dépasse le stock disponible pour ce produit. Veuillez diminuer la quantité jusqu'à atteindre %s.", $maxQuantity))),
                    'max_quantity_limit'
            );
        }
        
        $cart->set_quantity($key, $newQuantity);
        return $this->successFilter($response->setCode(200));
    }

}
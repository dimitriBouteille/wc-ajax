<?php

namespace Dbout\WcAjax\Actions\Cart;

use Dbout\WcAjax\Actions\AbstractAction;
use Dbout\WcAjax\Response\Response;
use Dbout\WcAjax\Response\ResponseInterface;

/**
 * Class CartAddCoupon
 * @package Dbout\WcAjax\Actions\Cart
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class AddCoupon extends AbstractAction
{

    protected $action = 'dbout_wc_ajax_cart_add_coupon';
    protected $nonceName = 'dbout_wc_ajax_cart_add_coupon_nonce';

    /**
     * @return ResponseInterface
     */
    protected function execute(): ResponseInterface
    {
        $response = new Response();
        $cartWC = WC()->cart;

        if($cartWC->get_cart_contents_count() < 1) {
            return $this->errorFilter(
                $response->setError(__("Impossible d'ajouter un code promo, votre panier est vide.")),
                'empty_cart'
            );
        }

        $couponId = $_REQUEST['coupon'] ?? null;
        if(is_null($couponId)) {
            return $this->errorFilter(
                $response->setError(__("Impossible de trouver le code promo à ajouter, veuillez réessayer.")),
                'empty_coupon'
            );
        }
        if($cartWC->has_discount($couponId)) {
            return $this->errorFilter(
                $response->setError(__("Impossible d'ajouter le code promo, il est déjà présent dans votre panier.")),
                'already_in_cart'
            );
        }
        if(!$cartWC->add_discount($couponId)) {
            return $this->errorFilter(
                $response->setError(__("Impossible d'ajouter le code promo. Le code promo est peut-être invalide, veuillez réessayer.")),
                'add_error'
            );
        }

        return $this->successFilter($response->setCode(200), new \WC_Coupon($couponId));
    }

}
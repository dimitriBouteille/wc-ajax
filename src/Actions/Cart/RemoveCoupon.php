<?php

namespace Dbout\WcAjax\Actions\Cart;

use Dbout\WcAjax\Actions\AbstractAction;
use Dbout\WcAjax\Response\Response;
use Dbout\WcAjax\Response\ResponseInterface;

/**
 * Class RemoveCoupon
 * @package Dbout\WcAjax\Actions\Cart
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class RemoveCoupon extends AbstractAction
{

    protected $action = 'dbout_wc_ajax_cart_remove_coupon';
    protected $nonceName = 'dbout_wc_ajax_cart_remove_coupon_nonce';

    /**
     * @return ResponseInterface
     */
    protected function execute(): ResponseInterface
    {
        $response = new Response();

        $cartWC = WC()->cart;
        $couponId = $_REQUEST['coupon'] ?? null;
        if(!key_exists($couponId, $cartWC->get_coupons())) {
            return $this->errorFilter(
                $response->setError(__("Impossible de supprimer le code promo, le code n'existe pas dans votre panier.")),
                'not_in_cart'
            );
        }

        $cartWC->remove_coupon($couponId);
        $cartWC->calculate_totals();

        return $this->successFilter($response->setCode(200));
    }

}
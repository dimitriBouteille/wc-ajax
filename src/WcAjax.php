<?php

namespace Dbout\WcAjax;

use Dbout\WcAjax\Actions\Cart\AddCoupon;
use Dbout\WcAjax\Actions\Cart\RemoveCoupon;
use Dbout\WcAjax\Actions\Cart\RemoveRow;
use Dbout\WcAjax\Actions\InterfaceAction;
use Dbout\WcAjax\Exceptions\WcAjaxException;

/**
 * Class WcAjax
 * @package Dbout\WcAjax
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WcAjax
{

    /**
     * @var $this
     */
    private static $instance = null;

    /**
     * WpAjax constructor.
     */
    private function __construct() { }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if(self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Save all actions in Wordpress
     *
     * @throws WcAjaxException
     * @return void
     */
    public function register(): void
    {
        if(!$this->wcIsEnable()) {
            throw new WcAjaxException(__('Woocommerce plugin is not enabled on the site.'));
        }

        $this->registerAction(AddCoupon::getInstance());
        $this->registerAction(RemoveCoupon::getInstance());
        $this->registerAction(RemoveRow::getInstance());

        $this->loadHelpers();
    }

    /**
     * Add wp_ajax_ &  wp_ajax_nopriv_ actions
     *
     * @param InterfaceAction $action
     */
    protected function registerAction(InterfaceAction $action): void
    {
        $callback = [$action, 'dispatch'];
        add_action('wp_ajax_'. $action->getAction(), $callback);
        add_action('wp_ajax_nopriv_'. $action->getAction(), $callback);
    }

    /**
     * Check if Woocommerce plugin exist
     *
     * @return bool
     */
    protected function wcIsEnable(): bool
    {
        return class_exists('woocommerce') && function_exists('WC');
    }

    /**
     * Include helper files
     */
    protected function loadHelpers(): void
    {
        $this->include('/helpers/functions.php');
    }

    /**
     * @param string $path
     */
    protected function include(string $path): void
    {
        $path = __DIR__ . $path;
        if(file_exists($path)) {
            require_once $path;
        }
    }

}
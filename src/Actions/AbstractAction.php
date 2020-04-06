<?php

namespace Dbout\WcAjax\Actions;

use Dbout\WcAjax\Response\Response;
use Dbout\WcAjax\Response\ResponseInterface;

/**
 * Class AbstractAction
 * @package Dbout\WcAjax\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractAction implements InterfaceAction
{

    /**
     * Action name
     * ie: my_action
     *
     * @var string
     */
    protected $action;

    /**
     * Nonce name
     * ie: my_action_nonce
     *
     * @var string
     */
    protected $nonceName;

    /**
     * Nonce field name
     * ie : _token
     *
     * @var string
     */
    protected $nonceFieldName = 'wc_ajax_token';

    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getNonceName(): string
    {
        return $this->nonceName;
    }

    /**
     * @return string
     */
    public function getNonceFieldName(): string
    {
        return $this->nonceFieldName;
    }

    /**
     * Create and get nonce value
     *
     * @return string
     */
    public function getNonceValue(): string
    {
        return wp_create_nonce($this->nonceName);
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

    /**
     * Create action and nonce fields
     *
     * @return string
     */
    public function renderFields(): string
    {
        $values = [
            'action' => $this->action,
            $this->nonceFieldName => $this->getNonceValue(),
        ];

        $html = [];
        foreach ($values as $name => $value) {
            $html[] = sprintf('<input type="hidden" name="%s" value="%s">', $name, $value);
        }

        return implode('', $html);
    }

    /**
     * Execute action and send response
     *
     * @return void
     */
    public function dispatch(): void
    {
        $response = new Response();
        if(!wp_verify_nonce($_REQUEST[$this->nonceFieldName], $this->nonceName)) {
            $response->setError(__("Le formulaire n'est pas valide. Veuillez rafraichir la page pour tenter de corriger le problème. Si le problème persiste, veuillez réessayer dans quelques instants."));
            $response = apply_filters('wc_ajax_invalid_nonce', $response, $this->action);
        } else {
            $response = $this->execute();
            $response = apply_filters('wc_ajax_response_' . $this->action, $response);
        }

        $quantity = WC()->cart->get_cart_contents_count();
        $defaultResponse = apply_filters('wc_ajax_common_response', ['common' => [
            'totalPrice' => WC()->cart->get_cart_total(),
            'subPrice' =>   WC()->cart->get_cart_subtotal(),
            'quantity' =>   $quantity,
            'isEmpty' => $quantity <= 0,
        ]]);

        if(is_array($defaultResponse)) {
            $response->addData($defaultResponse);
        }

        $this->sendResponse($response);
    }

    /**
     * @return ResponseInterface
     */
    protected abstract function execute(): ResponseInterface;

    /**
     * Send response
     *
     * @param ResponseInterface $response
     */
    protected function sendResponse(ResponseInterface $response)
    {
        // If the user wants to change the answer before sending it
        $response = apply_filters('wc_ajax_before_send_response', $response, $this->action);

        // Remove error or success message
        wc_clear_notices();

        wp_send_json($response->toArray(), $response->getCode());
        die;
    }

    /**
     * Call wc_ajax_success_{ACTION} filter
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function successFilter(ResponseInterface $response): ResponseInterface
    {
        return apply_filters('wc_ajax_success_'.$this->action, $response);
    }

    /**
     * Call wc_ajax_error_{ACTION} filter
     *
     * @param ResponseInterface $response
     * @param string $errorCode
     * @return ResponseInterface
     */
    protected function errorFilter(ResponseInterface $response, string $errorCode): ResponseInterface
    {
        return apply_filters('wc_ajax_error_'. $this->action, $response, $errorCode);
    }

}
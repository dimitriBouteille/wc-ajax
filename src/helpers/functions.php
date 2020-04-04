<?php

if(!function_exists('wc_ajax_add_coupon_fields_html')) {

    /**
     * @return string
     */
    function wc_ajax_add_coupon_fields_html(): string
    {
        return \Dbout\WcAjax\Facades\AddCoupon::renderFields();
    }

}

if(!function_exists('wc_ajax_remove_coupon_fields_html')) {

    /**
     * @return string
     */
    function wc_ajax_remove_coupon_fields_html(): string
    {
        return \Dbout\WcAjax\Facades\RemoveCoupon::renderFields();
    }

}

if(!function_exists('wc_ajax_remove_row_fields_html')) {

    /**
     * @return string
     */
    function wc_ajax_remove_row_fields_html(): string
    {
        return \Dbout\WcAjax\Facades\RemoveRow::renderFields();
    }

}

if(!function_exists('wc_ajax_update_quantity_fields_html')) {

    /**
     * @return string
     */
    function wc_ajax_update_quantity_fields_html(): string
    {
        return \Dbout\WcAjax\Facades\UpdateQuantity::renderFields();
    }

}
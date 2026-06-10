<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package LeCouponCopy
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('le_coupon_copy_options');

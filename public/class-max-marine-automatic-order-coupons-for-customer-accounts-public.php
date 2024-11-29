<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/public
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Frontend;

use Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Upgrade\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Upgrader;
use Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\RestApi\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Core_API;

use WC_Coupon;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/public
 * @author     David Baumwald <david@dream-encode.com>
 */
class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Public {
	/**
	 * Register plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_plugin_settings() {
		$default = array(
			'plugin_log_level' => 'off',
		);

		$schema  = array(
			'type'       => 'object',
			'properties' => array(
				'plugin_log_level' => array(
					'type' => 'string',
				),
			),
		);

		register_setting(
			'options',
			'max_marine_automatic_order_coupons_for_customer_accounts_plugin_settings',
			array(
				'type'         => 'object',
				'default'      => $default,
				'show_in_rest' => array(
					'schema' => $schema,
				),
			)
		);
	}

	/**
	 * Applies coupons for industry customers with auto coupons attached to their account in the admin.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function woocommerce_before_calculate_totals() {
		// Initial checks.
		if ( is_admin() || ! is_user_logged_in() || did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
			return;
		}

		$current_user_id = get_current_user_id();

		// Check if customer is industry.
		$industry_customer = get_user_meta( $current_user_id, 'mmaocfca_industry_customer', true );

		if ( ! $industry_customer ) {
			return;
		}

		// Check if customer has auto coupons attached to account.
		$auto_coupons = get_user_meta( $current_user_id, 'mmaocfca_auto_coupons', true );

		if ( ! $auto_coupons ) {
			return;
		}

		$coupon = new WC_Coupon( $auto_coupons );

		if ( ! $coupon instanceof WC_Coupon ) {
			return;
		}

		$coupon_code = $coupon->get_code();

		// Make sure this coupon isn;t already applied.
		if ( WC()->cart->has_discount( $coupon_code ) ) {
			return;
		}

		// Add the discount to the cart.
		WC()->cart->add_discount( $coupon_code );
	}
}

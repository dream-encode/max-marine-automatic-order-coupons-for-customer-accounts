<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes
 * @author     David Baumwald <david@dream-encode.com>
 */
class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_I18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'max-marine-automatic-order-coupons-for-customer-accounts',
			false,
			MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . 'languages/'
		);
	}
}

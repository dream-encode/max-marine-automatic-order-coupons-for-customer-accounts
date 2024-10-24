<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dream-encode.com
 * @since             1.0.0
 * @package           Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 *
 * @wordpress-plugin
 * Plugin Name:       Max Marine - Automatic Order Coupons For Customer Accounts
 * Plugin URI:        https://example.com
 * Description:       A custom plugin that allows administrators to select coupons to be auto-applied to orders for specific customers.
 * Version:           1.0.0
 * Author:            David Baumwald
 * Author URI:        https://dream-encode.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       max-marine-automatic-order-coupons-for-customer-accounts
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/GH_REPO_URL
 * Primary Branch:    main
 * Release Asset:     true
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Constants
 */
require_once 'includes/max-marine-automatic-order-coupons-for-customer-accounts-constants.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-max-marine-automatic-order-coupons-for-customer-accounts-activator.php
 *
 * @return void
 */
function max_marine_automatic_order_coupons_for_customer_accounts_activate() {
	require_once MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . 'includes/class-max-marine-automatic-order-coupons-for-customer-accounts-activator.php';
	Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-max-marine-automatic-order-coupons-for-customer-accounts-deactivator.php
 *
 * @return void
 */
function max_marine_automatic_order_coupons_for_customer_accounts_deactivate() {
	require_once MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . 'includes/class-max-marine-automatic-order-coupons-for-customer-accounts-deactivator.php';
	Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'max_marine_automatic_order_coupons_for_customer_accounts_activate' );
register_deactivation_hook( __FILE__, 'max_marine_automatic_order_coupons_for_customer_accounts_deactivate' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.0.0
 * @return void
 */
function max_marine_automatic_order_coupons_for_customer_accounts_init() {
	/**
	 * Import some common functions.
	 */
	require_once MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . 'includes/max-marine-automatic-order-coupons-for-customer-accounts-core-functions.php';

	/**
	 * Main plugin loader class.
	 */
	require_once MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . 'includes/class-max-marine-automatic-order-coupons-for-customer-accounts.php';

	$plugin = new Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts();
	$plugin->run();
}

max_marine_automatic_order_coupons_for_customer_accounts_init();

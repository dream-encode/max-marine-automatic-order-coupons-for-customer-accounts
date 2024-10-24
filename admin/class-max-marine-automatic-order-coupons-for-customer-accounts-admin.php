<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/admin
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Admin;

use WP_Screen;


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/admin
 * @author     David Baumwald <david@dream-encode.com>
 */
class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Admin {

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		if ( ! max_marine_automatic_order_coupons_for_customer_accounts_admin_current_screen_has_enqueued_assets() ) {
			return;
		}

		$current_screen = get_current_screen();

		if ( ! $current_screen instanceof WP_Screen ) {
			return;
		}

		$screens_to_assets = max_marine_automatic_order_coupons_for_customer_accounts_get_admin_screens_to_assets();

		foreach ( $screens_to_assets as $screen => $assets ) {
			if ( $current_screen->id !== $screen ) {
				continue;
			}

			foreach ( $assets as $asset ) {
				$asset_base_url = MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_URL . 'admin/';

				$asset_file = include( MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . "admin/assets/dist/js/admin-{$asset['name']}.min.asset.php" );

				wp_enqueue_style(
					"max-marine-automatic-order-coupons-for-customer-accounts-admin-{$asset['name']}",
					$asset_base_url . "assets/dist/css/admin-{$asset['name']}.min.css",
					$asset_file['dependencies'],
					$asset_file['version'],
					'all'
				);
			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( ! max_marine_automatic_order_coupons_for_customer_accounts_admin_current_screen_has_enqueued_assets() ) {
			return;
		}

		$current_screen = get_current_screen();

		if ( ! $current_screen instanceof WP_Screen ) {
			return;
		}

		$screens_to_assets = max_marine_automatic_order_coupons_for_customer_accounts_get_admin_screens_to_assets();

		foreach ( $screens_to_assets as $screen => $assets ) {
			if ( $current_screen->id !== $screen ) {
				continue;
			}

			foreach ( $assets as $asset ) {
				$asset_base_url = MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_URL . 'admin/';

				$asset_file = include( MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . "admin/assets/dist/js/admin-{$asset['name']}.min.asset.php" );

				wp_register_script(
					"max-marine-automatic-order-coupons-for-customer-accounts-admin-{$asset['name']}",
					$asset_base_url . "assets/dist/js/admin-{$asset['name']}.min.js",
					$asset_file['dependencies'],
					$asset_file['version'],
					array(
						'in_footer' => true,
					)
				);

				if ( ! empty( $asset['localization'] ) ) {
					wp_localize_script( "max-marine-automatic-order-coupons-for-customer-accounts-admin-{$asset['name']}", 'MMAOCFCA', $asset['localization'] );
				}

				wp_enqueue_script( "max-marine-automatic-order-coupons-for-customer-accounts-admin-{$asset['name']}" );

				wp_set_script_translations( "max-marine-automatic-order-coupons-for-customer-accounts-admin-{$asset['name']}", 'max-marine-automatic-order-coupons-for-customer-accounts' );
			}
		}
	}
	
	/**
	 * Adds menu pages.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function add_menu_pages() {
		add_submenu_page(
			'options-general.php',
			__( 'Max Marine - Automatic Order Coupons For Customer Accounts', 'max-marine-automatic-order-coupons-for-customer-accounts' ),
			__( 'Max Marine - Automatic Order Coupons For Customer Accounts', 'max-marine-automatic-order-coupons-for-customer-accounts' ),
			'manage_options',
			'max-marine-automatic-order-coupons-for-customer-accounts-settings',
			array( $this, 'admin_settings_menu_callback' )
		);
	}

	/**
	 * Admin menu callback for the plugin settings page.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_settings_menu_callback() {
		echo '<div id="max-marine-automatic-order-coupons-for-customer-accounts-plugin-settings"></div>';
	}
}

<?php
/**
 * Common functions for the plugin.
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes
 */

 use WC_Coupon;

/**
 * Define a constant if it is not already defined.
 *
 * @since  1.0.0
 * @param  string  $name   Constant name.
 * @param  mixed   $value  Constant value.
 * @return void
 */
function max_marine_automatic_order_coupons_for_customer_accounts_maybe_define_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

/**
 * Get a plugin setting by key.
 *
 * @since  1.0.0
 * @param  string  $key      Setting key.
 * @param  mixed   $default  Optional. Default value. Default false.
 * @return mixed
 */
function max_marine_automatic_order_coupons_for_customer_accounts_get_plugin_setting( $key, $default = false ) {
	static $settings = false;

	if ( false === $settings ) {
		$settings = get_option( 'max_marine_automatic_order_coupons_for_customer_accounts_plugin_settings', array() );
	}

	if ( isset( $settings[ $key ] ) ) {
		return $settings[ $key ];
	}

	return $default;
}

/**
 * Get an array of data that relates enqueued assets to specific admin screens.
 *
 * @since  1.0.0
 * @return array
 */
function max_marine_automatic_order_coupons_for_customer_accounts_get_admin_screens_to_assets() {
	return array(
		'users' => array(
			array(
				'name' => 'users-listing',
			),
		),
		'user-edit' => array(
			array(
				'name'         => 'user-profile',
				'localization' => array(
					'REST_URL'    => get_rest_url( null, '' ),
					'WP_REST_URL' => get_rest_url(),
					'NONCES'      => array(
						'REST' => wp_create_nonce( 'wp_rest' ),
					),
					'ALL_COUPONS'    => max_marine_automatic_order_coupons_for_customer_accounts_get_all_woocommerce_coupons(),
				),
			),
		),
		'settings_page_max-marine-automatic-order-coupons-for-customer-accounts-settings' => array(
			array(
				'name'         => 'settings-page',
				'localization' => array(
					'REST_URL'    => get_rest_url( null, '' ),
					'WP_REST_URL' => get_rest_url(),
					'NONCES'      => array(
						'REST' => wp_create_nonce( 'wp_rest' ),
					),
					'SETTINGS'    => get_option( 'max_marine_automatic_order_coupons_for_customer_accounts_plugin_settings', array() ),
				),
			),
		),
	);
}

/**
 * Get a list of WP style dependencies.
 *
 * @since  1.0.0
 * @return string[]
 */
function max_marine_automatic_order_coupons_for_customer_accounts_get_wp_style_dependencies() {
	return array(
		'wp-components',
	);
}

/**
 * Get a list of WP style dependencies.
 *
 * @since  1.0.0
 * @param  array  $dependencies  Raw dependencies.
 * @return string[]
 */
function max_marine_automatic_order_coupons_for_customer_accounts_get_style_asset_dependencies( $dependencies ) {
	$style_dependencies = max_marine_automatic_order_coupons_for_customer_accounts_get_wp_style_dependencies();

	$new_dependencies = array();

	foreach ( $dependencies as $dependency ) {
		if ( in_array( $dependency, $style_dependencies, true ) ) {
			$new_dependencies[] = $dependency;
		}
	}

	return $new_dependencies;
}

/**
 * Get enqueued assets for the current admin screen.
 *
 * @since  1.0.0
 * @return array
 */
function max_marine_automatic_order_coupons_for_customer_accounts_admin_current_screen_enqueued_assets() {
	$current_screen = get_current_screen();

	if ( ! $current_screen instanceof WP_Screen ) {
		return array();
	}

	$assets = max_marine_automatic_order_coupons_for_customer_accounts_get_admin_screens_to_assets();

	return ! empty( $assets[ $current_screen->id ] ) ? $assets[ $current_screen->id ] : array();
}

/**
 * Check if the current admin screen has any enqueued assets.
 *
 * @since  1.0.0
 * @return int
 */
function max_marine_automatic_order_coupons_for_customer_accounts_admin_current_screen_has_enqueued_assets() {
	return count( max_marine_automatic_order_coupons_for_customer_accounts_admin_current_screen_enqueued_assets() );
}

/**
 * Get enqueued assets for the an admin screen.
 *
 * @since  1.0.0
 * @param  WP_Screen  $screen  Screen to check.
 * @return array
 */
function max_marine_automatic_order_coupons_for_customer_accounts_admin_screen_enqueued_assets( $screen ) {
	if ( ! $screen instanceof WP_Screen ) {
		return array();
	}

	$assets = max_marine_automatic_order_coupons_for_customer_accounts_get_admin_screens_to_assets();

	return ! empty( $assets[ $screen->id ] ) ? $assets[ $screen->id ] : array();
}

/**
 * Check if an admin screen has any enqueued assets.
 *
 * @since  1.0.0
 * @param  WP_Screen  $screen  Screen to check.
 * @return int
 */
function max_marine_automatic_order_coupons_for_customer_accounts_admin_screen_has_enqueued_assets( $screen ) {
	return count( max_marine_automatic_order_coupons_for_customer_accounts_admin_screen_enqueued_assets( $screen ) );
}

/**
 * Fetch WooCommerce coupons for autocomplete suggestions.
 *
 * @since  1.0.0
 * @param  array  $args  Array of args to filter coupons query.
 * @return array  Array of coupon codes.
 */
function max_marine_automatic_order_coupons_for_customer_accounts_get_all_woocommerce_coupons( $args = array() ) {
	$default_args = array(
		'post_type' => 'shop_coupon',
		'limit'     => -1,
	);

	$args = wp_parse_args( $args, $default_args );

	$posts = get_posts( $args );

	$coupons = array();

	foreach ( $posts as $post ) {
		$coupon = new WC_Coupon( $post->ID );

		$coupons[] = array(
			'id'   => $coupon->get_id(),
			'name' => $coupon->get_description(),
			'code' => $coupon->get_code(),
		);
	}

	return $coupons;
}

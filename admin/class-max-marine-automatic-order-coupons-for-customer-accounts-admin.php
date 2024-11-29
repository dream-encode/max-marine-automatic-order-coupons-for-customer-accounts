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
use WC_Coupon;
use WP_User;

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
					max_marine_automatic_order_coupons_for_customer_accounts_get_wp_style_dependencies(),
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
			__( 'Automatic Order Coupons For Customer Accounts', 'max-marine-automatic-order-coupons-for-customer-accounts' ),
			__( 'Automatic Order Coupons For Customer Accounts', 'max-marine-automatic-order-coupons-for-customer-accounts' ),
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

	/**
	 * Add custom columns to the users list table.
	 *
	 * @since  1.0.0
	 * @param  array  $columns  Columns.
	 * @return array
	 */
	public function manage_users_columns( array $columns ) : array {
		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			$new_columns[ $key ] = $value;

			if ( 'role' === $key ) {
				$new_columns['mmaocfca_industry_customer'] = esc_html__( 'Industry?', 'max-marine-automatic-order-coupons-for-customer-accounts' );
			}
		}

		return $new_columns;
	}

	/**
	 * Print custom field data for any custom columns in the users listing.
	 *
	 * @since  1.0.0
	 * @param  string  $value    Current value.
	 * @param  string  $column   Column name.
	 * @param  int     $user_id  Current user ID.
	 * @return string
	 */
	public function manage_users_custom_column( $value, $column, $user_id ) : string {
		if ( 'mmaocfca_industry_customer' !== $column ) {
			return $value;
		}

		$is_industry_customer = get_user_meta( $user_id, 'mmaocfca_industry_customer', true );

		if ( ! $is_industry_customer ) {
			return esc_html__( 'No', 'max-marine-automatic-order-coupons-for-customer-accounts' );
		} else {
			return esc_html__( 'Yes', 'max-marine-automatic-order-coupons-for-customer-accounts' );
		}
	}

	/**
	 * Displays a custom user meta field on the admin user profile page.
	 *
	 * @since  1.0.0
	 * @param  WP_User  $user  The user object for the profile being edited.
	 * @return void
	 */
	public function edit_user_profile( $user ) {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		if ( ! $user instanceof WP_User ) {
			return;
		}

		// Get the current value of the meta field for this user.
		$industry_customer = get_user_meta( $user->ID, 'mmaocfca_industry_customer', true );
		$auto_coupons      = get_user_meta( $user->ID, 'mmaocfca_auto_coupons', true );

		$is_industry_customer = '' !== $industry_customer;
		$has_auto_coupons     = '' !== $auto_coupons;

		$coupon_name = '';

		if ( $has_auto_coupons ) {
			$coupon = new WC_Coupon( absint( $auto_coupons ) );

			if ( $coupon instanceof WC_Coupon ) {
				$coupon_name = $coupon->get_description();
			}
		}
		?>

		<h3>
			<?php esc_html_e( 'Customer Auto Order Coupons', 'max-marine-automatic-order-coupons-for-customer-accounts' ); ?>
		</h3>
		<table class="form-table">
			<tr>
				<th><label for="mmaocfca_industry_customer"><?php esc_html_e( 'Industry Customer?', 'max-marine-automatic-order-coupons-for-customer-accounts' ); ?></label></th>
				<td>
					<input type="checkbox" name="mmaocfca_industry_customer" id="mmaocfca_industry_customer" value="1" <?php checked( $is_industry_customer ); ?> />
				</td>
			</tr>
			<tr id="mmaocfca_auto_apply_coupon_container" class="<?php echo ( $is_industry_customer ) ? '' : 'hidden'; ?>">
				<th><label for="mmaocfca_apply_auto_coupon"><?php esc_html_e( 'Apply coupon automatically', 'max-marine-automatic-order-coupons-for-customer-accounts' ); ?></label></th>
				<td>
					<input type="checkbox" name="mmaocfca_apply_auto_coupon" id="mmaocfca_apply_auto_coupon" value="1" <?php checked( $has_auto_coupons ); ?> />
				</td>
			</tr>
			<tr id="mmaocfca_auto_coupons_container" class="<?php echo ( $is_industry_customer && $has_auto_coupons ) ? '' : 'hidden'; ?>">
				<th><label for="mmaocfca_auto_coupons"><?php esc_html_e( 'Coupon', 'max-marine-automatic-order-coupons-for-customer-accounts' ); ?></label></th>
				<td>
					<div class="mmaocfca-autocomplete-coupons-list-container">
						<input type="text" name="mmaocfca_auto_coupons_names" id="mmaocfca_auto_coupons_names" value="<?php echo esc_attr( $coupon_name ); ?>" class="regular-text mmaocfca-autocomplete-coupon" />
						<ul class="mmaocfca-autocomplete-coupons-list hidden" id="mmaocfca-autocomplete-coupons-list"></ul>
					</div>
					<input type="hidden" name="mmaocfca_auto_coupons" id="mmaocfca_auto_coupons" value="<?php echo esc_attr( $auto_coupons ); ?>" />
					<p class="description"><?php esc_html_e( 'Start typing to search for a coupon code.', 'max-marine-automatic-order-coupons-for-customer-accounts' ); ?></p>
				</td>
			</tr>
		</table>
		<?php wp_nonce_field( 'mmaocfca_edit_user', 'mmaocfca_edit_user_nonce' ); ?>

		<?php
	}

	/**
	 * Saves custom field data posted from the admin user profile page.
	 *
	 * @since  1.0.0
	 * @param  int  $user_id  Current user ID being saved.
	 * @return void
	 */
	public function edit_user_profile_update( $user_id ) {
		if ( ! isset( $_POST['mmaocfca_edit_user_nonce'] ) || ! wp_verify_nonce( $_POST['mmaocfca_edit_user_nonce'], 'mmaocfca_edit_user' ) ) {
			die( esc_html__( 'Security check', 'max-marine-automatic-order-coupons-for-customer-accounts' ) );
		}

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$editable_fields = array(
			'mmaocfca_industry_customer',
			'mmaocfca_auto_coupons',
		);

		foreach ( $editable_fields as $post_key ) {
			if ( isset( $_POST[ $post_key ] ) ) {
				update_user_meta( $user_id, $post_key, sanitize_text_field( $_POST[ $post_key ] ) );
			} else {
				delete_user_meta( $user_id, $post_key );
			}
		}
	}
}

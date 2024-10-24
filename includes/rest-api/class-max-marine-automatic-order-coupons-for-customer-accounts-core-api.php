<?php
/**
 * Class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Core_API
 *
 * @since 1.0.0
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\RestApi;

use Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Abstracts\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_API;

defined( 'ABSPATH' ) || exit;

/**
 * Class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Core_API
 *
 * @since 1.0.0
 */
class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Core_API extends Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_API {
	/**
	 * Includes files
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function rest_api_includes() {
		parent::rest_api_includes();

		$path_version = 'includes/rest-api' . DIRECTORY_SEPARATOR . $this->version . DIRECTORY_SEPARATOR . 'frontend';

		include_once MAX_MARINE_AUTOMATIC_ORDER_COUPONS_FOR_CUSTOMER_ACCOUNTS_PLUGIN_PATH . $path_version . '/class-max-marine-automatic-order-coupons-for-customer-accounts-rest-user-controller.php';
	}

	/**
	 * Register all routes.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function rest_api_register_routes() {
		$controllers = array(
			'Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_REST_User_Controller',
		);

		$this->controllers = $controllers;

		parent::rest_api_register_routes();
	}
}

<?php
/**
 * Simple logger class that relies on the WC_Logger instance.
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes/log
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Log;

use Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Abstracts\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_WC_Logger;

/**
 * Simple logger class to log data to custom files.
 *
 * Relies on the bundled logger class in WooCommerce.
 *
 * @package  Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Log\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_WC_Logger
 * @author   David Baumwald <david@dream-encode.com>
 */
final class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_WC_Logger extends Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_WC_Logger {

	/**
	 * Log namespace.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var     string  $namespace  Log namespace.
	 */
	protected static $namespace = 'max-marine-automatic-order-coupons-for-customer-accounts';
}

<?php
/**
 * Simple wrapper class for custom logs.
 *
 * @uses \WC_Logger();
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes
 */

namespace Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Log;

use Max_Marine\Automatic_Order_Coupons_For_Customer_Accounts\Core\Abstracts\Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_WC_Logger;

/**
 * Logger class.
 *
 * Log stuff to files.
 *
 * @since      1.0.0
 * @package    Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts
 * @subpackage Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts/includes
 * @author     David Baumwald <david@dream-encode.com>
 */
final class Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Upgrader_Logger extends Max_Marine_Automatic_Order_Coupons_For_Customer_Accounts_Abstract_WC_Logger {
	/**
	 * Log namespace.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var     string  $namespace  Log namespace.
	 */
	public static $namespace = 'max-marine-automatic-order-coupons-for-customer-accounts-upgrader';
}

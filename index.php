<?php
/**
 * TDT Notification
 *
 * @package     tdt-notification
 * @author      Anh Tuan
 * @copyright   2017 Anh Tuan
 * @license     GPL-2.0+
 *
 * Plugin Name: TDT Notification
 * Plugin URI:  https://duonganhtuan.com/tdt-notification/
 * Description: Save tons of bandwidth and make website load faster
 * Version:     1.1.9
 * Author:      Anh Tuan
 * Author URI:  https://duonganhtuan.com
 * Text Domain: tdt-notification
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TDT_NOTIFICATION_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'TDT_NOTIFICATION_PLUGIN_DIR', trailingslashit( plugin_dir_url( __FILE__ ) ) );

require TDT_NOTIFICATION_PLUGIN_PATH . 'classes/class.notification.php';
require TDT_NOTIFICATION_PLUGIN_PATH . 'classes/class.notification.admin.php';
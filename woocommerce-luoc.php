<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpgenie.org
 * @since             1.0.0
 * @package           woocommerce_luoc
 *
 * @wordpress-plugin
 * Plugin Name:       Last Users Order Column for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/last-users-order-column-for-woocommerce/
 * Description:       Shows last WooCommerce order info for user in wp-admin user list.
 * Version:           1.0.3
 * Author:            wpgenie
 * Author URI:        https://wpgenie.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-luoc
 * Domain Path:       /languages
 * Requires Plugins: woocommerce
 *
 * WC requires at least: 4.0
 * WC tested up to: 9.0
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WOOCOMMERCE_LUOC_VERSION', '1.0.3' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-luoc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

function run_woocommerce_luoc() {

	$plugin = new woocommerce_luoc();
	$plugin->run();

}
run_woocommerce_luoc();

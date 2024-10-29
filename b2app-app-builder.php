<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://b2app.tech
 * @since             1.0.0
 * @package           B2app_App_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       B2App - No code Mobile App builder
 * Plugin URI:        https://b2app.tech
 * Description:       B2App - Android & iOS native apps builder without using code for online store based on Woocommerce. It will allow you to create a beautiful and multifunctional mobile application in a few clicks. 
 * Version:           1.0.0
 * Author:            B2App
 * Author URI:        https://b2app.tech
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       b2app-app-builder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'B2APP_APP_BUILDER_VERSION', '1.0.0' );

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . '/wp-admin/includes/plugin.php');
}

/**
* Check for the existence of WooCommerce and any other requirements
*/
function b2app_check_requirements() {
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        return true;
    } else {
        add_action( 'admin_notices', 'b2app_missing_wc_notice' );
        return false;
    }
}

/**
* Display a message advising WooCommerce is required
*/
function b2app_missing_wc_notice() { 
    $class = 'notice notice-error';
    $message = __( 'B2App requires WooCommerce to be installed and active.', 'b2app-app-builder' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

function b2app_missing_b2app_inputs() { 
    $class = 'notice notice-error';
    $message = __( 'Please fill in all the fields and select a mobile application template and theme', 'b2app-app-builder' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

function b2app_error_email() { 
    $class = 'notice notice-error';
    $message = __( 'This email has already been registered. Go to the site https://b2app.tech and check if you have already created an application.', 'b2app-app-builder' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

function b2app_error_create_app() { 
    $class = 'notice notice-error';
    $message = __( 'Sorry. Something went wrong. Try to create an application through the site https://b2app.tech', 'b2app-app-builder' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-b2app-app-builder-activator.php
 */
function activate_b2app_app_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2app-app-builder-activator.php';
	B2app_App_Builder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-b2app-app-builder-deactivator.php
 */
function deactivate_b2app_app_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2app-app-builder-deactivator.php';
	B2app_App_Builder_Deactivator::deactivate();
}

add_action( 'plugins_loaded', 'b2app_check_requirements' );

register_activation_hook( __FILE__, 'activate_b2app_app_builder' );
register_deactivation_hook( __FILE__, 'deactivate_b2app_app_builder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-b2app-app-builder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_b2app_app_builder() {
    
    if (b2app_check_requirements()) {
        $plugin = new B2app_App_Builder();
        $plugin->run();        
    }

}
run_b2app_app_builder();

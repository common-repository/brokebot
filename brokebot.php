<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              getbrokebot.com
 * @since             1.0.6
 * @package           BrokeBot
 *
 * @wordpress-plugin
 * Plugin Name:       BrokeBot
 * Plugin URI:        getbrokebot.com/download
 * Description:       A simple ActionBot to increase conversions from key pages of your website. 
 * Version:           1.0.8
 * Author:            BrokeBot
 * Author URI:        getbrokebot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brokebot
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
define( 'BROKEBOT_VERSION', '1.0.8' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-brokebot-activator.php
 */
function activate_brokebot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brokebot-activator.php';
	BrokeBot_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-brokebot-deactivator.php
 */
function deactivate_brokebot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brokebot-deactivator.php';
	BrokeBot_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_brokebot' );
register_deactivation_hook( __FILE__, 'deactivate_brokebot' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-brokebot.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_brokebot() {

	$plugin = new BrokeBot();
	$plugin->run();

}
run_brokebot();
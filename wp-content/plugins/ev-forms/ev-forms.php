<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Ev_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       Everlytic Forms
 * Description:       Use this plugin to embed Everlytic subscription forms in your Wordpress pages. To start, activate the plugin then go to the Everlytic API Settings page and enter your API details.
 * Version:           1.0.0
 * Author:            Everlytic
 * Author URI:        www.everlytic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ev-forms
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ev-forms-activator.php
 */
function activate_ev_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ev-forms-activator.php';
	Ev_Forms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ev-forms-deactivator.php
 */
function deactivate_ev_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ev-forms-deactivator.php';
	Ev_Forms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ev_forms' );
register_deactivation_hook( __FILE__, 'deactivate_ev_forms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ev-forms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ev_forms() {

	$plugin = new Ev_Forms();
	$plugin->run();

}
run_ev_forms();

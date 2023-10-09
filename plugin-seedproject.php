<?php
/**
 * Plugin Name: Plugin
 * Description: Custom Elementor Widgets
 * Version:     1.0.0
 * Author:      L Mentzer
 * Text Domain: plugin-seedproject
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function plugin_seedproject() {

	// Load plugin file
	require_once( __DIR__ . '/includes/plugin.php' );

	// Run the plugin
	\Plugin_Seedproject\SeedProject_Elementor_Extension::instance();

}
add_action( 'plugins_loaded', 'plugin_seedproject' );

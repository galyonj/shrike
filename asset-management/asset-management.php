<?php
/**
 * @link              https://github.com/galyonj
 * @since             1.0.0
 * @package           Asset_Management
 *
 * Plugin Name:       Asset Management
 * Plugin URI:        https://github.com/galyonj/asset-management
 * Description:       Allow the user to create custom post types and custom taxonomies for those posts.
 * Version:           1.0.5
 * Author:            John Galyon
 * Author URI:        https://github.com/galyonj
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       asset-management
 * Domain Path:       /languages
 */

// Nobody should be accessing this file directly because that's illegal.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'That\'s illegal.' );
}

/**
 * Define some useful constants
 */
function gj_define_constants() {
	$file_data = get_file_data(
		__FILE__,
		array(
			'name'    => 'Plugin Name',
			'version' => 'Version',
			'text'    => 'Text Domain',
		)
	);

	define( 'GJ_NAME', $file_data['name'] );
	define( 'GJ_VERSION', $file_data['version'] );
	define( 'GJ_TEXT', $file_data['text'] );
}
add_action( 'plugins_loaded', 'gj_define_constants' );

/**
 * Redirect user to the setup page on plugin activation
 *
 * @return void
 * @author galyonj
 * @since  1.0.0
 */
function gj_activation_redirect() {
	// If there's no transient, there's nothing to do.
	if ( ! get_transient( 'gj_activation_redirect' ) ) {
		return;
	}

	delete_transient( 'gj_activation_redirect' );

	/*
	 * Don't redirect if this is a network or bulk activation.
	 */
	if ( is_network_admin() || ! gj_new_install() ) {
		return;
	}
}
add_action( 'admin_init', 'gj_activation_redirect', 1 );

/**
 * Enqueue stylesheets and javascript files
 * required by the plugin
 *
 * @since  1.0.5
 * @author galyonj
 * @uses   wp_enqueue_style()
 * @uses   wp_enqueue_script()
 */
function gj_enqueue() {

	if ( is_admin() ) {
		wp_enqueue_style(
			GJ_TEXT,
			plugin_dir_url( __FILE__ ) . 'assets/' . GJ_TEXT . '.min.css',
			'',
			GJ_VERSION,
			'all'
		);

		wp_enqueue_script(
			GJ_TEXT,
			plugin_dir_url( __FILE__ ) . 'assets/' . GJ_TEXT . '.js',
			[ 'jquery' ],
			GJ_VERSION,
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'gj_enqueue' );

/**
 * Create the menu for our plugin
 *
 * @since  1.0.0
 * @author galyonj
 */
function gj_plugin_menu() {
	$caps        = apply_filters( 'gj_user_caps', 'manage_options' );
	$parent_slug = 'asset_management';

	/**
	 * Create the plugin page menu
	 *
	 * @since  1.0.5
	 * @author galyonj
	 */
	add_menu_page( __( 'Asset Management', GJ_TEXT ), __( 'Assets', GJ_TEXT ), $caps, $parent_slug, 'gj_display_admin_settings', gj_menu_icon(), 2 );
	add_submenu_page( $parent_slug, __( 'Manage Asset Types', GJ_TEXT ), __( 'Manage Asset Types', GJ_TEXT ), $caps, 'manage_asset_types', 'gj_manage_assets' );
	add_submenu_page( $parent_slug, __( 'Manage Taxonomies', GJ_TEXT ), __( 'Manage Taxonomies', GJ_TEXT ), $caps, 'manage_taxonomies', 'gj_manage_taxonomies' );

	/**
	 * Remove the default main page from the menu so we can make
	 * things less confusing
	 *
	 * @since  1.0.5
	 * @author galyonj
	 */
	remove_submenu_page( $parent_slug, 'asset_management' );

	/**
	 * Now we add a new submenu page for settings and stuff
	 *
	 * @since  1.0.5
	 * @author galyonj
	 */
	add_submenu_page( $parent_slug, __( GJ_NAME, GJ_TEXT ), __( 'About', GJ_TEXT ), $caps, __( 'About', GJ_TEXT ), 'gj_display_admin_settings' );


}
add_action( 'admin_menu', 'gj_plugin_menu' );

/**
 * Load all the files required for the plugin to function.
 *
 * @since  1.0.0
 * @author galyonj
 */
function gj_load_files() {
	$files = glob( plugin_dir_path( __FILE__ ) . '/includes/*.php' );

	// We require any class files first to make sure they're available for other files.
	//require_once plugin_dir_path( __FILE__ ) . '/classes/*.php';

	// Now loop through the $files glob and require each of the files
	foreach ( $files as $file ) {
		require_once( $file );
	}
}
add_action( 'plugins_loaded', 'gj_load_files' );
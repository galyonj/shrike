<?php
/**
 * Handle custom post type CRUD functions
 * @since      1.0.5
 * @author     galyonj
 * @package    Asset_Management
 * @subpackage includes/process-assets
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'That\'s illegal.' );
}

/**
 * Confirm the form nonce is good, then pass form data
 * onto the appropriate function.
 *
 * @since  1.0.0
 * @author galyonj
 */
function gj_process_asset() {
	$nonce = ( ! empty( $_POST['gj_create_asset_nonce_field'] ) ) ?? wp_verify_nonce( $_POST['gj_create_asset_nonce_field'] );

	if ( wp_doing_ajax() || ! is_admin() ) {
		return;
	}

	if ( ! empty( $_GET ) && ( isset( $_GET['page'] ) && 'manage_asset_types' !== $_GET['page'] ) ) {
		return;
	}

	if ( $nonce && ( ! empty( $_POST ) ) ) {
		$result = '';

		if ( isset( $_POST['submit'] ) ) {
			$result = gj_update_asset( $_POST );
		}
	}
}

/**
 * Sanitize submitted data, save that data to a custom
 * WordPress option array, and use that array to bootstrap
 * registration of custom taxonomies for our post type.
 *
 * @param array $data
 *
 * @since  1.0.0
 * @author galyonj
 */
function gj_update_asset( $data = array() ) {

	/**
	 * Fires before our asset data is sanitized and
	 * added to our saved option array
	 */
	do_action( 'gj_before_update_asset', $data );

	/*
	 * Save our assets option to a variable so it's handy
	 * when we need it later.
	 */
	$assets = get_option( 'gj_assets' );

	/**
	 * Now let's collect our form data and do what formatting
	 * we can early so that there's a lower chance of data
	 * getting buggered up during the registration process.
	 *
	 * @since  1.0.5
	 * @author galyonj
	 */
	$pattern         = array(
		'/[\'"]/',
		'/[ ]/',
	);
	$replace         = array(
		'',
		'_',
	);
	$name            = trim( strtolower( preg_replace( $pattern, $replace, sanitize_text_field( $data['singular_name'] ) ) ) );
	$assets[ $name ] = [
		'name'         => $name,
		'label'        => trim( ucwords( preg_replace( $pattern, $replace, sanitize_text_field( $data['plural_name'] ) ) ) ),
		'description'  => sanitize_textarea_field( $data['description'] ),
		'hierarchical' => filter_var( $data['hierarchical'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ),
	];

	/**
	 * Filter the final data to be saved right before saving the tax data
	 *
	 * @param array  $assets Array of asset data to be saved
	 * @param string $name   Asset slug to be saved
	 *
	 * @since 1.0.0
	 */
	$assets = apply_filters( 'gj_pre_save_asset', $assets, $name );

	// Update our saved option
	update_option( 'gj_assets', $assets );

	/**
	 * Fires after an asset type has been added to our saved options
	 *
	 * @param array $data array of asset data that was updated.
	 *
	 * @since 1.0.0
	 */
	do_action( 'gj_post_update_asset', $data );

	// This will help us make sure the rewrite rules are flushed on init during the taxonomy registration process.
	set_transient( 'gj_flush_rewrite_rules', 'true', 5 * 60 );
}
<?php
/**
 * A collection of utility functions for the plugin
 *
 * @since   1.0.0
 * @package Asset_Management
 */

// Nobody should be accessing this file directly because that's illegal.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'That\'s illegal.' );
}

/**
 * Create the menu icon for our plugin
 */
function gj_menu_icon(): string {
	return 'data:image/svg+xml;base64,' . base64_encode( '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Free 5.15.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path fill="black" d="M519.442 288.651c-41.519 0-59.5 31.593-82.058 31.593C377.409 320.244 432 144 432 144s-196.288 80-196.288-3.297c0-35.827 36.288-46.25 36.288-85.985C272 19.216 243.885 0 210.539 0c-34.654 0-66.366 18.891-66.366 56.346 0 41.364 31.711 59.277 31.711 81.75C175.885 207.719 0 166.758 0 166.758v333.237s178.635 41.047 178.635-28.662c0-22.473-40-40.107-40-81.471 0-37.456 29.25-56.346 63.577-56.346 33.673 0 61.788 19.216 61.788 54.717 0 39.735-36.288 50.158-36.288 85.985 0 60.803 129.675 25.73 181.23 25.73 0 0-34.725-120.101 25.827-120.101 35.962 0 46.423 36.152 86.308 36.152C556.712 416 576 387.99 576 354.443c0-34.199-18.962-65.792-56.558-65.792z"/></svg>' );
}

/**
 * Flush_rewrite_rules is an expensive operation, and we don't want to perform it any more than we absolutely
 * have to. However...our plugin makes both a custom post type and creates a framework by which we can
 * later perform CRUD operations on taxonomies related to that post type, we're going to have to flush
 * the WordPress rewrite rules.
 *
 * This function looks for a short-lived transient that will be created during the CRUD process for our post type
 * or any of our taxonomies. If that transient is found, we do a soft flush of the rewrite rules upon activation
 * of any of the CRUD operations performed by our plugin.
 *
 * @since 1.0.0
 * @link  https://developer.wordpress.org/reference/functions/flush_rewrite_rules/
 * @link  https://developer.wordpress.org/reference/functions/get_transient/
 */
function gj_flush_rewrite_rules() {

	if ( wp_doing_ajax() ) {
		return;
	}
	if ( 'true' === ( $flush_it = get_transient( 'gj_flush_rewrite_rules' ) ) ) {
		flush_rewrite_rules( false );
		// So we only run this once.
		delete_transient( 'gj_flush_rewrite_rules' );
	}
}
add_action( 'admin_init', 'gj_flush_rewrite_rules' );
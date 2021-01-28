<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class GJ_List_Assets_Table extends WP_List_Table {

	public function __construct() {
		parent::__construct( [
			'singular' => __('Asset', GJ_TEXT), //
			'plural' => __('Assets', GJ_TEXT),
			'ajax' => false
		] );
	}
}
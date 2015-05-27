<?php
defined( 'WPINC' ) or die;

class WP_Feature_Better_Passwords_Plugin extends WP_Stack_Plugin2 {

	protected static $instance;

	/**
	 * Constructs the object, hooks in to 'plugins_loaded'
	 */
	protected function __construct() {
		$this->hook( 'plugins_loaded', 'add_hooks' );
	}

	/**
	 * Adds hooks
	 */
	public function add_hooks() {
		$this->hook( 'init' );
		$this->hook( 'show_password_fields' );
		$this->hook( '__temp_password_field', 'password_field' );
	}


	public function show_password_fields( $show, $profile_user = null ) {
		if ( $profile_user ) {
			return false;
		} else {
			return $show;
		}
	}

	public function password_field() {
		$this->include_file( 'tmpl/fields.php' );
	}
	/**
	 * Initializes the plugin, registers textdomain, etc
	 */
	public function init() {
		$this->load_textdomain( 'wp-feature-better-passwords', '/languages' );
	}
}

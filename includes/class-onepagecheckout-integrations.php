<?php

/**
 * Class Compatibility with other themes & plugins
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 * @author     Thien Tran <thientran2359@gmail.com>
 */

abstract class WCVN_OnePageCheckout_Integrations_Base {
	/**
	 * Base constructor.
	 */
	final public function __construct() {
		$this->pre_init();

		add_action( 'init', array( $this, 'compat_init' ) );
	}

	/**
	 * Run after init (normative use case)
	 */
	final function compat_init() {
		if ( $this->is_available() && ( ! is_admin() || wp_doing_ajax() ) ) {
			// Run if on checkout
			$this->run_immediately();
			add_action( 'wp', array( $this, 'queue_checkout_page_actions' ), 0 );
			add_action( 'after_setup_theme', array( $this, 'run' ) );
			add_action( 'wp_loaded', array( $this, 'run_on_wp_loaded' ), 0 );
		}
	}

	/**
	 * Allow some things to be run before init
	 *
	 * SHOULD BE AVOIDED
	 */
	public function pre_init() {
		// Silence is golden
	}

	final public function queue_checkout_page_actions() {
		if ( function_exists('is_checkout') && is_checkout() ) {
			$this->run();
		}
	}

	/***
	 * Kick-off everything here
	 */
	function run() {
		// Silence be golden
	}

	/***
	 * Kick-off everything here immediately
	 */
	function run_immediately() {
		// Silence be golden
	}

	/**
	 * Kick-off everything here on wp_loaded hook
	 */
	function run_on_wp_loaded() {
		// Silence is golden
	}

	/**
	 * Is dependency for this compatibility class available?
	 *
	 * @return bool
	 */
	function is_available(): bool {
		return false;
	}

}

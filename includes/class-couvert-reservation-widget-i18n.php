<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://dasun.ediris.in/ghe
 * @since      1.0.0
 *
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/includes
 * @author     Dasun Edirisinghe <dazunj4me@gmail.com>
 */
class Couvert_Reservation_Widget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'couvert-reservation-widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

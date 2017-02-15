<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://dasun.ediris.in/ghe
 * @since      1.0.0
 *
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/admin
 * @author     Dasun Edirisinghe <dazunj4me@gmail.com>
 */
class Couvert_Reservation_Widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The option name.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */

	private $option_name = 'couvert_reservation';
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $settings_fields =  array(
			// General Section

			'general' => array(
				'Couvert API Key' => 'api_key',
				'Couvert API URL' => 'api_url',
				'Plugin Languge'  => 'plugin_lang',
				'Redirection URL' => 'redirect_url'
				),

			// Form Translations Sections
			'language' => array(
				'Date picker Label'				=> 'date_picker',
				'Date picker Place Holder'		=> 'date_picker_ph',
				'Persons Number Label'			=> 'person_number',
				'Persons Number Place Holder'	=> 'person_number_ph',
				'Availability Button Label'		=> 'availability_button',
				'Time Slots Label'				=> 'time_slot_label',
				'Form Request Button Label'		=> 'form_rquest_button',
				'First Name Label'				=> 'first_name_label',
				'First Name Place Holder'		=> 'first_name_label_ph',
				'Last Name Label'				=> 'last_name_label',
				'Last Name Label Place Holder'	=> 'last_name_label_ph',
				'E-mail Address Label'			=> 'email_address_label',
				'E-mail Address Place Holder'	=> 'email_address_label_ph',
				'Phone Number Label'			=> 'phone_number_label',
				'Phone Number Place Holder'		=> 'phone_number_label_ph',
				'Postal Code Label'				=> 'postal_code_label',
				'Postal Code Place Holder'		=> 'postal_code_label_ph',
				'Gender Label'					=> 'gender_label',
				'Gender Label Place Holder'		=> 'gender_label_ph',
				'Birth Date Label'				=> 'birth_day_label',
				'Birth Date Place Holder'		=> 'birth_day_label_ph',
				'Message Label'					=> 'message_label',
				'Message Label Place Holder'	=> 'message_label_ph',
				'Make Reservation Button Label'	=> 'resvertaion_button_label',
				'High Tea Label'				=> 'high_teal_label',
				'High Tea Label Place Holder'	=> 'high_teal_label_ph',
				'Picknic Label'					=> 'picknick_label',
				'Picknic Label Place Holder'	=> 'picknick_label_ph'
				),
		);

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Couvert_Reservation_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Couvert_Reservation_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/couvert-reservation-widget-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Couvert_Reservation_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Couvert_Reservation_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/couvert-reservation-widget-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Admin Page for Reservation Settings.
	 *
	 * @since 1.0.00
	 */

	public function couvert_rservation_settings_page() {

		add_menu_page(
			__('Couvert Reservation Settings', 'couvert-reservation-widget'),
			__('Couvert', 'couvert-reservation-widget'),
			'manage_options',
			$this->plugin_name, 
			array( $this, 'display_options_page' ),
			plugin_dir_url( __FILE__ ).'/img/icon.svg', 
			'65'
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/couvert-reservation-widget-admin-display.php';
	}
	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */



	public function register_setting() {


		foreach ($this->settings_fields as $section => $values) {
			
			add_settings_section(

				$this->option_name . '_'.$section,
				__( strtoupper($section), 'couvert-reservation-widget' ),
				array( $this, $this->option_name . '_'.$section.'_cb' ),
				$this->plugin_name.'-'.$section

			);


			foreach ($values as $key => $field) {
				
				add_settings_field(
					$this->option_name . '_'.$field,
					__( $key, 'couvert-reservation-widget' ),
					array( $this, $this->option_name . '_'.$field.'_cb' ),
					$this->plugin_name.'-'.$section,
					$this->option_name . '_'.$section
				);

				register_setting( $this->plugin_name.'-'.$section, $this->option_name . '_'.$field );
			}


		}
	}
	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_general_cb() {
		echo '<p>' . __( 'Please add the [booking_widget restaurant="your resturent id" analytics="analytics id"] shortcode in your booking page.', 'couvert-reservation-widget' ) . '</p>';
	}

	public function couvert_reservation_language_cb() {
		echo '<p>'.__( 'This fields allows you to set the form fields in your own language', 'couvert-reservation-widget' ).'</p>';
	}


	/**
	 * Render the api_key input for this plugin
	 *
	 * @since  1.0.0
	 */
	/**
	 * Render the api_key input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_api_key_cb() {

		$api_key = get_option( $this->option_name . '_api_key' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_api_key' . '" id="' . $this->option_name . '_api_key' . '" value="' . $api_key . '">';
	}

	/**
	 * Render the api_key input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_api_url_cb() {
		$api_url = get_option( $this->option_name . '_api_url' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_api_url' . '" id="' . $this->option_name . '_api_url' . '" value="' . $api_url . '">';
	}


	/**
	 * Render the languge input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_plugin_lang_cb() {
		$plugin_lang = get_option( $this->option_name . '_plugin_lang' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_plugin_lang' . '" id="' . $this->option_name . '_plugin_lang' . '" value="' . $plugin_lang . '">';
	}


	/**
	 * Render the languge input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_redirect_url_cb() {
		$redirect_url = get_option( $this->option_name . '_redirect_url' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_redirect_url' . '" id="' . $this->option_name . '_redirect_url' . '" value="' . $redirect_url . '">';
	}

	/**
	 * Render the form date picker input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_date_picker_cb() {
		$date_picker = get_option( $this->option_name . '_date_picker' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_date_picker' . '" id="' . $this->option_name . '_date_picker' . '" value="' . $date_picker . '">';
	}

	public function couvert_reservation_date_picker_ph_cb() {
		$date_picker_ph = get_option( $this->option_name . '_date_picker_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_date_picker_ph' . '" id="' . $this->option_name . '_date_picker_ph' . '" value="' . $date_picker_ph . '">';
	}


	/**
	 * Render the form Person Number input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function couvert_reservation_person_number_cb() {
		$person_number = get_option( $this->option_name . '_person_number' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_person_number' . '" id="' . $this->option_name . '_person_number' . '" value="' . $person_number . '">';
	}

	public function couvert_reservation_person_number_ph_cb() {
		$person_number_ph = get_option( $this->option_name . '_person_number_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_person_number_ph' . '" id="' . $this->option_name . '_person_number_ph' . '" value="' . $person_number_ph . '">';
	}

	/**
	 * Render the form Person Number input for this plugin
	 *
	 * @since  1.0.0
	 */

	public function couvert_reservation_availability_button_cb() {
		$availability_button = get_option( $this->option_name . '_availability_button' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_availability_button' . '" id="' . $this->option_name . '_availability_button' . '" value="' . $availability_button . '">';
	}

	public function couvert_reservation_time_slot_label_cb() {
		$time_slot_label = get_option( $this->option_name . '_time_slot_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_time_slot_label' . '" id="' . $this->option_name . '_time_slot_label' . '" value="' . $time_slot_label . '">';
	}

	public function couvert_reservation_form_rquest_button_cb() {
		$form_rquest_button = get_option( $this->option_name . '_form_rquest_button' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_form_rquest_button' . '" id="' . $this->option_name . '_form_rquest_button' . '" value="' . $form_rquest_button . '">';
	}

	public function couvert_reservation_first_name_label_cb() {
		$first_name_label = get_option( $this->option_name . '_first_name_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_first_name_label' . '" id="' . $this->option_name . '_first_name_label' . '" value="' . $first_name_label . '">';
	}

	public function couvert_reservation_first_name_label_ph_cb() {
		$first_name_label_ph = get_option( $this->option_name . '_first_name_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_first_name_label_ph' . '" id="' . $this->option_name . '_first_name_label_ph' . '" value="' . $first_name_label_ph . '">';
	}

	public function couvert_reservation_last_name_label_cb() {
		$last_name_label = get_option( $this->option_name . '_last_name_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_last_name_label' . '" id="' . $this->option_name . '_last_name_label' . '" value="' . $last_name_label . '">';
	}

	public function couvert_reservation_last_name_label_ph_cb() {
		$last_name_label_ph = get_option( $this->option_name . '_last_name_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_last_name_label_ph' . '" id="' . $this->option_name . '_last_name_label_ph' . '" value="' . $last_name_label_ph . '">';
	}

	public function couvert_reservation_email_address_label_cb() {
		$email_address_label = get_option( $this->option_name . '_email_address_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_email_address_label' . '" id="' . $this->option_name . '_email_address_label' . '" value="' . $email_address_label . '">';
	}

	public function couvert_reservation_email_address_label_ph_cb() {
		$email_address_label_ph = get_option( $this->option_name . '_email_address_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_email_address_label_ph' . '" id="' . $this->option_name . '_email_address_label_ph' . '" value="' . $email_address_label_ph . '">';
	}

	public function couvert_reservation_phone_number_label_cb() {
		$phone_number_label = get_option( $this->option_name . '_phone_number_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_phone_number_label' . '" id="' . $this->option_name . '_phone_number_label' . '" value="' . $phone_number_label . '">';
	}

	public function couvert_reservation_phone_number_label_ph_cb() {
		$phone_number_label_ph = get_option( $this->option_name . '_phone_number_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_phone_number_label_ph' . '" id="' . $this->option_name . '_phone_number_label_ph' . '" value="' . $phone_number_label_ph . '">';
	}

	public function couvert_reservation_postal_code_label_cb() {
		$postal_code_label = get_option( $this->option_name . '_postal_code_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_postal_code_label' . '" id="' . $this->option_name . '_postal_code_label' . '" value="' . $postal_code_label . '">';
	}

	public function couvert_reservation_postal_code_label_ph_cb() {
		$postal_code_label_ph = get_option( $this->option_name . '_postal_code_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_postal_code_label_ph' . '" id="' . $this->option_name . '_postal_code_label_ph' . '" value="' . $postal_code_label_ph . '">';
	}

	public function couvert_reservation_gender_label_cb() {
		$gender_label = get_option( $this->option_name . '_gender_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_gender_label' . '" id="' . $this->option_name . '_gender_label' . '" value="' . $gender_label . '">';
	}

	public function couvert_reservation_gender_label_ph_cb() {
		$gender_label_ph = get_option( $this->option_name . '_gender_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_gender_label_ph' . '" id="' . $this->option_name . '_gender_label_ph' . '" value="' . $gender_label_ph . '">';
	}

	public function couvert_reservation_birth_day_label_cb() {
		$birth_day_label = get_option( $this->option_name . '_birth_day_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_birth_day_label' . '" id="' . $this->option_name . '_birth_day_label' . '" value="' . $birth_day_label . '">';
	}

	public function couvert_reservation_birth_day_label_ph_cb() {
		$birth_day_label_ph = get_option( $this->option_name . '_birth_day_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_birth_day_label_ph' . '" id="' . $this->option_name . '_birth_day_label_ph' . '" value="' . $birth_day_label_ph . '">';
	}

	public function couvert_reservation_message_label_cb() {
		$message_label = get_option( $this->option_name . '_message_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_message_label' . '" id="' . $this->option_name . '_message_label' . '" value="' . $message_label . '">';
	}

	public function couvert_reservation_message_label_ph_cb() {
		$message_label_ph = get_option( $this->option_name . '_message_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_message_label_ph' . '" id="' . $this->option_name . '_message_label_ph' . '" value="' . $message_label_ph . '">';
	}

	public function couvert_reservation_resvertaion_button_label_cb() {
		$resvertaion_button_label = get_option( $this->option_name . '_resvertaion_button_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_resvertaion_button_label' . '" id="' . $this->option_name . '_resvertaion_button_label' . '" value="' . $resvertaion_button_label . '">';
	}

	public function couvert_reservation_high_teal_label_cb() {
		$high_tea_label = get_option( $this->option_name . '_high_teal_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_high_teal_label' . '" id="' . $this->option_name . '_high_teal_label' . '" value="' . $high_tea_label . '">';
	}

	public function couvert_reservation_high_teal_label_ph_cb() {
		$high_tea_label_ph = get_option( $this->option_name . '_high_teal_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_high_teal_label_ph' . '" id="' . $this->option_name . '_high_teal_label' . '" value="' . $high_tea_label_ph . '">';
	}

	public function couvert_reservation_picknick_label_cb() {
		$picknick_label = get_option( $this->option_name . '_picknick_label' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_picknick_label' . '" id="' . $this->option_name . '_picknick_label' . '" value="' . $picknick_label . '">';
	}

	public function couvert_reservation_picknick_label_ph_cb() {
		$picknick_label_ph = get_option( $this->option_name . '_picknick_label_ph' );
		echo '<input type="text" class="regular-text" name="' . $this->option_name . '_picknick_label_ph' . '" id="' . $this->option_name . '_picknick_label_ph' . '" value="' . $picknick_label_ph . '">';
	}



}



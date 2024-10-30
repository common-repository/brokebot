<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       brokebot.com
 * @since      1.0.0
 *
 * @package    BrokeBot
 * @subpackage BrokeBot/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BrokeBot
 * @subpackage BrokeBot/admin
 * @author     BrokeBot <brokebot@gmail.com>
 */
class BrokeBot_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
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
		 * defined in Brokebot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Brokebot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name.'-select2', plugin_dir_url( __FILE__ ) . 'select2/css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/brokebot-admin.css', array(), $this->version, 'all' );
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
		 * defined in Brokebot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Brokebot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'-select2', plugin_dir_url( __FILE__ ) . 'select2/js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/brokebot-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'brokebot_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		* Add a settings page for this plugin to the Settings menu.
		*
		* NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		*
		*        Administration Menus: http://codex.wordpress.org/Administration_Menus
		*
		*/
		add_menu_page( 'BrokeBot', 'BrokeBot', 'manage_options', $this->plugin_name, array($this, 'display_plugin_settings_page')		);
		add_submenu_page( $this->plugin_name, 'Brokebot Options', 'Brokebot Options','manage_options','brokebot-settings', array($this, 'display_plugin_settings_page_general') );
		add_submenu_page( $this->plugin_name, 'Brokebot Support', 'Brokebot Support','manage_options','brokebot-support', array($this, 'display_plugin_settings_page_support') );
		
		//we only want the main link to show once, so we will remove it
		remove_submenu_page($this->plugin_name,$this->plugin_name);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
	$settings_link = array(
		'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	);
	return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_admin_page() {
		include_once( 'partials/brokebot-admin-display.php' );
	}

	public function display_plugin_settings_page_general() {
		set_query_var('tab', 'messaging-options');
		include_once( 'partials/brokebot-admin-settings.php' );
	}

	public function display_plugin_settings_page_messaging() {
		set_query_var('tab', 'messaging-options');
		include_once( 'partials/brokebot-admin-settings.php' );
	}
	public function display_plugin_settings_page_support() {
		include_once( 'partials/brokebot-admin-support.php' );
	}
	

	/**
	*
	* admin/class-brokebot-admin.php
	*
	**/
	public function options_update() {
		register_setting($this->plugin_name.'-general-options', $this->plugin_name.'-general-options', array($this, 'validate_general'));
		register_setting($this->plugin_name.'-messaging-options', $this->plugin_name.'-messaging-options', array($this, 'validate_messaging'));
	}

	/**
	*
	* admin/class-brokebot-admin.php
	*
	**/
	public function validate_general($input) {    
		$valid = array();

		//BrokeBot General Options
		$valid['brokebot_enable'] = (isset($input['brokebot_enable']) && !empty($input['brokebot_enable'])) ? 1 : 0;
		$valid['brokebot_testmode'] = (isset($input['brokebot_testmode']) && !empty($input['brokebot_testmode'])) ? 1: 0;
		$valid['brokebot_poweredby_optin'] = (isset($input['brokebot_poweredby_optin']) && !empty($input['brokebot_poweredby_optin'])) ? 1: 0;
		$valid['brokebot_theme'] = (isset($input['brokebot_theme']) && !empty($input['brokebot_theme'])) ? $input['brokebot_theme'] : 'light';	

		$resetCookies = (isset($input['brokebot_reset_cookies']) && !empty($input['brokebot_reset_cookies'])) ? $input['brokebot_reset_cookies']: $input['brokebot_reset_cookies'];
		if ($resetCookies) {
			$valid['brokebot_cookie_hide'] = 0;
			$valid['brokebot_cookie_days'] = '';
		} else {
			$valid['brokebot_cookie_hide'] = (isset($input['brokebot_cookie_hide']) && !empty($input['brokebot_cookie_hide'])) ? 1 : 0;
			$valid['brokebot_cookie_days'] = esc_html($input['brokebot_cookie_days']);	
		}
			

		$valid['brokebot_redirect_auto'] = (isset($input['brokebot_redirect_auto']) && !empty($input['brokebot_redirect_auto'])) ? 1: 0;
		$valid['brokebot_pages'] = (isset($input['brokebot_pages']) && !empty($input['brokebot_pages'])) ? $input['brokebot_pages'] : [];
		$valid['brokebot_posttypes'] = (isset($input['brokebot_posttypes']) && !empty($input['brokebot_posttypes'])) ? $input['brokebot_posttypes'] : [];

		return $valid;
	}

/**
	*
	* admin/class-brokebot-admin.php
	*
	**/
	public function validate_messaging($input) { 
		$valid = array();

		//BrokeBot General Options
		$valid['brokebot_welcome'] = esc_html($input['brokebot_welcome']);
		$valid['brokebot_follow_up'] = esc_html($input['brokebot_follow_up']);
		$valid['brokebot_cta_text'] = esc_html($input['brokebot_cta_text']);
		$valid['brokebot_redirect'] = esc_url($input['brokebot_redirect']);
		
		return $valid;
	}

	public function submit_support_form() {

		$full_name = sanitize_text_field($_POST['full_name']);
		$email = sanitize_email($_POST['email']);
		$subject = sanitize_text_field($_POST['subject']);
		$message = sanitize_text_field($_POST['message']);

		$to = 'support@getbrokebot.com';		
		$headers = array('Content-Type: text/html; charset=UTF-8');

		if (!validate_email($email)) {
			echo 'Please use a valid email address.';
			wp_die();
		}
		
		$sent = wp_mail( $to, 'Support message from '.$full_name.' <'.$email.'> : '.$subject, $message, $headers );

		if ($sent) {
			echo 'Support email sent successfully.';
		} else {
			echo 'Sorry, there was a problem sending your email. Please consider visiting our support page at getbrokebot.com.';
		}

		wp_die();
	}
}

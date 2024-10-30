<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       brokebot.com
 * @since      1.0.0
 *
 * @package    BrokeBot
 * @subpackage BrokeBot/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Brokebot
 * @subpackage Brokebot/public
 * @author     Brokebot <brokebot@gmail.com>
 */
class BrokeBot_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->general_options = get_option($this->plugin_name.'-general-options');
		$this->messaging_options = get_option($this->plugin_name.'-messaging-options');		
		

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/brokebot-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		
		 

		 if ($this->general_options['brokebot_enable'] || ($this->general_options['brokebot_testmode'] && in_array('administrator',  wp_get_current_user()->roles) ) ) {

			
			

			global $wp_query;

			//check if allowed page or allowed post
			if ( in_array($wp_query->queried_object->ID, $this->general_options['brokebot_pages']) || in_array($wp_query->queried_object->post_type, $this->general_options['brokebot_posttypes']) ) {
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/brokebot-public.js', array( 'jquery' ), $this->version, false );
				wp_localize_script( $this->plugin_name, 'brokebot_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			}

		 }
	}

	/**
	 * Prepare any Frontend functionality here.
	 *
	 * @since    1.0.0
	 */
	public function brokebot_public_actions() {

	}

	public function get_brokebot_content() {

		//TODO conditional check for additional classes

		$style = str_replace('__PLUGIN_URL__',plugin_dir_url( __FILE__ ),file_get_contents(plugin_dir_url( __FILE__ ) . 'css/brokebot-public-'.$this->general_options['brokebot_theme'].'.css'));
		echo json_encode(array(
			'brokebot_welcome' => $this->messaging_options['brokebot_welcome'],
			'brokebot_follow_up' => $this->messaging_options['brokebot_follow_up'],
			'brokebot_cta_text' => $this->messaging_options['brokebot_cta_text'],
			'brokebot_redirect' => $this->messaging_options['brokebot_redirect'],
			'brokebot_redirect_auto' => $this->general_options['brokebot_redirect_auto'],
			'brokebot_cookie_hide' => $this->general_options['brokebot_cookie_hide'],
			'brokebot_cookie_days' => $this->general_options['brokebot_cookie_days'],
			'brokebot_poweredby_optin' => $this->general_options['brokebot_poweredby_optin'],
			
			'brokebot_markup' => '<style>'.$style.'</style><div id="brokebot-frontend-widget-loader" class="closed"><div id="brokebot_widget_icon" class="icon"></div></div>',
			
		));
		wp_die();
	}

	


}

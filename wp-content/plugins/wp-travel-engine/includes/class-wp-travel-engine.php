<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * 
 * @since      1.0.0
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 */
class Wp_Travel_Engine {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Travel_Engine_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-travel-engine';
		$this->version = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->init_shortcodes();
		add_filter( 'widget_text','do_shortcode' );
		add_filter( 'meta_content', 'wptexturize'        );
		add_filter( 'meta_content', 'convert_smilies'    );
		add_filter( 'meta_content', 'convert_chars'      );
		add_filter( 'meta_content', 'shortcode_unautop'  );
		add_filter( 'meta_content', 'prepend_attachment' );
		add_filter( 'meta_content', 'do_shortcode');
		add_filter( 'term_description','wpautop' );
		add_filter( 'the_content', array( $this, 'wpte_the_content_filter'),99999999999 );
	}

	//remove br tag from content
	function wpte_the_content_filter($content) {
   		$content = str_replace("<br />","", $content);
		return $content;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Travel_Engine_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Travel_Engine_i18n. Defines internationalization functionality.
	 * - Wp_Travel_Engine_Admin. Defines all hooks for the admin area.
	 * - Wp_Travel_Engine_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-travel-engine-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-travel-engine-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-travel-engine-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-travel-engine-public.php';

		/**
		 * The class responsible for building tabs in post type.
		 * side of the site.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-meta-tabs.php';

		/**
		 * The class responsible for defining tabs in custom post type.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/admin/class-wp-travel-engine-tabs.php';

		/**
		 * The class responsible for defining functions for backend.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-functions.php';

		/**
		 * The class responsible for defining templates.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/class-wp-travel-engine-templates.php';

		/**
		 * The class responsible for placing order.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-place-order.php';

		/**
		 * The class responsible for thank you.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-thank-you.php';	
		/**
		 * The class responsible for final confirmation.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-confirmation.php';;	
		/**
		 * The class responsible for creating metas for order form.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-order-meta.php';		

		/**
		 * The class responsible for creating meta tags for single trip.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/trip-meta/class-wp-travel-engine-meta-tags.php';

		/**
		 * The class responsible for creating hoks for archive.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-archive-hooks.php';

		/**
		 * The class responsible for creating widget area.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wte-widget-area-admin.php';

		/**
		 * The class responsible for showing widgets from widget area.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wte-widget-area-main.php';

		/**
		 * The class responsible for showing image field in taxonomies.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/class-wp-travel-engine-taxonomy-thumb.php';

		/**
		 * Including the mail class.
		 */
		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/class-wp-travel-engine-mail.php';

		/**
		 * Including the trip facts shortcode.
		 */
		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/frontend/trip-meta/trip-meta-parts/trip-facts-shortcode.php';

		/**
		 * Including the trip facts shortcode.
		 */
		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/class-wp-travel-engine-enquiry-form-shortcodes.php';

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        
		if(!is_plugin_active( 'wte-paypal-gateway/wte-paypal-gateway.php' ))
        {
            require_once WP_TRAVEL_ENGINE_BASE_PATH . '/includes/ipnlistener.php';
        }
		
		/**
		 * Including the gallery metabox main file for trip post type.
		 */
		require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/backend/vendor/gallery.php';
		
		// include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/class-wpte-license-handler.php';
       
        /**
		 * Including the trip facts shortcode.
		 */
		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/privacy-functions.php';

		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/class-wp-travel-engine-reorder-trips.php';
		include WP_TRAVEL_ENGINE_BASE_PATH. '/includes/class-wp-travel-engine-custom-shortcodes.php';

		$this->loader = new Wp_Travel_Engine_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Travel_Engine_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Travel_Engine_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Travel_Engine_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init',  $plugin_admin, 'wp_travel_engine_register_trip' );
		$this->loader->add_action( 'init',  $plugin_admin, 'wp_travel_engine_register_booking' );
		$this->loader->add_action( 'init',  $plugin_admin, 'wp_travel_engine_register_customer' );
		$this->loader->add_action( 'init',  $plugin_admin, 'wp_travel_engine_register_enquiry' );
		$this->loader->add_action( 'admin_menu' , $plugin_admin, 'wp_travel_engine_settings_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wp_travel_engine_register_settings' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'wp_travel_engine_tabs_template', 0 );
		$this->loader->add_filter( 'manage_enquiry_posts_columns', $plugin_admin, 'wp_travel_engine_enquiry_cpt_columns');
		$this->loader->add_action( 'manage_posts_custom_column' , $plugin_admin, 'wp_travel_engine_enquiry_custom_columns', 10, 2 );
		$this->loader->add_filter( 'manage_booking_posts_columns', $plugin_admin, 'wp_travel_engine_booking_cpt_columns');
		$this->loader->add_action( 'manage_posts_custom_column' , $plugin_admin, 'wp_travel_engine_booking_custom_columns', 10, 2 );
		$this->loader->add_filter( 'manage_customer_posts_columns', $plugin_admin, 'wp_travel_engine_customer_cpt_columns');
		$this->loader->add_action( 'manage_posts_custom_column' , $plugin_admin, 'wp_travel_engine_customer_custom_columns', 10, 2 );
		$this->loader->add_filter( 'manage_edit-trip_types_columns', $plugin_admin, 'wp_travel_engine_trip_types_columns', 10, 2 );
		$this->loader->add_action( 'manage_trip_types_custom_column' , $plugin_admin, 'wp_travel_engine_trip_types_custom_columns', 10, 3 );
		$this->loader->add_filter( 'manage_edit-destination_columns', $plugin_admin, 'wp_travel_engine_trip_types_columns', 10, 2 );
		$this->loader->add_action( 'manage_destination_custom_column' , $plugin_admin, 'wp_travel_engine_trip_types_custom_columns', 10, 3 );
		$this->loader->add_filter( 'manage_edit-activities_columns', $plugin_admin, 'wp_travel_engine_trip_types_columns', 10, 2 );
		$this->loader->add_action( 'manage_activities_custom_column' , $plugin_admin, 'wp_travel_engine_trip_types_custom_columns', 10, 3 );
		$this->loader->add_action( 'admin_head-post.php', $plugin_admin, 'hide_publishing_actions', 10, 2 );
		$this->loader->add_action( 'init', $plugin_admin, 'wp_travel_engine_create_destination_taxonomies' );
		$this->loader->add_action( 'init', $plugin_admin, 'wp_travel_engine_create_activities_taxonomies' );
		$this->loader->add_action( 'init', $plugin_admin, 'wp_travel_engine_create_trip_types_taxonomies' );
   		
   		if(isset($_GET['page']) && $_GET['page'] == 'class-wp-travel-engine-admin.php')
   		{
   			$this->loader->add_action( 'admin_footer', $plugin_admin, 'wp_travel_engine_get_icon_list', 20 );
   			$this->loader->add_action( 'admin_footer', $plugin_admin, 'trip_facts_template', 20 );
		}
		
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'wpte_add_itinerary_template', 20 );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'wpte_add_faq_template', 20 );
   		$this->loader->add_action( 'wp_ajax_wp_add_trip_info', $plugin_admin, 'wp_add_trip_info' );
		$this->loader->add_action( 'wp_ajax_nopriv_wp_add_trip_info', $plugin_admin, 'wp_add_trip_info' );
		$this->loader->add_action( 'wp_loaded', $plugin_admin, 'wpte_add_destination_templates' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'wte_paypal_gateway_notice' );
    	$this->loader->add_action( 'admin_init', $plugin_admin,'wte_paypal_gateway_notice_ignore' );
		$this->loader->add_action( 'wte_paypal_form', $plugin_admin, 'wte_paypal_form' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'wpte_trip_pay_add_meta_boxes' );
        $this->loader->add_action( 'save_post', $plugin_admin, 'wp_travel_engine_trip_pay_meta_box_data' );
    	$this->loader->add_action( 'admin_notices', $plugin_admin, 'wp_travel_engine_activate_notice' );
    	$this->loader->add_action( 'admin_init', $plugin_admin,'wp_travel_engine_activate_notice_ignore' );
		$this->loader->add_action( 'admin_menu' , $plugin_admin, 'wp_travel_engine_extensions_page' );
		$this->loader->add_action( 'admin_menu' , $plugin_admin, 'wp_travel_engine_themes_page' );
		$this->loader->add_filter( 'tiny_mce_before_init', $plugin_admin, 'wte_tinymce_config' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Travel_Engine_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public,'wpte_start_session', 1 );
		$this->loader->add_action( 'wte_cart_trips', $plugin_public, 'wte_cart_trips' );
		$this->loader->add_action( 'wp_ajax_wp_add_trip_cart', $plugin_public, 'wp_add_trip_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_wp_add_trip_cart', $plugin_public, 'wp_add_trip_cart' );
		$this->loader->add_action( 'wte_update_cart', $plugin_public, 'wte_update_cart' );
		$this->loader->add_action( 'wte_cart_form_wrapper', $plugin_public, 'wte_cart_form_wrapper' );
		$this->loader->add_action( 'wte_cart_form_close', $plugin_public, 'wte_cart_form_close' );
		$this->loader->add_action( 'wp_ajax_wte_remove_order', $plugin_public, 'wte_remove_from_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_wte_remove_order', $plugin_public, 'wte_remove_from_cart' );
		$this->loader->add_action( 'wp_ajax_wte_update_cart', $plugin_public, 'wte_ajax_update_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_wte_update_cart', $plugin_public, 'wte_ajax_update_cart' );
		$this->loader->add_action( 'wte_payment_gateways_dropdown', $plugin_public, 'wte_payment_gateways_dropdown' );
        $this->loader->add_action( 'wp_travel_engine_feat_img_trip_galleries', $plugin_public, 'wp_travel_engine_feat_img_trip_galleries' ); 
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wpte_be_load_more_js' );
		$this->loader->add_action( 'wp_ajax_wpte_ajax_load_more', $plugin_public, 'wpte_ajax_load_more' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpte_ajax_load_more', $plugin_public, 'wpte_ajax_load_more' );
		$this->loader->add_action( 'wp_ajax_wpte_ajax_load_more_destination', $plugin_public, 'wpte_ajax_load_more_destination' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpte_ajax_load_more_destination', $plugin_public, 'wpte_ajax_load_more_destination' );
		$this->loader->add_action( 'wp_ajax_wpte_ajax_load_more', $plugin_public, 'wpte_be_load_more_js' );
    	$this->loader->add_action( 'wp_ajax_nopriv_wpte_ajax_load_more', $plugin_public, 'wpte_be_load_more_js' );
		$this->loader->add_action( 'init', $plugin_public, 'do_output_buffer' );
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true );
		if(isset($wp_travel_engine_settings['paypal_payment']))
		{
			$this->loader->add_filter( 'wte_payment_gateways_dropdown_options', $plugin_public,'wte_paypal_add_option' );
		}
		if(isset($wp_travel_engine_settings['test_payment']))
		{
			$this->loader->add_filter( 'wte_payment_gateways_dropdown_options', $plugin_public,'wte_test_add_option' );
		}
		$this->loader->add_action( 'wp_ajax_wte_payment_gateway', $plugin_public, 'wte_payment_gateway' );
		$this->loader->add_action( 'wp_ajax_nopriv_wte_payment_gateway', $plugin_public, 'wte_payment_gateway');
		$this->loader->add_action( 'wp_footer', $plugin_public, 'wpte_calendar_custom_code' );
   	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Travel_Engine_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
   
   /**
    * Init shortcodes.
    *
    * @since    1.0.0
    */
    public function init_shortcodes(){

    	$plugin_shortcode = new Wp_Travel_Engine_Place_Order();
    	$plugin_shortcode->init();
    	$plugin_shortcode = new Wp_Travel_Engine_Thank_You();
    	$plugin_shortcode->init();
    	$plugin_shortcode = new Wp_Travel_Engine_Order_Confirmation();
    	$plugin_shortcode->init();
    }
}
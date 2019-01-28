<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * 
 * @since      1.0.0
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/admin
 */
class Wp_Travel_Engine_Admin {

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
		add_image_size( 'trip-thumb-size', 374, 226, true ); // 260 pixels wide by 210 pixels tall, hard crop mode
		add_image_size( 'destination-thumb-size', 300, 275, true ); // 260 pixels wide by 210 pixels tall, hard crop mode
		add_image_size( 'destination-thumb-trip-size', 410, 250, true );
		add_image_size( 'activities-thumb-size', 300, 405, true ); // 260 pixels wide by 210 pixels tall, hard crop mode
		add_image_size( 'trip-single-size', 990, 490, true ); // 800 pixels wide by 284 pixels tall, hard crop mode
		// remove_filter( 'the_content', 'wpautop' );
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
		 * defined in Travel_Triping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Travel_Triping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
    	$screen = get_current_screen();  
		if( $screen->post_type=='trip' || $screen->post_type=='enquiry' || $screen->post_type=='booking' || $screen->post_type=='customer' || isset($_GET['page']) && $_GET['page']=='class-wp-travel-engine-admin.php' || $screen->id=='trip_page_class-wp-travel-engine-admin' )
    	{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-travel-engine-admin.css', array(), $this->version, 'all' );
    	}
    	if( $screen->post_type=='trip' )
		{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpte-gallery-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name.'gallery-metabox', plugin_dir_url( __FILE__ ) . 'css/gallery-metabox.css', array(), $this->version, 'all' );
		}
    	if( $screen->post_type=='booking' || $screen->post_type=='customer' )
		{
			wp_enqueue_style('datepicker-style', plugin_dir_url( __FILE__ ) . 'css/datepicker-style.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( 'FontAwesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
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
		 * defined in Travel_Triping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Travel_Triping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$screen = get_current_screen(); 
    	if($screen->post_type=='trip' || $screen->post_type=='booking' || isset($_GET['page']) && $_GET['page']=='class-wp-travel-engine-admin.php' || $screen->id=='trip_page_class-wp-travel-engine-admin')
    	{
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-sortable' ), $this->version, false );
			$extra_array = array(
					'lang' => array(
						'are_you_sure_tab'       => __( 'Deleting the tab will also delete all the information associated with the tab. Are you sure you want to delete it?', 'wp-travel-engine' ),
						'are_you_sure_fact'		 => __('Deleting the Trip Fact will also delete the information associated with it. Are you sure you want to delete it?', 'wp-travel-engine'),
						'are_you_sure_faq'		 => __('Deleting this will also delete the information associated with it. Are you sure you want to delete it?', 'wp-travel-engine'),
					),
				);
			wp_localize_script( $this->plugin_name, 'WPTE_OBJ', $extra_array );
			wp_localize_script(
			$this->plugin_name,
			'WTEAjaxData',
			array( 'ajaxurl' => admin_url('admin-ajax.php') )
			);
			wp_enqueue_script( $this->plugin_name );
			wp_enqueue_script( $this->plugin_name.'media-logo-upload', plugin_dir_url( __FILE__ ) . 'js/media-upload.js', array( 'jquery' ), $this->version, false );
		}
		
		if( $screen->post_type=='trip' || $screen->post_type=='booking' || $screen->post_type=='customer' )
		{
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( $this->plugin_name.'custom', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
		}
		if( $screen->post_type=='trip' )
		{
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpte-gallery-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name.'gallery-metabox', plugin_dir_url( __FILE__ ) . 'js/gallery-metabox.js', array( 'jquery' ), $this->version, false );
		}
		wp_enqueue_media();
	}


	/**
	 * Register a Trip post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function wp_travel_engine_register_trip() {
		$labels = array(
			'name'               => _x( 'Trips', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Trip', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'Trips', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Trip', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Trip', 'wp-travel-engine' ),
			'add_new_item'       => __( 'Add New Trip', 'wp-travel-engine' ),
			'new_item'           => __( 'New Trip', 'wp-travel-engine' ),
			'edit_item'          => __( 'Edit Trip', 'wp-travel-engine' ),
			'view_item'          => __( 'View Trip', 'wp-travel-engine' ),
			'all_items'          => __( 'All Trips', 'wp-travel-engine' ),
			'search_items'       => __( 'Search Trips', 'wp-travel-engine' ),
			'parent_item_colon'  => __( 'Parent Trips:', 'wp-travel-engine' ),
			'not_found'          => __( 'No Trips found.', 'wp-travel-engine' ),
			'not_found_in_trash' => __( 'No Trips found in Trash.', 'wp-travel-engine' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'wp-travel-engine' ),
			'public'             => true,
			'menu_icon' 		 => 'dashicons-location-alt',
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite' 			 => array( 'slug' => 'trip' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'trip', $args );
		// flush_rewrite_rules();
	}

	/**
	 * Register a Enquiry post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function wp_travel_engine_register_enquiry() {
		$labels = array(
			'name'               => _x( 'Enquiries', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Enquiry', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'Enquiries', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Enquiry', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Enquiry', 'wp-travel-engine' ),
			'add_new_item'       => __( 'Add New Enquiry', 'wp-travel-engine' ),
			'new_item'           => __( 'New Enquiry', 'wp-travel-engine' ),
			'edit_item'          => __( 'Edit Enquiry', 'wp-travel-engine' ),
			'view_item'          => __( 'View Enquiry', 'wp-travel-engine' ),
			'all_items'          => __( 'All Enquiries', 'wp-travel-engine' ),
			'search_items'       => __( 'Search Enquiries', 'wp-travel-engine' ),
			'parent_item_colon'  => __( 'Parent Enquiries:', 'wp-travel-engine' ),
			'not_found'          => __( 'No Enquiries found.', 'wp-travel-engine' ),
			'not_found_in_trash' => __( 'No Enquiries found in Trash.', 'wp-travel-engine' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'wp-travel-engine' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=trip',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'enquiry' ),
			'capability_type' 	 => 'post',
  			'capabilities' 		 => array(
    			'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
  			),
  			'map_meta_cap' 		 => true, // Set to `false`, if users are not allowed to edit/delete existing posts
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'enquiry', $args );
		// flush_rewrite_rules();
	}

	/**
	 * Register a Booking History post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function wp_travel_engine_register_booking() {
		$labels = array(
			'name'               => _x( 'Bookings', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Booking', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'Bookings', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Booking', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Booking', 'wp-travel-engine' ),
			'add_new_item'       => __( 'Add New Booking', 'wp-travel-engine' ),
			'new_item'           => __( 'New Booking', 'wp-travel-engine' ),
			'edit_item'          => __( 'Edit Booking', 'wp-travel-engine' ),
			'view_item'          => __( '', 'wp-travel-engine' ),
			'all_items'          => __( 'All Bookings', 'wp-travel-engine' ),
			'search_items'       => __( 'Search Bookings', 'wp-travel-engine' ),
			'parent_item_colon'  => __( 'Parent Bookings:', 'wp-travel-engine' ),
			'not_found'          => __( 'No Bookings found.', 'wp-travel-engine' ),
			'not_found_in_trash' => __( 'No Bookings found in Trash.', 'wp-travel-engine' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'wp-travel-engine' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=trip',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'booking' ),
			'capability_type' => 'post',
  			'capabilities' => array(
    			'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
  			),
  			'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'booking', $args );
		flush_rewrite_rules();
	}


	/**
	 * Register a Customer History post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function wp_travel_engine_register_customer() {
		$labels = array(
			'name'               => _x( 'Customers', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Customer', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'Customers', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Customer', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Customer', 'wp-travel-engine' ),
			'add_new_item'       => __( 'Add New Customer', 'wp-travel-engine' ),
			'new_item'           => __( 'New Customer', 'wp-travel-engine' ),
			'edit_item'          => __( 'Edit Customer', 'wp-travel-engine' ),
			'view_item'          => __( '', 'wp-travel-engine' ),
			'all_items'          => __( 'All Customers', 'wp-travel-engine' ),
			'search_items'       => __( 'Search Customers', 'wp-travel-engine' ),
			'parent_item_colon'  => __( 'Parent Customers:', 'wp-travel-engine' ),
			'not_found'          => __( 'No Customers found.', 'wp-travel-engine' ),
			'not_found_in_trash' => __( 'No Customers found in Trash.', 'wp-travel-engine' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'wp-travel-engine' ),
			'public'             => false,
			'menu_icon' 		 => 'dashicons-location-alt',
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=trip',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'customer' ),
			'capability_type' => 'post',
		  	'capabilities' => array(
		    	'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
		  	),
		  	'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'customer', $args );
		flush_rewrite_rules();
	}
	
	/**
	 * Remove column author and date and add trip id, trip name, travelers and cost column.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_booking_cpt_columns($columns) {
	
		unset(
			$columns['author']
			// $columns['date']
		);
		$new_columns = array(
			'tid' 		=> __( 'Trip ID', 'wp-travel-engine' ),
			'tname' 	=> __( 'Trip Name', 'wp-travel-engine' ),
			'travelers' => __( 'Travelers', 'wp-travel-engine' ),
			'paid'		=> __('Total Paid','wp-travel-engine'),
			'remaining'	=> __('Remaining Payment','wp-travel-engine'),
			'cost' 		=> __( 'Total Cost', 'wp-travel-engine' ),
		);
	    return array_merge( $columns, $new_columns );
	}

	/**
	 * Add Enquiry column in the enquiry list.
	 * @since    1.0.0
	 */
	function wp_travel_engine_enquiry_cpt_columns($columns) {

		$new_columns = array(
			'country' => __( 'Country', 'wp-travel-engine' ),
			'email'	  => __( 'Email', 'wp-travel-engine' ),
			'contact' => __( 'Contact', 'wp-travel-engine' ),
			'adults'  => __( 'Adults', 'wp-travel-engine' ),
			'children'=> __( 'Children', 'wp-travel-engine' ),
			'message' => __( 'Message', 'wp-travel-engine' )
		);
	    return array_merge( $columns, $new_columns );
	}

		/**
	 * Show value to the corresponsing columns for booking post type.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_enquiry_custom_columns( $column, $post_id ) {
		$wp_travel_engine_setting = get_post_meta( $post_id, 'wp_travel_engine_setting', true );
		// echo $wp_travel_engine_setting['enquiry']['message'];
		$screen = get_current_screen();
		if( $screen->post_type=='enquiry' ){
			switch ( $column ) {

				case 'country':
					echo isset( $wp_travel_engine_setting['enquiry']['country'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['country'] ):'-' ; 
					break;

				case 'email':
					echo isset( $wp_travel_engine_setting['enquiry']['email'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['email'] ):'-' ;
					break;
					
				case 'contact':
					echo isset( $wp_travel_engine_setting['enquiry']['contact'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['contact'] ):'-' ;
				break;

				case 'adults':
				 	echo isset( $wp_travel_engine_setting['enquiry']['adults'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['adults'] ):'-' ;
				break;

				case 'children':
				 	echo isset( $wp_travel_engine_setting['enquiry']['children'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['children'] ):'-' ;
				break;

				case 'message':
					echo isset( $wp_travel_engine_setting['enquiry']['message'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['message'] ):'-' ;
				break;
			}
		}
	}

	/**
	 * Show value to the corresponsing columns for booking post type.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_booking_custom_columns( $column, $post_id ) {
		$terms = get_post_meta( $post_id, 'wp_travel_engine_booking_setting', true );
	    $wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true); 
		$screen = get_current_screen();
		if( $screen->post_type=='booking' || $screen->post_type=='customer' ){
			switch ( $column ) {
				case 'tid':
					if ( isset( $terms['place_order']['tid'] ) ) {
						
						echo '<a href="'.get_edit_post_link( $terms["place_order"]["tid"], "display" ).'">'.esc_attr( $terms["place_order"]["tid"] ).'</a>'; 
					} 
					break;	

				case 'tname':
					if ( isset( $terms['place_order']['tname'] ) ) {
						echo esc_attr( $terms['place_order']['tname'] );
					} 
					break;

				case 'travelers':
					if ( isset( $terms['place_order']['traveler'] ) ) {
						echo esc_attr( $terms['place_order']['traveler'] );
					} 
					break;
					
				case 'cost':
					$code = 'USD';
				    if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
				    {
				        $code = $wp_travel_engine_setting_option_setting['currency_code'];
				    } 
				    $obj = new Wp_Travel_Engine_Functions();
				    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
				    echo esc_attr($currency);
				    
				 	if( isset( $terms['place_order']['cost'] ) ){
						echo esc_attr( $terms['place_order']['cost'] );
					} 
				break;

				case 'remaining':
				    
				 	if( isset( $terms['place_order']['due'] ) && $terms['place_order']['due']!='' ){
						$code = 'USD';
					    if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
					    {
					        $code = $wp_travel_engine_setting_option_setting['currency_code'];
					    } 
					    $obj = new Wp_Travel_Engine_Functions();
					    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
					    echo esc_attr($currency);
						echo esc_attr( $terms['place_order']['due'] );
					}
					else{
						echo '-';
					} 
				break;

				case 'paid':
				    
				 	if( isset( $terms['place_order']['due'] ) && $terms['place_order']['due']!='' ){
						$code = 'USD';
					    if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
					    {
					        $code = $wp_travel_engine_setting_option_setting['currency_code'];
					    } 
					    $obj = new Wp_Travel_Engine_Functions();
					    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
					    echo esc_attr($currency);
						echo esc_attr( $terms['place_order']['cost']-$terms['place_order']['due'] );
					}
					else{
						$code = 'USD';
					    if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
					    {
					        $code = $wp_travel_engine_setting_option_setting['currency_code'];
					    } 
					    $obj = new Wp_Travel_Engine_Functions();
					    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
					    echo esc_attr($currency);
						echo esc_attr( $terms['place_order']['cost'] );
					} 
				break;
			}
		}
	}

	/**
	 * Add column Thumbnail.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_trip_types_columns($columns) {
		$new_columns = array(
			'thumb_id' 		=> __( 'Thumbnail', 'wp-travel-engine' ),
		);
	    return array_merge( $columns, $new_columns );
	}

	/**
	 * Show thumbnail.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_trip_types_custom_columns( $column,$term_id,$tid  ) {
		$image_id = get_term_meta ( $tid, 'category-image-id', true );
		if ( $image_id ) {
			echo wp_get_attachment_image ( $image_id, 'thumb' );
		} 
	}

	/**
	 * Remove column author and date and add customer id, country, bookings, total spent and created column.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_customer_cpt_columns($columns) {
	
		unset(
			$columns['date']
		);
		$new_columns = array(
			'cid' 		=> __( 'Customer ID', 'wp-travel-engine' ),
			'country' 	=> __( 'Country', 'wp-travel-engine' ),
			'bookings'  => __( 'Bookings', 'wp-travel-engine' ),
			'spent' 	=> __( 'Total Spent', 'wp-travel-engine' ),
			'created' 	=> __( 'Created', 'wp-travel-engine' ),
		);
	    return array_merge( $columns, $new_columns );
	}

	/**
	 * Show value to the corresponsing columns for customer post type.
	 *
	 * @since    1.0.0
	 */
	function wp_travel_engine_customer_custom_columns( $column, $post_id ) {
		$screen = get_current_screen();
		if( $screen->post_type=='booking' || $screen->post_type=='customer' ){
			$terms = get_post_meta( $post_id, 'wp_travel_engine_booking_setting', true );
			$var = get_page_by_title( $terms['place_order']['booking']['email'], OBJECT, 'customer' );
			$wp_travel_engine_booked_settings = get_post_meta( $var->ID, 'wp_travel_engine_booked_trip_setting', true );
			$size = sizeof( $wp_travel_engine_booked_settings['traveler'] );
	    	$wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true); 

			switch ( $column ) {
				case 'cid':
					echo esc_attr( $post_id );
					break;	

				case 'country':
					if ( isset( $terms['place_order']['booking']['country'] ) ) {
						echo esc_attr( $terms['place_order']['booking']['country'] );
					} 
					break;

				case 'bookings':
					echo $size;
					break;
					
				case 'spent':
					(int)$tot = null;
					foreach ($wp_travel_engine_booked_settings['cost'] as $key => $value) {
						$value = str_replace( ',','',$value );
						$tot = $tot + $value;
					}
					$code = 'USD';
	                if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
	                {
	                    $code = $wp_travel_engine_setting_option_setting['currency_code'];
	                } 
	                $obj = new Wp_Travel_Engine_Functions();
	                $currency = $obj->wp_travel_engine_currencies_symbol( $code );
	                echo esc_attr($currency.$obj->wp_travel_engine_price_format($tot).' '.$code);
					break;

				case 'created':
					echo end($wp_travel_engine_booked_settings['datetime']); 
				break;
			}
		}
	}
   	
   	/**
	 * Register a taxonomy, 'destination' for the post type "trip".
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	// create taxonomy, destination for the post type "trip"
	function wp_travel_engine_create_destination_taxonomies() {
		// Add new taxonomy, make it hierarchical (like destination)
		$labels = array(
			'name'              => _x( 'Destinations', 'taxonomy general name', 'wp-travel-engine' ),
			'singular_name'     => _x( 'Destinations', 'taxonomy singular name', 'wp-travel-engine' ),
			'search_items'      => __( 'Search Destinations', 'wp-travel-engine' ),
			'all_items'         => __( 'All Destinations', 'wp-travel-engine' ),
			'parent_item'       => __( 'Parent Destinations', 'wp-travel-engine' ),
			'parent_item_colon' => __( 'Parent Destinations', 'wp-travel-engine' ),
			'edit_item'         => __( 'Edit Destinations', 'wp-travel-engine' ),
			'update_item'       => __( 'Update Destinations', 'wp-travel-engine' ),
			'add_new_item'      => __( 'Add New Destinations', 'wp-travel-engine' ),
			'new_item_name'     => __( 'New Destinations Name', 'wp-travel-engine' ),
			'menu_name'         => __( 'Destinations', 'wp-travel-engine' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'destinations' ),
		);

		register_taxonomy( 'destination', array( 'trip' ), $args );
	}
  
	/**
	 * Register a taxonomy, 'activities' for the post type "trip".
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	// create taxonomy, destination for the post type "trip"
	function wp_travel_engine_create_activities_taxonomies() {
		// Add new taxonomy, make it hierarchical (like destination)
		$labels = array(
			'name'              => _x( 'Activities', 'taxonomy general name', 'wp-travel-engine' ),
			'singular_name'     => _x( 'Activities', 'taxonomy singular name', 'wp-travel-engine' ),
			'search_items'      => __( 'Search Activities', 'wp-travel-engine' ),
			'all_items'         => __( 'All Activities', 'wp-travel-engine' ),
			'parent_item'       => __( 'Parent Activities', 'wp-travel-engine' ),
			'parent_item_colon' => __( 'Parent Activities', 'wp-travel-engine' ),
			'edit_item'         => __( 'Edit Activities', 'wp-travel-engine' ),
			'update_item'       => __( 'Update Activities', 'wp-travel-engine' ),
			'add_new_item'      => __( 'Add New Activities', 'wp-travel-engine' ),
			'new_item_name'     => __( 'New Activities Name', 'wp-travel-engine' ),
			'menu_name'         => __( 'Activities', 'wp-travel-engine' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'activities' ),
		);

		register_taxonomy( 'activities', array( 'trip' ), $args );
	}


	/**
	 * Register a taxonomy, 'trip types' for the post type "trip".
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	// create taxonomy, destination for the post type "trip"
	function wp_travel_engine_create_trip_types_taxonomies() {
		// Add new taxonomy, make it hierarchical (like destination)
		$labels = array(
			'name'              => _x( 'Trip Type', 'taxonomy general name', 'wp-travel-engine' ),
			'singular_name'     => _x( 'Trip Type', 'taxonomy singular name', 'wp-travel-engine' ),
			'search_items'      => __( 'Search Trip Type', 'wp-travel-engine' ),
			'all_items'         => __( 'All Trip Type', 'wp-travel-engine' ),
			'parent_item'       => __( 'Parent Trip Type', 'wp-travel-engine' ),
			'parent_item_colon' => __( 'Parent Trip Type', 'wp-travel-engine' ),
			'edit_item'         => __( 'Edit Trip Type', 'wp-travel-engine' ),
			'update_item'       => __( 'Update Trip Type', 'wp-travel-engine' ),
			'add_new_item'      => __( 'Add New Trip Type', 'wp-travel-engine' ),
			'new_item_name'     => __( 'New Trip Type Name', 'wp-travel-engine' ),
			'menu_name'         => __( 'Trip Type', 'wp-travel-engine' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'trip-types' ),
		);

		register_taxonomy( 'trip_types', array( 'trip' ), $args );
	}

   /**
	* Registers settings page for Trip.
	*
	* @since 1.0.0
	*/
	public function wp_travel_engine_settings_page() {
		add_submenu_page('edit.php?post_type=trip', 'WP Travel Engine Admin Settings', 'Settings', 'manage_options', basename(__FILE__), array($this,'wp_travel_engine_callback_function'));
	}

   /**
	* Registers settings for WP travel Engine.
	*
	* @since 1.0.0
	*/
	public function wp_travel_engine_register_settings(){
	//The third parameter is a function that will validate input values.
		register_setting('wp_travel_engine_settings', 'wp_travel_engine_settings','');
	}

   /**
	* 
	* Retrives saved settings from the database if settings are saved. Else, displays fresh forms 	 for settings.
	*
	* @since 1.0.0
	*/
	function wp_travel_engine_callback_function() { 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-travel-engine-settings.php'; 
		$Wp_Travel_Engine_Settings = new Wp_Travel_Engine_Settings();
		$Wp_Travel_Engine_Settings->wp_travel_engine_backend_settings();
		$option = get_option('wp_travel_engine_settings');
	} 

   /**
	* 
	* HTML template for tabs
	*
	* @since 1.0.0
	*/
	function wp_travel_engine_tabs_template() { ?>
	<div id="trip-template">
		<li id="trip-tabs{{index}}" data-id="{{index}}" class="trip-row">
			<span class="tabs-handle"></span>
			<i class="dashicons dashicons-no-alt delete-tab delete-icon" data-id="{{index}}"></i>    
	        <a class="accordion-tabs-toggle" href="javascript:void(0);"><span class="dashicons dashicons-arrow-down custom-toggle-tabs rotator"></span></a>
	        <div class="tabs-content">
	        	<div class="tabs-id">
					<input type="hidden" class="trip-tabs-id" name="wp_travel_engine_settings[trip_tabs][id][{{index}}]" id="wp_travel_engine_settings[trip_tabs][id][{{index}}]" value="{{index}}">
				</div>
				<div class="tabs-field">
					<input type="hidden" class="trip-tabs-id" name="wp_travel_engine_settings[trip_tabs][field][{{index}}]" id="wp_travel_engine_settings[trip_tabs][field][{{index}}]" value="wp_editor">
				</div>
				<div class="tabs-name">
					<label for="wp_travel_engine_settings[trip_tabs][name][{{index}}]"><?php _e('Tab Name:','wp-travel-engine'); ?><span class="required">*</span></label>
					<input type="text" class="trip-tabs-name" name="wp_travel_engine_settings[trip_tabs][name][{{index}}]" id="wp_travel_engine_settings[trip_tabs][name][{{index}}]" required>
					<div class="settings-note"><?php _e( 'Tab Name is the label that appears on each of the tabs.', 'wp-travel-engine' ); ?></div>
				</div>
				<div class="tabs-name">
					<label for="wp_travel_engine_settings[trip_tabs][icon][{{index}}]"><?php _e('Tab Icon:','wp-travel-engine'); ?></label>
					<input type="text" class="trip-tabs-icon" name="wp_travel_engine_settings[trip_tabs][icon][{{index}}]" id="wp_travel_engine_settings[trip_tabs][icon][{{index}}]">
					<div class="settings-note"><?php _e( 'Choose icon for the tab. Default icon will be shown if no icon is selected.', 'wp-travel-engine' ); ?></div>
				</div>
			</div>	
		</li>
	</div>
	<style type="text/css">
		#trip-template{
			display: none;
		}
	</style>
<?php 
	}

	function hide_publishing_actions(){
        $my_post_type = 'customer';
        global $post;
        if($post->post_type == $my_post_type){
            echo '
                <style type="text/css">
                    #minor-publishing{
                        display:none;
                    }
                </style>
            ';
        }

        $my_post_type = 'booking';
        if($post->post_type == $my_post_type){
            echo '
                <style type="text/css">
                    #minor-publishing{
                        display:none;
                    }
                </style>
            ';
        } 

        $my_post_type = 'enquiry';
        if($post->post_type == $my_post_type){
            echo '
                <style type="text/css">
                    #postbox-container-1{
                        display:none;
                    }
                </style>
            ';
        } 

        $my_post_type = 'customer';
        if($post->post_type == $my_post_type){
            echo '
                <style type="text/css">
                    #postbox-container-1{
                        display:none;
                    }
                </style>
            ';
        } 
	}

	/**
     * List out font awesome icon list
    */
    function wp_travel_engine_get_icon_list(){
	    require_once WP_TRAVEL_ENGINE_BASE_PATH . '/includes/assets/fontawesome.php';
        echo '<div class="wp-travel-engine-font-awesome-list-template">';
        echo '<div class="wp-travel-engine-font-awesome-list"><ul class="rara-font-group">';
        if ( isset($fontawesome) ):
        foreach( $fontawesome as $font ){
            echo '<li><i class="fa ' . esc_attr( $font ) . '"></i></li>';
        }
        endif;
        echo '</ul></div></div>';
        echo '<style>.wp-travel-engine-font-awesome-list{display:none;}</style>';	 
    }

    /**
     * Trip facts template.
    */
    function trip_facts_template()
	{ ?>
		<div id="trip_facts_outer_template"> 
			<div id="trip_facts_inner_template">	
				<li id="trip_facts_template-{{tripfactsindex}}" data-id="{{tripfactsindex}}" class="trip_facts">
				<span class="handle"></span>
					<div class="form-builder">
						<div class="fid">
							<label for="wp_travel_engine_settings[trip_facts][fid][{{tripfactsindex}}]"></label> 
							<input type="hidden" name="wp_travel_engine_settings[trip_facts][fid][{{tripfactsindex}}]" value="{{index}}">
						</div>
						<div class="field-id">
							<label for="wp_travel_engine_settings[trip_facts][field_id][{{tripfactsindex}}]"><?php _e('Field Name:','wp-travel-engine');?><span class="required">*</span></label> 
							<input type="text" name="wp_travel_engine_settings[trip_facts][field_id][{{tripfactsindex}}]" required>
							<div class="settings-note"><?php _e( 'Field ID is the unique id of the input field.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="field-icon">
							<label for="wp_travel_engine_settings[trip_facts][field_icon][{{tripfactsindex}}]"><?php _e('Field Icon:', 'wp-travel-engine');?></label> 
							<input class="trip-tabs-icon" type="text" name="wp_travel_engine_settings[trip_facts][field_icon][{{tripfactsindex}}]" value="">
							<div class="settings-note"><?php _e( 'Choose icon for the tab. Leave blank if no icon is required.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="field-type">
							<label for="wp_travel_engine_settings[trip_facts][field_type][{{tripfactsindex}}]"><?php _e('Field Type:','wp-travel-engine');?><span class="required">*</span></label>
							<select id="wp_travel_engine_settings[trip_facts][field_type][{{tripfactsindex}}]" name="wp_travel_engine_settings[trip_facts][field_type][{{tripfactsindex}}]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" required>
									<option value=" "><?php _e( 'Choose input type&hellip;', 'wp-travel-engine' ); ?></option>
								<?php
									$obj = new Wp_Travel_Engine_Functions();
									$fields = $obj->trip_facts_field_options();
									foreach ( $fields as $key => $val ) {
										echo '<option value="' .( !empty($val)?esc_attr( $val ):"text")  . '"' . selected( ' ', $val, false ) . '>' . esc_html( $val ) . '</option>';
									}
								?>
							</select>
							<div class="settings-note"><?php _e( 'Field type is the input types.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="select-options">
							<label for="wp_travel_engine_settings[trip_facts][select_options][{{tripfactsindex}}]"><?php _e('Select Options: ','wp-travel-engine');?><span class="required">*</span></label><textarea id="wp_travel_engine_settings[trip_facts][select_options][{{tripfactsindex}}]" name="wp_travel_engine_settings[trip_facts][select_options][{{tripfactsindex}}]" placeholder="<?php _e('Enter drop-down values separated by commas','wp-travel-engine');?>"  rows="2" cols="25" required></textarea>
						</div>
						<div class="input-placeholder">
						<label for="wp_travel_engine_settings[trip_facts][input_placeholder][{{tripfactsindex}}]"><?php _e('Field Placeholder:','wp-travel-engine');?></label> 
							<input type="text" name="wp_travel_engine_settings[trip_facts][input_placeholder][{{tripfactsindex}}]" value="">
							<div class="settings-note"><?php _e( 'Placeholder for the input field.', 'wp-travel-engine' ); ?></div>
						</div>
					</div>
					<a href="#" class="del-li">X</a>
				</li>
			</div>	
		</div>
		<style>
		#trip_facts_outer_template{
			display: none !important;
		}
		</style>
	<?php
	}

	/**
     * Trip facts ajax callback.
    */
	function wp_add_trip_info()
	{ 
		$wp_travel_engine_option_settings = get_option( 'wp_travel_engine_settings', true );
		$trip_facts = $wp_travel_engine_option_settings['trip_facts'];
		$id = $_POST['val'];
		$key = array_search( $_POST['val'], $trip_facts['field_id'] ); ;
		$value = $trip_facts['field_type'][$key];
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'trip-info-nonce' ) ) {
	    	die( 'Security check' ); 
		} else {
			$response = '<li class="trip_facts">'; $icon = isset($wp_travel_engine_option_settings['trip_facts']['field_icon'][$key]) ? esc_attr( $wp_travel_engine_option_settings['trip_facts']['field_icon'][$key] ):'';
            $response .= '<i class="'.$icon.'"></i>';
            $response .= '<a href="#" class="del-li">X</a>';
            $response .= '<span class="handle"></span>';

			switch ($value) {
				case 'select': 
					$options = $trip_facts['select_options'][$key];
					$options = explode( ',', $options );
					$response .= '<label for="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']">'.__($id.': ','wp-travel-engine').'</label>';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id]['.$key.']" value="'.$id.'">';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type]['.$key.']" value="'.$value.'">';
					$response .= '<select id="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" name="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" data-placeholder="'.__( 'Choose a field type&hellip;', 'wp-travel-engine' ).'">';
							$response .= '<option value=" ">'.__( 'Choose input type&hellip;', 'wp-travel-engine' ).'</option>';
							foreach ( $options as $key => $val ) {
								$response .= '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '">' . esc_html( $val ) . '</option>';
							}
					$response .='</select>';		
					break;
				case 'duration':
					$response .= '<label for="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']">'.__($id.': ','wp-travel-engine').'</label>';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id]['.$key.']" value="'.$id.'">';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type]['.$key.']" value="'.$value.'">';
					$response .= '<input type="number" min="1" placeholder = "'.__('Number of days','wp-travel-engine').'" class="duration" id="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" name="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" value=""/>';
				
				break;
				case 'number':
					$placeholder = isset( $trip_facts['input_placeholder'][$key]) ? esc_attr( $trip_facts['input_placeholder'][$key] ): '';
					$response .= '<label for="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']">'.__($id.': ','wp-travel-engine').'</label>';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id]['.$key.']" value="'.$id.'">'; 
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type]['.$key.']" value="'.$value.'">';
					$response .= '<input  type="number" min="1" id="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" name="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" value="">';
					break;

				case 'text':
					$placeholder = isset( $trip_facts['input_placeholder'][$key]) ? esc_attr( $trip_facts['input_placeholder'][$key] ): '';
					$response .= '<label for="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']">'.__($id.': ','wp-travel-engine').'</label>';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id]['.$key.']" value="'.$id.'">';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type]['.$key.']" value="'.$value.'">';
					$response .= '<input type="text" id="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" name="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" value="" placeholder="'.esc_attr($placeholder).'">';
					break;
				
				case 'textarea':
					$placeholder = isset( $trip_facts['input_placeholder'][$key]) ? esc_attr( $trip_facts['input_placeholder'][$key] ): '';
					$response .= '<label for="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']">'.__($id.': ','wp-travel-engine').'</label>';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id]['.$key.']" value="'.$id.'">';
					$response .= '<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type]['.$key.']" value="'.$value.'">';
					$response .= '<textarea id="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" name="wp_travel_engine_setting[trip_facts]['.$key.']['.$key.']" placeholder="'.$placeholder.'"></textarea>';

					break;
			}
			$response .='</li>';
			echo $response;
			die;
		}
	}

	/**
     * Destination template.
    */
    function wpte_get_destination_template( $template ) {
	    $post = get_post();
	    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
	    if( $page_template == 'templates/template-destination.php' ){
	        return WP_TRAVEL_ENGINE_BASE_PATH . '/includes/templates/template-destination.php';
	    }
	    if( $page_template == 'templates/template-activities.php' ){
	        return WP_TRAVEL_ENGINE_BASE_PATH . '/includes/templates/template-activities.php';
	    }
	    if( $page_template == 'templates/template-trip_types.php' ){
	        return WP_TRAVEL_ENGINE_BASE_PATH . '/includes/templates/template-trip_types.php';
	    }
	    if( $page_template == 'templates/template-trip-listing.php' ){
	        return WP_TRAVEL_ENGINE_BASE_PATH . '/includes/templates/template-trip-listing.php';
	    }
	    return $template;
	}

	/**
     * Destination template returned.
    */
	function wpte_filter_admin_page_templates( $templates ) {
	    $templates['templates/template-destination.php'] = __( 'Destination Template','wp-travel-engine' );
	    $templates['templates/template-activities.php'] = __( 'Activities Template','wp-travel-engine' );
	    $templates['templates/template-trip_types.php'] = __( 'Trip Types Template','wp-travel-engine' );
	    $templates['templates/template-trip-listing.php'] = __( 'Trip Listing Template','wp-travel-engine' );
	    return $templates;
	}

	/**
     * Destination template added.
    */
	function wpte_add_destination_templates() {
	    if( is_admin() ) {
	        add_filter( 'theme_page_templates', array($this, 'wpte_filter_admin_page_templates' ) );
	    }
	    else {
	        add_filter( 'page_template', array( $this, 'wpte_get_destination_template' ) );
	    }
	}

	/*
	* Itinerary template
	*/
	function wpte_add_itinerary_template() { 
		$screen = get_current_screen(); 
    	if( $screen->post_type=='trip' )
    	{?>
		<div id="itinerary-template">
			<li id="itinerary-tabs{{index}}" data-id="{{index}}" class="itinerary-row">
				<span class="tabs-handle"></span>
				<i class="dashicons dashicons-no-alt delete-faq delete-icon" data-id="{{index}}"></i>    
		        <a class="accordion-tabs-toggle" href="javascript:void(0);"><span class="dashicons dashicons-arrow-down custom-toggle-tabs"></span><span class="day-count"><?php _e('Day','wp-travel-engine');echo '-{{index}}';?></span></a>
		        <div class="itinerary-content">
					<div class="title">
						<label for="wp_travel_engine_setting[itinerary][itinerary_title][{{index}}]"><?php _e('Itinerary Title:','wp-travel-engine'); ?></label>
						<input type="text" class="itinerary-title" name="wp_travel_engine_setting[itinerary][itinerary_title][{{index}}]" id="wp_travel_engine_setting[itinerary][itinerary_title][{{index}}]">
					</div>
					<div class="content">
						<label for="wp_travel_engine_setting[itinerary][itinerary_content][{{index}}]"><?php _e('Itinerary Content:','wp-travel-engine'); ?></label>
						<textarea rows="5" cols="32" class="itinerary-content" name="wp_travel_engine_setting[itinerary][itinerary_content][{{index}}]" id="wp_travel_engine_setting[itinerary][itinerary_content][{{index}}]"></textarea>
						<textarea rows="5" cols="32" class="itinerary-content-inner" name="wp_travel_engine_setting[itinerary][itinerary_content_inner][{{index}}]" id="wp_travel_engine_setting[itinerary][itinerary_content_inner][{{index}}]"></textarea>
					</div>
				</div>	
			</li>
		</div>
		<style type="text/css">
			#itinerary-template{
				display: none !important;
			}
		</style>
	<?php
		}
	}

	/*
	* Itinerary template
	*/
	function wpte_add_faq_template() { 
		$screen = get_current_screen(); 
    	if( $screen->post_type=='trip' )
    	{?>
		<div id="faq-template">
			<li id="faq-tabs{{index}}" data-id="{{index}}" class="faq-row">
				<span class="tabs-handle"></span>
				<i class="dashicons dashicons-no-alt delete-faq delete-icon" data-id="{{index}}"></i>    
		        <a class="accordion-tabs-toggle" href="javascript:void(0);"><span class="dashicons dashicons-arrow-down custom-toggle-tabs"></span><span class="day-count"><?php _e('FAQ','wp-travel-engine');echo '-{{index}}';?></span></a>
		        <div class="faq-content">
					<div class="title">
						<label for="wp_travel_engine_setting[faq][faq_title][{{index}}]"><?php _e('Question:','wp-travel-engine'); ?></label>
						<input type="text" class="faq-title" name="wp_travel_engine_setting[faq][faq_title][{{index}}]" id="wp_travel_engine_setting[faq][faq_title][{{index}}]">
					</div>
					<div class="content">
						<label for="wp_travel_engine_setting[faq][faq_content][{{index}}]"><?php _e('Answer:','wp-travel-engine'); ?></label>
						<textarea rows="3" cols="78" name="wp_travel_engine_setting[faq][faq_content][{{index}}]" id="wp_travel_engine_setting[faq][faq_content][{{index}}]"></textarea>
					</div>
				</div>	
			</li>
		</div>
		<style type="text/css">
			#faq-template{
				display: none !important;
			}
		</style>
	<?php
		}
	}

	/**
    * Paypal activation notice.
    * @since 1.1.1
    */
	function wte_paypal_gateway_notice() {
	    global $current_user;
      	$user_id = $current_user->ID;
      	if (get_user_meta($user_id, 'wte-paypal-admin-notice',true)!='true') {
			$link = '<a href="https://www.paypal.com/myaccount/settings/" target="_blank">PayPal</a>';
			$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
			$message = sprintf( esc_html__( 'Please put your valid %1$s Merchant account ID in %2$s: Trips > Settings > Payment > PayPal ID %3$s. This is the ID where all the payments will be accepted.', 'wp-travel-engine' ),  $link, '<strong>', '</strong>' );
			printf( '<div class="updated notice"><p>%1$s <a href="?wte-paypal-admin-notice=1">Dismiss</a></p></div>', wp_kses_post( $message ) );  
		}
	}

	function wte_paypal_gateway_notice_ignore() {
    
      global $current_user;
      
      $user_id = $current_user->ID;
      if (isset($_GET['wte-paypal-admin-notice']) && $_GET['wte-paypal-admin-notice']='1') {
        add_user_meta($user_id, 'wte-paypal-admin-notice', 'true', true);
      }
    }

   /**
    * Paypal activation notice.
    * @since 1.1.1
    */
	function wp_travel_engine_rating_notice() {
	    global $current_user;
      	$user_id = $current_user->ID;
      	if (get_user_meta($user_id, 'wp-travel-engine-rating-notice',true)!='true') {
      		$link_plugin = '<a href="https://wordpress.org/plugins/wp-travel-engine/" target="_blank">WP Travel Engine</a>';
      		$link_rating = '<a href="https://wordpress.org/support/plugin/wp-travel-engine/reviews/#new-post" target="_blank">WordPress.org</a>';
			$message = sprintf( esc_html__( 'Thank you for using %1$s. Please rate us on %2$s.', 'wp-travel-engine' ), $link_plugin, $link_rating );
			printf( '<div class="updated notice"><p>%1$s <a href="?wp-travel-engine-rating-notice=1">Dismiss</a></p></div>', wp_kses_post( $message ) );  
		}
	}

	function wp_travel_engine_notice_ignore() {
    
      global $current_user;
      
      $user_id = $current_user->ID;
      if (isset($_GET['wp-travel-engine-rating-notice']) && $_GET['wp-travel-engine-rating-notice']='1') {
        add_user_meta($user_id, 'wp-travel-engine-rating-notice', 'true', true);
      }
    }


   /**
    * Paypal activation notice.
    * @since 1.1.1
    */
	function wp_travel_engine_activate_notice() {
	    global $current_user;
      	$user_id = $current_user->ID;
      	if (get_user_meta($user_id, 'wp-travel-engine-update-notice',true)!='true') {
      			$message = sprintf( esc_html__( 'WP Travel Engine is %1$s GDPR %2$scompatible now. Please go to %3$s Settings > Privacy %4$s to select Privacy Policy page.', 'wp-travel-engine' ),'<b>', '</b>', '<b>', '</b>' );
			printf( '<div class="updated notice"><p>%1$s <a href="?wp-travel-engine-update-notice=1">Dismiss</a></p></div>', wp_kses_post( $message ) );  
		}
	}

	function wp_travel_engine_activate_notice_ignore() {
      global $current_user;
      $user_id = $current_user->ID;
      if (isset($_GET['wp-travel-engine-update-notice']) && $_GET['wp-travel-engine-update-notice']='1') {
        add_user_meta($user_id, 'wp-travel-engine-update-notice', 'true', true);
      }
    }

	/**
    * Paypal settings form.
    * @since 1.1.1
    */
	function wte_paypal_form()
	{ 
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
		?>
			<div class="wte-paypal-gateway-form">
				<label for="wp_travel_engine_settings[paypal_id]"><?php _e('PayPal ID : ','wp-travel-engine');?> <span class="tooltip" title="Enter a valid Merchant account ID (strongly recommend) or PayPal account email address. All payments will go to this account."><i class="fas fa-question-circle"></i></span></label> 
				<input type="text" id="wp_travel_engine_settings[paypal_id]" name="wp_travel_engine_settings[paypal_id]" value="<?php echo isset($wp_travel_engine_settings['paypal_id']) ? esc_attr( $wp_travel_engine_settings['paypal_id'] ): '';?>">
			</div>
	<?php
	}

  /**
    * Payment Details.
    * @since 1.1.1
    */
    function wpte_trip_pay_add_meta_boxes(){
        $screens = array( 'booking' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'pay_id',
                __( 'Paypal Payment Details', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_pay_metabox_callback'),
                $screen,
                'side',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_pay_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/pay.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_trip_pay_meta_box_data( $post_id ) {
        
        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */
        // Sanitize user input.
        if(isset($_POST['wp_travel_engine_booking_setting']))
        {
            $settings = $_POST['wp_travel_engine_booking_setting'];
            update_post_meta( $post_id, 'wp_travel_engine_booking_setting', $settings );
        }  
    }

   /**
	* Registers extensions page for Trip.
	*
	* @since 1.1.7
	*/
	public function wp_travel_engine_extensions_page() {
		add_submenu_page('edit.php?post_type=trip', 'Extensions for WP Travel Engine.', 'Extensions', 'manage_options', 'extensions', array($this,'wp_travel_engine_extensions_callback_function'));
	}

   /**
	* 
	* Displays themes.
	*
	* @since 1.1.7
	*/
	function wp_travel_engine_extensions_callback_function() { 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/backend/submenu/extensions.php'; 
	}


  /**
	* Registers themes page for Trip.
	*
	* @since 1.1.7
	*/
	public function wp_travel_engine_themes_page() {
		add_submenu_page('edit.php?post_type=trip', 'Themes for WP Travel Engine.', 'Themes', 'manage_options', 'themes', array($this,'wp_travel_engine_themes_callback_function'));
	}

   /**
	* 
	* Displays extensions.
	*
	* @since 1.1.7
	*/
	function wp_travel_engine_themes_callback_function() { 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/backend/submenu/themes.php'; 
	}

	function wte_tinymce_config( $init ) {
	   // Don't remove line breaks
	   $init['remove_linebreaks'] = false; 
	   // Convert newline characters to BR tags
	   $init['convert_newlines_to_brs'] = true; 
	   // Do not remove redundant BR tags
	   $init['remove_redundant_brs'] = false;

	   // Pass $init back to WordPress
	   return $init;
	}
} 

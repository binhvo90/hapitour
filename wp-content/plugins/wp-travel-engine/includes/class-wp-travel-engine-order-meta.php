<?php 
/**
 * Place order form metas.
 *
 * Responsible for creating metaboxes for order.
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Order_Meta
{
    function init()
    {
        add_action( 'add_meta_boxes', array( $this, 'wpte_booking_details_add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'wp_travel_engine_booking_details_save_meta_box_data' ) );
        add_action( 'add_meta_boxes', array( $this, 'wpte_booking_add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'wp_travel_engine_booking_save_meta_box_data' ) );
        add_action( 'add_meta_boxes', array( $this, 'wpte_trip_add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'wp_travel_engine_trip_save_meta_box_data' ) );
        add_action( 'add_meta_boxes', array( $this, 'wpte_customer_add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'wp_travel_engine_customer_save_meta_box_data' ) );
        add_action( 'add_meta_boxes', array( $this, 'wpte_customer_history_add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'wp_travel_engine_customer_history_save_meta_box_data' ) );
    }

    /**
    * Place order form metabox.
    * @since 1.0.0
    */
    function wpte_booking_add_meta_boxes(){
        $screens = array( 'booking' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'booking_id',
                __( 'Customer Details', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_booking_metabox_callback'),
                $screen,
                'normal',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_booking_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/booking.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_booking_save_meta_box_data( $post_id ) {
        
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
    * Place order form metabox.
    * @since 1.0.0
    */
    function wpte_booking_details_add_meta_boxes(){
        $screens = array( 'booking' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'booking_details_id',
                __( 'Booking Address', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_booking_details_metabox_callback'),
                $screen,
                'normal',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_booking_details_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/booking-details.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_booking_details_save_meta_box_data( $post_id ) {
        
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
    * Place order form metabox.
    * @since 1.0.0
    */
    function wpte_trip_add_meta_boxes(){
        $screens = array( 'booking' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'trip_id',
                __( 'Trip Info', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_trip_metabox_callback'),
                $screen,
                'side',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_trip_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/trip.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_trip_save_meta_box_data( $post_id ) {
        
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
    * Place order form metabox.
    * @since 1.0.0
    */
    function wpte_customer_add_meta_boxes(){
        $screens = array( 'customer' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'customer_id',
                __( 'Customer Details', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_customer_metabox_callback'),
                $screen,
                'normal',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_customer_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/customer.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_customer_save_meta_box_data( $post_id ) {
        
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
    * Customer History Metabox
    * @since 1.0.0
    */
    function wpte_customer_history_add_meta_boxes(){
        $screens = array( 'customer' );
        foreach ( $screens as $screen ) {
            add_meta_box(
                'customer_history_id',
                __( 'Customer History', 'wp-travel-engine' ),
                array($this,'wp_travel_engine_customer_history_metabox_callback'),
                $screen,
                'normal',
                'high'
            );
        }
    }

    // Tab for notice listing and settings
    public function wp_travel_engine_customer_history_metabox_callback(){
        include WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/booking/customer-history.php';
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wp_travel_engine_customer_history_save_meta_box_data( $post_id ) {
        
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
}
$obj = new Wp_Travel_Engine_Order_Meta();
$obj->init();
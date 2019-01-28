<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * The template for meta tags of the single trip.
 *
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/frontend/trip-meta
 * @author     WP Travel Engine <https://wptravelengine.com/>
 */
class Wp_Travel_Engine_Meta_Tags { 

    function __construct()
    {
        add_action( 'wp_travel_engine_trip_content_wrapper', array ( $this, 'wp_travel_engine_trip_content_wrapper' ) );
        add_action( 'wp_travel_engine_trip_main_content', array ( $this, 'wp_travel_engine_trip_content' ) );
        add_action( 'wp_travel_engine_trip_content_inner_wrapper_close', array ( $this, 'wp_travel_engine_trip_content_inner_wrapper_close' ) );
        add_action( 'wp_travel_engine_trip_secondary_wrap', array ( $this, 'wp_travel_engine_trip_secondary_wrap' ) );
        add_action( 'wp_travel_engine_trip_secondary_wrap_close', array ( $this, 'wp_travel_engine_trip_secondary_wrap_close' ) );
        add_action( 'wp_travel_engine_trip_price', array ( $this, 'wp_travel_engine_trip_price' ) );
        add_action( 'wp_travel_engine_trip_facts', array ( $this, 'wp_travel_engine_trip_facts' ) ); 
        add_action( 'wp_travel_engine_trip_category', array ( $this, 'wp_travel_engine_trip_category' ) ); 
        add_action( 'wp_travel_engine_primary_wrap_close', array ( $this, 'wp_travel_engine_primary_wrap_close' ) ); 
        add_action( 'wp_travel_engine_trip_facts_content', array( $this, 'wte_trip_facts_front_end' ) );
    }
    
    /**
     * Main wrap of the single trip.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_content_wrapper()
    { ?>
    <div id="wte-crumbs">
        <?php
        do_action('wp_travel_engine_breadcrumb_holder');
        ?>
    </div>
    <div id="wp-travel-trip-wrapper" class="trip-content-area" itemscope itemtype="http://schema.org/TravelAgency">
        <div class="row">
        <div id="primary" class="content-area">

    <?php } 

    /**
     * Trip content inner wrap close.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_content_inner_wrapper_close()
    { 
        global $post;
        $wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );
        
        if( !isset( $wp_travel_engine_settings['enquiry'] ) )
        {
            do_action ( 'wp_travel_engine_enquiry_form' );
        }
      ?>  
        </div>

    <?php
    } 
    
    /**
     * Main content of the single trip.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_content()
    { 

        require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/trip-meta/trip-meta-parts/trip-tabs.php';      
    } 

    /**
     * Secondary wrip open.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_secondary_wrap()
    { 
        
        do_action('wp_travel_engine_before_secondary');
        ?>
        <div id="secondary" class="widget-area"> 
    <?php
    }        
    
    /**
     * Secondary wrap close.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_secondary_wrap_close()
    { ?>
            </div>
    <?php
    }


    /**
     * Secondary content such as pricing for single trip.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_price()
    { 
        do_action('wp_travel_engine_before_trip_price');
        require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/trip-meta/trip-meta-parts/trip-price.php'; 
        do_action('wp_travel_engine_after_trip_price');
    }

    /**
     * Load trip facts frontend.
     *
     * @since 1.0.0
     */
    function wte_trip_facts_front_end()
    {
        require_once WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/trip-meta/trip-meta-parts/trip-facts.php';
    }

    /**
     * Secondary content such as trip facts for single trip.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_trip_facts()
    {
        do_action('wp_travel_engine_before_trip_facts');
        do_action('wp_travel_engine_trip_facts_content');
        do_action('wp_travel_engine_after_trip_facts');
    } 

    /**
     * Primary wrap close.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_primary_wrap_close()
    { ?>   
        </div>
            </div>
    <?php 
    do_action ( 'wp_travel_engine_before_related_posts' );
    do_action ( 'wp_travel_engine_related_posts' );
    do_action ( 'wp_travel_engine_after_related_posts' );
    ?>
    </div>
    <?php
    }
}
new Wp_Travel_Engine_Meta_Tags();
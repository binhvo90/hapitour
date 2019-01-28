<?php
   /**
    * The template for displaying all single trips
    *
    * @package Wp_Travel_Engine
    * @subpackage Wp_Travel_Engine/includes
    * @since 1.0.0
    */
   
    get_header(); ?>
                
    <?php
    /**
     * wp_travel_engine_trip_content_wrapper hook.
     *
     * @hooked wp_travel_engine_trip_content_wrapper - 10 (main wrapper)
     */ 
    do_action( 'wp_travel_engine_trip_content_wrapper' );
    ?>

    <?php
    /**
     * wp_travel_engine_before_trip_content hook.
     *
     * @hooked wp_travel_engine_before_trip_content - 10 (left for customization and will appear before content)
     */ 
    do_action( 'wp_travel_engine_before_trip_content' );
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_main_content hook.
     *
     * @hooked wp_travel_engine_trip_main_content - 10 (shows trip tabs)
     */ 
    do_action( 'wp_travel_engine_trip_main_content' );
    ?>

    <?php
    /**
     * wp_travel_engine_trip_content_inner_wrapper_close hook.
     *
     * @hooked wp_travel_engine_trip_content_inner_wrapper_close - 10 (trip inner wrapper close)
     */ 
    do_action( 'wp_travel_engine_trip_content_inner_wrapper_close' );
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_secondary_wrap hook.
     *
     * @hooked wp_travel_engine_trip_secondary_wrap - 10 (secondary wrapper open)
     */ 
    do_action( 'wp_travel_engine_trip_secondary_wrap' );
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_before_secondary_content hook.
     *
     * @hooked wp_travel_engine_trip_before_secondary_content - 10 (shows secondary elements of the trip such as price, facts)
     */
    do_action( 'wp_travel_engine_trip_before_secondary_content' ); 
    ?>
    
    
    <?php
    /**
     * wp_travel_engine_trip_price hook.
     *
     * @hooked wp_travel_engine_trip_price - 10 (shows trip price)
     */
    do_action( 'wp_travel_engine_trip_price' ); 
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_facts hook.
     *
     * @hooked wp_travel_engine_trip_facts - 10 (shows trip facts)
     */
    do_action( 'wp_travel_engine_trip_facts' ); 
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_gallery hook.
     *
     * @hooked wp_travel_engine_trip_gallery - 10 (shows trip gallery)
     */
    do_action( 'wp_travel_engine_trip_gallery' ); 
    ?>
    
    <?php
    /**
     * wp_travel_engine_trip_map hook.
     *
     * @hooked wp_travel_engine_trip_map - 10 (shows trip map)
     */
    do_action( 'wp_travel_engine_trip_map' ); 
    ?>

    <?php
    /**
     * wp_travel_engine_wte_sidebar.
     *
     * @hooked wp_travel_engine_wte_sidebar - 10 (shows trip map)
     */
    do_action( 'wp_travel_engine_wte_sidebar' ); 
    ?>
   
    <?php
    /**
     * wp_travel_engine_trip_after_secondary_content hook.
     *
     * @hooked wp_travel_engine_trip_after_secondary_content - 10 (left for customization and is hooked after the secondary content)
     */
    do_action( 'wp_travel_engine_trip_after_secondary_content' ); 
    ?>
    
    <?php 
    /**
     * wp_travel_engine_after_trip_content hook.
     *
     * @hooked wp_travel_engine_after_trip_content - 10 (left for customization and is hooked after the main trip content)
     */
    do_action( 'wp_travel_engine_after_trip_content' ); ?>
    
    <?php
    /**
     * wp_travel_engine_trip_before_secondary_content hook.
     *
     * @hooked wp_travel_engine_trip_before_secondary_content - 10 (shows secondary elements of the trip such as price, facts)
     */
    do_action( 'wte_advanced_search_form' ); 
    ?>
    
    <?php 
    /**
     * wp_travel_engine_after_trip_content hook.
     *
     * @hooked wp_travel_engine_after_trip_content - 10 (left for customization and is hooked after the main trip content)
     */
    do_action( 'wp_travel_engine_primary_wrap_close' ); ?>
    <?php get_footer();
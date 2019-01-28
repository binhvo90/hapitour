<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * The template loader of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Travel_Triping
 * @subpackage Travel_Triping/admin
 * @author     WP Travel Engine <https://wptravelengine.com/>
 */
class Wp_Travel_Engine_Templates {

	/**
	 * Hook in methods.
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'include_template_function' ) );
	}

	/**
	 * Template over-ride for single trip.
	 *
	 * @since    1.0.0
	 */
	function include_template_function( $template_path ) {
	    if ( get_post_type() == 'trip' ) {
	        if ( is_single() ) {
	            if ( $theme_file = locate_template( array ( 'single-trip.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/single-trip.php';
	            }
	        }
	        if( is_archive() ) {

	        	if ( $theme_file = locate_template( array ( 'archive-trip.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/archive-trip.php';
	            }
	        }
	        if( is_tax( 'trip_types' ) ){
	        	if ( $theme_file = locate_template( array ( 'taxonomy-trip_types.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/taxonomy-trip_types.php';
	            }
	        }
	        if( is_tax( 'destination' ) ){
				if ( $theme_file = locate_template( array ( 'taxonomy-destination.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/taxonomy-destination.php';
	            }
	        }
	        if( is_tax( 'activities' ) ){
				if ( $theme_file = locate_template( array ( 'taxonomy-activities.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/taxonomy-activities.php';
	            }
	        }
	    }
	    return $template_path;
	}
}

new Wp_Travel_Engine_Templates();

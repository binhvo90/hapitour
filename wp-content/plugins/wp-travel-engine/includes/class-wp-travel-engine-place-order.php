<?php
/**
 * Place order form.
 *
 * Responsible for creating shortcodes for place order form and mainatain it.
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Place_Order
{
	
	/**
	* Initialize the place order form shortcode.
	* @since 1.0.0
	*/
	function init()
	{
    	add_shortcode( 'WP_TRAVEL_ENGINE_PLACE_ORDER', array( $this, 'wp_travel_engine_place_order_shortcodes_callback' ) ); 
    	add_action( 'init', array( $this, 'place_order_form_validate') );
	}

	/**
	* Place order form shortcode callback function.
	* @since 1.0
	*/
	function wp_travel_engine_place_order_shortcodes_callback()
	{ 
		global $post;

		if( !isset($_GET['nonce']) && ! isset( $_POST['nonce'] ) )
		{
			if ( ! isset( $_POST['nonce'] ) || $_POST['nonce']=='' || ! wp_verify_nonce( $_POST['nonce'],'wp_travel_engine_booking_nonce') ) {

	          _e('Sorry, you may not have selected the number of travelers for the trip. Please select number of travelers and confirm your booking. Thank you.','wp-travel-engine');
	           return;
	        }
	    }
        else{
        	if ( locate_template( 'order-form-template.php' ) ) {
	            get_template_part('order-form','template');
            } else {
                $template_path = WP_TRAVEL_ENGINE_TEMPLATE_PATH . '/order-form-template.php';
            	include $template_path;
            }
        }
		
	}

	/**
	* Place order form validation function.
	* @since 1.0.0
	*/
	function place_order_form_validate()
	{

		// 
	}
}
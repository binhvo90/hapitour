<?php

/**
 * Fired during plugin activation
 *
 * 
 * @since      1.0.0
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 */
class Wp_Travel_Engine_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if ( is_plugin_active( 'wte-paypal-gateway/wte-paypal-gateway.php' ) ) {
		  	deactivate_plugins( 'wte-paypal-gateway/wte-paypal-gateway.php' );
		} 

		$template_pages = array(
			'trip_types'	=> array(
				'title' 	=> 'Trip Types',
				'template' 	=> 'templates/template-trip_types.php'
				),
			'destination' 	=> array(
				'title' 	=> 'Destination',
				'template' 	=> 'templates/template-destination.php'
				),
			'activities'	=> array(
				'title' 	=> 'Activities',
				'template' 	=> 'templates/template-activities.php'
				),
		);
		foreach ($template_pages as $key => $value) {
			$existing_page = get_page_by_title( $value['title'] );
			if ( ! empty( $existing_page ) && 'page' === $existing_page->post_type)  {
				$val = get_post_meta($existing_page->ID,'_wp_page_template',true);
				if( $val == $value['template'] )
				{
					break;
				}
			}
			else{
				$new_page = array(
					'post_title'    => $value['title'],
					'post_content'  => '',
					'post_status'   => 'publish',
					'post_type'     => 'page',
				);
				$postID = wp_insert_post( $new_page );
				update_post_meta( $postID, '_wp_page_template', $value['template'] );
			}
		}


		$arr = array();
		$existing_page = get_page_by_title( 'Enquiry Thankyou Page' );
		$options = get_option( 'wp_travel_engine_settings', array() );

		if ( !empty( $existing_page ) && isset( $options['trip_tabs']['field'] ) && isset( $options['trip_tabs']['field'][2] )=='itinerary' )
		{
			return;
		}
		delete_option('wp_travel_engine_settings');
		$pages = array(
			'wp_travel_engine_thank_you'	=> array(
				'title' => 'THANK YOU',
				'shortcode' => 'THANK_YOU'
				),
			'wp_travel_engine_place_order' => array(
				'title' => 'CHECKOUT',
				'shortcode' => 'PLACE_ORDER'
				),
			'wp_travel_engine_terms_and_conditions'	=> array(
				'title' => 'TERMS AND CONDITIONS',
				'shortcode' => ''
				),
			'enquiry'	=> array(
				'title' => 'Enquiry Thankyou Page',
				'shortcode' => ''
				),
			'wp_travel_engine_confirmation_page'	=> array(
				'title' => 'TRAVELERS INFORMATION',
				'shortcode' => 'BOOK_CONFIRMATION'
				),
		);
		foreach ( $pages as $key=>$value ) {
			$shortcode = 'WP_TRAVEL_ENGINE_'.$value['shortcode'];
			$title = ucfirst( $value['title'] );

		// Check if this page already exists, with shortcode
			$existing_page = get_page_by_title( $title );

			if ( ! empty( $existing_page ) && 'page' === $existing_page->post_type)  {
				$content = $existing_page->post_content;

				if($title == 'TERMS AND CONDITIONS')	
				{
					$page = get_page_by_title( 'TERMS AND CONDITIONS' );
					wp_delete_post( $page->ID, true );
				}
				elseif($title == 'Enquiry Thankyou Page')	
				{
					$page = get_page_by_title( 'Enquiry Thankyou Page' );
					wp_delete_post( $page->ID, true );
				}
				else{
					if(has_shortcode($content,$shortcode)){
						wp_delete_post( $existing_page->ID, true );
					}
				}
			}
		}
		$existing_page = get_page_by_title( 'Enquiry Thankyou Page' );

		if ( empty( $existing_page ) )
		{
			$new_page = array(
			'post_title'    => 'Enquiry Thankyou Page',
			'post_content'  => 'Thank you for the enquiry. We will soon get in touch with you.',
			'post_status'   => 'publish',
			'post_type'     => 'page',
			);
			$post_id = wp_insert_post( $new_page );
			$arr['pages']['enquiry'] = $post_id;
			$enquiry_page = array_merge_recursive( $options, $arr );
			update_option ( 'wp_travel_engine_settings', $enquiry_page );
		}
		
		global $post;
		$wte_doc_tax_post_args = array(
			'post_type' => 'trip', // Your Post type Name that You Registered
			'posts_per_page' => -1,
			'order' => 'ASC',
		);
		$wte_doc_tax_post_qry = new WP_Query($wte_doc_tax_post_args);
		$cost = 0;
    	if($wte_doc_tax_post_qry->have_posts()) :
       		while($wte_doc_tax_post_qry->have_posts()) :
        		$wte_doc_tax_post_qry->the_post(); 
				$wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
				if(isset($wp_travel_engine_setting['trip_price']))
				{
					$cost = $wp_travel_engine_setting['trip_price'];
					update_post_meta($post->ID,'wp_travel_engine_setting_trip_price',$cost);
				}
				if(isset($wp_travel_engine_setting['trip_duration']))
				{
					$duration = $wp_travel_engine_setting['trip_duration'];
					update_post_meta($post->ID,'wp_travel_engine_setting_trip_duration',$duration);
				}
			endwhile;
		endif;
		$pages = array(
			'wp_travel_engine_thank_you'	=> array(
				'title' => 'THANK YOU',
				'shortcode' => 'THANK_YOU'
				),
			'wp_travel_engine_place_order' => array(
				'title' => 'CHECKOUT',
				'shortcode' => 'PLACE_ORDER'
				),
			'wp_travel_engine_terms_and_conditions'	=> array(
				'title' => 'TERMS AND CONDITIONS',
				'shortcode' => ''
				),
			'wp_travel_engine_confirmation_page'	=> array(
				'title' => 'TRAVELERS INFORMATION',
				'shortcode' => 'BOOK_CONFIRMATION'
				),
		);
		foreach ( $pages as $key=>$value ) {
			$shortcode = 'WP_TRAVEL_ENGINE_'.$value['shortcode'];
			$title = ucfirst( $value['title'] );

		// Check if this page already exists, with shortcode
			$existing_page = get_page_by_title( $title );

			if ( ! empty( $existing_page ) && 'page' === $existing_page->post_type)  {
				$content = $existing_page->post_content;

				if(has_shortcode($content,$shortcode)){
					return false;
				}
			}
			else {
		// If the page doesn't exist, create it
				if($title == 'TERMS AND CONDITIONS')	
				{
					$options = get_option( 'wp_travel_engine_settings', array() );
					if( !isset( $options['pages'][$key] ) )
					{

						$new_page = array(
						'post_title'    => $title,
						'post_content'  => '',
						'post_status'   => 'publish',
						'post_type'     => 'page',
						);
						$post_id = wp_insert_post( $new_page );
						$arr['pages'][$key] = $post_id;
						update_option( 'wp_travel_engine_settings', $arr);
					}
				}

				elseif($title == 'THANK YOU')	
				{
					$options = get_option( 'wp_travel_engine_settings', array() );
					if( !isset( $options['pages'][$key] ) )
					{

						$new_page = array(
						'post_title'    => $title,
						'post_content'  => '[WP_TRAVEL_ENGINE_THANK_YOU]',
						'post_status'   => 'publish',
						'post_type'     => 'page',
						);
						$post_id = wp_insert_post( $new_page );
						$arr['pages'][$key] = $post_id;
						update_option( 'wp_travel_engine_settings', $arr);
					}
				}
				
				else
				{
					$options = get_option( 'wp_travel_engine_settings', array() );
					if( !isset( $options['pages'][$key] ) )
					{
						$new_page = array(
						'post_title'    => $title,
						'post_content'  => '['.$shortcode.']',
						'post_status'   => 'publish',
						'post_type'     => 'page',
						);
						$post_id = wp_insert_post( $new_page );
						$arr['pages'][$key] = $post_id;
						update_option( 'wp_travel_engine_settings', $arr );
					}
				}
			}
			// echo "pages";
			// die;
		}
		
			$default_tabs = 
			array(
				'trip_tabs'=>
				array(
				    'name' => array
				        (
				            '1' => 'Overview',
				            '2' => 'Itinerary',
				            '3' => 'Cost',
				            '4' => 'Faqs',
				        ),

				    'field' => array
				        (
				            '1' => 'wp_editor',
				            '2' => 'itinerary',
				            '3' => 'cost',
				            '4' => 'faqs',
				        ),
				    'id'	=> array
				    	(
				    		'1' => '1',
				    		'2' => '2',
				    		'3' => '3',
				    		'4' => '4',
				    	)
				),

				'trip_facts'=>
				array(
				    'field_id' => array
				        (
				            '1' => 'transportation',
				            '2' => 'group-size',
				            '3' => 'altitude'
				        ),

				    'field_type' => array
				        (
				            '1' => 'text',
				            '2' => 'text',
				            '3' => 'text'
				        ),

				    'fid' => array
				        (
				            '1' => '1',
				            '2' => '2',
				            '3' => '3'
				        ),
				    ),
				'email'=>
				array(
						'emails' => get_option( 'admin_email' ),
					)
			);
			
			$wp_travel_engine_option_settings = get_option( 'wp_travel_engine_settings', array() );

			// if( isset( $wp_travel_engine_option_settings['trip_tabs'] ) && $wp_travel_engine_option_settings['trip_tabs']!='' && is_array( $wp_travel_engine_option_settings['trip_tabs'] ) )
			// {
	            if( !isset( $wp_travel_engine_option_settings['trip_tabs'] ) && !isset( $wp_travel_engine_option_settings['trip_facts'] ) )
	            { 
						$default_tab_settings = array_merge_recursive( $wp_travel_engine_option_settings, $default_tabs );
						update_option ( 'wp_travel_engine_settings', $default_tab_settings );
				}
			// }
		}
	}

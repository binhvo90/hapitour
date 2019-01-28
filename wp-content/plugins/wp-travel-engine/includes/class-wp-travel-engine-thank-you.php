<?php
/**
 * Place order form.
 *
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Thank_You
{
  /**
	* Initialize the thank you form shortcode.
	* @since 1.0.0
	*/
	function init()
	{
    	add_shortcode( 'WP_TRAVEL_ENGINE_THANK_YOU', array( $this, 'wp_travel_engine_thank_you_shortcodes_callback' ) ); 
	}

	/**
	* Place order form shortcode callback function.
	* @since 1.0.0
	*/
	function wp_travel_engine_thank_you_shortcodes_callback()
	{ 
		if( isset( $_SESSION['fdd-id'] ) )
		{
			$did = esc_attr( $_SESSION['fdd-id'] );
			$pid = $_SESSION['trip-id'];
			$pno = $_SESSION['travelers'];
			$wp_travel_engine_departure_settings = get_post_meta( $pid, 'WTE_Fixed_Starting_Dates_setting', true );
			if( isset( $wp_travel_engine_departure_settings['departure_dates']['seats_available'][$did]) && $wp_travel_engine_departure_settings['departure_dates']['seats_available'][$did]!='' )
			{
				$new_did = $wp_travel_engine_departure_settings['departure_dates']['seats_available'][$did]-$pno;
				$wp_travel_engine_departure_settings['departure_dates']['seats_available'][$did] = $new_did;
				update_post_meta( $pid, 'WTE_Fixed_Starting_Dates_setting', $wp_travel_engine_departure_settings );
			}
		}
		
		if( isset( $_POST['wp-travel-engine-confirmation-submit'] ) && isset( $_SESSION['trip-id'] ) )
		{
			if ( ! isset( $_POST['nonce'] ) || $_POST['nonce']=='' || ! wp_verify_nonce( $_POST['nonce'],'wp_travel_engine_final_confirmation_nonce') || !isset($_SESSION['trip-id'])) {
		     		$thank_page_msg = __('Sorry, you may not have confirmed your booking. Please fill up the form and confirm your booking. Thank you.','wp-travel-engine');
		     		$thank_page_error = apply_filters('wp_travel_engine_thankyou_page_error_msg',$thank_page_msg);
		     		echo $thank_page_error;
		           	return;
		        
	        }
		    //for payfast
	        $meta_id = get_post_meta($_SESSION['trip-id'],$_SESSION['trip-date'].'_bid');

		    $tid = isset( $_SESSION['tid'] ) ? $_SESSION['tid']: $meta_id[0] ;
		    $post = get_post( $_SESSION['trip-id'] ); 
		    $tname =  $post->post_title;
		    $obj = new Wp_Travel_Engine_Functions;
		    $order_metas = $_POST['wp_travel_engine_placeorder_setting'];
		    update_post_meta( $tid, 'wp_travel_engine_placeorder_setting', $order_metas );

		    //for payfast
		    if(get_post_meta($_SESSION['trip-id'],$_SESSION['trip-date'].'_bid'))
		    {
			    delete_post_meta( $_SESSION['trip-id'],$_SESSION['trip-date'].'_bid',$meta_id );
		    }

			$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );
		    if ( isset( $wp_travel_engine_settings['confirmation_msg'] ) && $wp_travel_engine_settings['confirmation_msg']!='' )
		    {
			    $thankyou = $wp_travel_engine_settings['confirmation_msg'];  
		   	}
			else{
				$thankyou  = __('Thank you for booking the trip. Please check your email for confirmation.','wp-travel-engine');
			    $thankyou .= __(' Below is your booking detail:','wp-travel-engine');
			    $thankyou .= '<br>';
			}   
			    echo wp_kses_post( $thankyou );
		    ?>
		    <div class="thank-you-container">
			<h3 class="trip-details"><?php _e('Trip Details:','wp-travel-engine');?></h3>
			<table>
				<thead>
					<th><?php _e( 'Trip ID:','wp-travel-engine' ); ?></th>
					<th><?php _e( 'Trip Name:','wp-travel-engine' ); ?></th>
					<?php
					if(isset($_SESSION['due']) && $_SESSION['due']!='' ){ ?>
						<th><?php _e( 'Total Paid:','wp-travel-engine' ); ?></th>
					<?php 
					} else{
					?>
						<th><?php _e( 'Total Cost:','wp-travel-engine' ); ?></th>
					<?php }?>
					<th><?php _e( 'Remaining Payment:','wp-travel-engine' ); ?></th>
					<th><?php _e( 'Trip Start Date:','wp-travel-engine' ); ?></th>
					<th><?php _e( 'Number of Traveler(s):','wp-travel-engine' ); ?></th>
					<th><?php _e( 'Number of Child Traveler(s):','wp-travel-engine' ); ?></th>
				</thead>
				<tbody>
					
					<td>
						<?php echo esc_attr( $_SESSION['trip-id'] );?>		
					</td>
					<td>
						<?php echo esc_attr( $tname );?>
					</td>
					<td>
						<?php 
						$obj = new Wp_Travel_Engine_Functions();
						$code = 'USD';
		                if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
		                {
		                    $code = $wp_travel_engine_settings['currency_code'];
		                }
	                	$currency = $obj->wp_travel_engine_currencies_symbol( $code );
	                	$cost = str_replace( ',','',$_SESSION['trip-cost'] );
	                	echo esc_attr($currency.$obj->wp_travel_engine_price_format( $cost ).' '.$code);?>	
					</td>
					<td><?php echo isset( $_SESSION['due'] ) ? esc_attr($currency.$obj->wp_travel_engine_price_format( $_SESSION['due'] ).' '.$code):'-';?></td>
					<td>
						<?php echo esc_attr( $_SESSION['trip-date'] );?>
					</td>
					<td>
						<?php echo esc_attr( $_SESSION['travelers'] );?>
					</td>
					<td>
						<?php echo isset( $_SESSION['child-travelers'] ) ? esc_attr( $_SESSION['child-travelers'] ):'';?>
					</td>
				</tbody>
			</table>
			</div>
		<?php
			if (session_id() ) {
        		session_destroy();
     		}
		}
		else{
				if(isset($_SESSION['custom']))
				{
					$nonce = substr($_SESSION['custom'], 0, strpos($_SESSION['custom'], '!'));
				}
				if(isset($_SESSION['nonce']))
				{
					$nonce = substr($_SESSION['nonce'], 0, strpos($_SESSION['nonce'], '!'));
				}
				if(isset($_POST['nonce']))
				{
					$nonce = $_POST['nonce'];
				}
				if(isset($_POST['custom']))
				{
					$nonce = substr($_POST['custom'], 0, strpos($_POST['custom'], '!'));
				}
				if ( !isset($_SESSION['trip-id'])) 
				{
		     		$thank_page_msg = __('Sorry, you may not have confirmed your booking. Please fill up the form and confirm your booking. Thank you.','wp-travel-engine');
		     		$thank_page_error = apply_filters('wp_travel_engine_thankyou_page_error_msg',$thank_page_msg);
		     		echo $thank_page_error;
		           	return;
		        }
			    $tid = esc_attr( $_SESSION['tid'] );
			    $post = get_post( $_SESSION['trip-id'] ); 
			    $tname =  $post->post_title;
			    $obj = new Wp_Travel_Engine_Functions;
				$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );
			    if ( isset( $wp_travel_engine_settings['confirmation_msg'] ) && $wp_travel_engine_settings['confirmation_msg']!='' )
			    {
				    $thankyou = $wp_travel_engine_settings['confirmation_msg'];  
			   	}
				else{
					$thankyou  = __('Thank you for booking the trip. Please check your email for confirmation.','wp-travel-engine');
				    $thankyou .= __(' Below is your booking detail:','wp-travel-engine');
				    $thankyou .= '<br>';
				}   
				    echo  wp_kses_post( $thankyou );
			    ?>
			    <div class="thank-you-container">
				<h3 class="trip-details"><?php _e('Trip Details:','wp-travel-engine');?></h3>
				<table>
					<thead>
						<th><?php _e( 'Trip ID:','wp-travel-engine' ); ?></th>
						<th><?php _e( 'Trip Name:','wp-travel-engine' ); ?></th>
						<?php
						if(isset($_SESSION['due']) && $_SESSION['due']!='' ){ ?>
							<th><?php _e( 'Total Paid:','wp-travel-engine' ); ?></th>
						<?php 
						} else{
						?>
							<th><?php _e( 'Total Cost:','wp-travel-engine' ); ?></th>
						<?php }?>
						<th><?php _e( 'Remaining Payment','wp-travel-engine' ); ?></th>
						<th><?php _e( 'Trip Start Date:','wp-travel-engine' ); ?></th>
						<th><?php _e( 'Number of Traveler(s):','wp-travel-engine' ); ?></th>
						<th><?php _e( 'Number of Child Traveler(s):','wp-travel-engine' ); ?></th>
					</thead>
					<tbody>
						
						<td>
							<?php echo esc_attr( $_SESSION['trip-id'] );?>		
						</td>
						<td>
							<?php echo esc_attr( $tname );?>
						</td>
						<td>
							<?php 
							$obj = new Wp_Travel_Engine_Functions();
							$code = 'USD';
			                if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
			                {
			                    $code = $wp_travel_engine_settings['currency_code'];
			                }
		                	$currency = $obj->wp_travel_engine_currencies_symbol( $code );
		                	$cost = str_replace( ',','',$_SESSION['trip-cost'] );
		                	echo esc_attr($currency.$obj->wp_travel_engine_price_format( $cost ).' '.$code);?>	
						</td>
						<td><?php echo isset( $_SESSION['due'] ) ? esc_attr( $currency.$_SESSION['due'].' '.$code ):'-';?></td>
						<td>
							<?php echo esc_attr( $_SESSION['trip-date'] );?>
						</td>
						<td>
							<?php echo esc_attr( $_SESSION['travelers'] );?>
						</td>
						<td>
							<?php echo isset( $_SESSION['child-travelers'] ) ? esc_attr( $_SESSION['child-travelers'] ):'';?>
						</td>
					</tbody>
				</table>
				</div>
			<?php
				if (session_id() ) {
	        		session_destroy();
	     		}
			}
		}
	}

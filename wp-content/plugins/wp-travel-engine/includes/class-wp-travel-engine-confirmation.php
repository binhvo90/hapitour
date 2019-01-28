<?php

/**
 * Place order form for personal details.
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Order_Confirmation
{
   /**
	* Initialize the final confirmation form shortcode.
	* @since 1.0
	*/
	function init()
	{
    	add_shortcode( 'WP_TRAVEL_ENGINE_BOOK_CONFIRMATION', array( $this, 'wp_travel_engine_confirmation_shortcodes_callback' ) ); 
	}

	/**
	* Final confirmation form shortcode callback function.
	* @since 1.0
	*/
	function wp_travel_engine_confirmation_shortcodes_callback()
	{	
		if( !isset( $_SESSION['nonce'] ) || $_SESSION['nonce']=='' )
		{
			$confirm_page_msg = __('Sorry, you may not have confirmed your booking. Please fill up the form and confirm your booking. Thank you.','wp-travel-engine');
 			$confirm_page_error = apply_filters('wp_travel_engine_confirm_page_error_msg',$confirm_page_msg);
 			echo esc_attr( $confirm_page_error );
           	return;
   		}
		if (isset($_POST['wp_travel_engine_booking_setting']['place_order']['booking']['subscribe']) && $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['subscribe']=='1' )
		{
			$myvar = $_POST;
			$obj = new Wte_Mailchimp_Main;
			$new = $obj->wte_mailchimp_action($myvar);
		}
		if (isset($_POST['wp_travel_engine_booking_setting']['place_order']['booking']['mailerlite']) && $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['mailerlite']=='1' )
		{
			$myvar = $_POST;
			$obj = new Wte_Mailerlite_Main;
			$new = $obj->wte_mailerlite_action($myvar);
		}
		if (isset($_POST['wp_travel_engine_booking_setting']['place_order']['booking']['convertkit']) && $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['convertkit']=='1' )
		{
			$myvar = $_POST;
			$obj = new Wte_Convertkit_Main;
			$new = $obj->wte_convertkit_action($myvar);
		}
		$options = get_option('wp_travel_engine_settings', true);
		$wp_travel_engine_thankyou = isset($options['pages']['wp_travel_engine_thank_you']) ? esc_attr($options['pages']['wp_travel_engine_thank_you']) : '';
		?>
		<form method="post" id="wp-travel-engine-order-form" action="<?php echo esc_url( get_permalink( $wp_travel_engine_thankyou ) )?>">
			<?php
			if(!empty($_GET['paymentid']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ){
				$paymentID = $_GET['paymentid'];
            	$payerID = $_GET['payerID'];
            	$token = $_GET['token'];
            	$pid = $_GET['pid'];   
      			require WP_TRAVEL_ENGINE_PAYPAL_EXPRESS_BASE_PATH . '/paypalExpress.php';
      			$obj = new paypalExpress;
			    $order_metas = $obj->paypalCheck($paymentID, $pid, $payerID, $token);
			}

			if( isset( $_GET['paymentid'] ) && $_GET['paymentid']!='' && !isset($_GET['payerID']) )
			{
				$order_metas =
				Array
				(
				    'place_order' => Array
				        (
				            'traveler' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['traveler'],
				            'cost' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['cost'],
				            'due' 		=> isset($_SESSION['due']) ? esc_attr( $_SESSION['due'] ):'',
				            'tid' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['tid'],
				            'tname' 	=> get_the_title($_POST['wp_travel_engine_booking_setting']['place_order']['tid']),
				            'datetime' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['datetime'],
				            'booking' 	=> Array
				            (
			                    'fname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['fname'] ),
			                    'lname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['lname'] ),
			                    'email' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['email'] ),
			                    'address' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['address'] ),
			                    'city' 		=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['city'] ),
			                    'country' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['country'] ),
				            ),
				            'payment'	=> Array
				            (
								'paymentid' 	 	=> $_GET['paymentid'],
			                	'payerid' 			=> $_GET['payerid'],
								'token' 			=> $_GET['token'],
							)
				        )
				);
			}

			if( isset( $_POST['mihpayid'] ) && $_POST['mihpayid']!='' )
			{
				$order_metas =
				Array
				(
				    'place_order' => Array
				        (
				            'traveler' 	=> $_POST['udf1'],
				            'cost' 		=> $_POST['amount'],
				            'due' 		=> '',
				            'tid' 		=> $_SESSION['trip-id'],
				            'tname' 	=> get_the_title($_SESSION['trip-id']),
				            'datetime' 	=> $_SESSION['trip-date'],
				            'booking' 	=> Array
				            (
			                    'fname' 	=> $_POST['firstname'],
			                    'lname' 	=> $_POST['lastname'],
			                    'email' 	=> $_POST['email'],
			                    'address' 	=> $_POST['address1'],
			                    'city' 		=> $_POST['city'],
			                    'country' 	=> $_POST['country'],
				            ),
				            'payment'	=> Array
				            (
								'mihpayid' 	 		=> $_POST['mihpayid'],
			                	'txnid' 			=> $_POST['txnid'],
								'status' 			=> $_POST['status'],
							)
				        )
				);
			}

			if(isset($_POST['stripeTokenType']))
        	{
				do_action('stripe_payment_process',$_SESSION);
				$pno = $_POST['wp_travel_engine_booking_setting']['place_order']['traveler'];
		        $order_metas =
				Array
				(
				    'place_order' => Array
				        (
				            'traveler' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['traveler'],
				            'cost' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['cost'],
				            'due' 		=> isset($_SESSION['due']) ? esc_attr( $_SESSION['due'] ):'',
				            'tid' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['tid'],
				            'tname' 	=> get_the_title($_POST['wp_travel_engine_booking_setting']['place_order']['tid']),
				            'datetime' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['datetime'],
				            'booking' 	=> Array
				            (
			                    'fname' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['fname'],
			                    'lname' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['lname'],
			                    'email' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['email'],
			                    'address' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['address'],
			                    'city' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['city'],
			                    'country' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['country'],
			                    'survey'	=> isset($_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey']) ? esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ):'',
				            ),
				            'payment'	=> Array
				            (
			                	'stripeToken' 		=> $_POST['stripeToken'],
								'stripeTokenType' 	=> $_POST['stripeTokenType'],
								'stripeEmail' 	 	=> $_POST['stripeEmail'],
								'payment_gateway'	=> 'stripe'
							)
				        )
				);
			}
			if( isset( $_SESSION['payment'] ) && $_SESSION['payment'] == 'Authorize.net' )
        	{
				$cost = $_SESSION['trip-cost'];
				$cost = str_replace(',', '', $cost);
				$order_metas =
					Array
					(
				    'place_order' => Array
				        (
				            'traveler' 	=> $_SESSION['travelers'],
				            'cost' 		=> $cost,
				            'tid' 		=> $_SESSION['trip-id'],
				            'tname' 	=> get_the_title($_SESSION['trip-id']),
				            'datetime' 	=> esc_attr( $_SESSION['trip-date'] ),
				            'booking' 	=> Array
				            (
			                    'fname' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['fname'],
			                    'lname' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['lname'],
			                    'email' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['email'],
			                    'address' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['address'],
			                    'city' 		=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['city'],
			                    'country' 	=> $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['country'],
			                    'survey'	=> isset($_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey']) ? esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ):'',
				            ),
				            'payment'	=> Array
				            (
			                	'acode' 		=> $_SESSION['acode'],
								'atid' 			=> $_SESSION['atid'],
								'atype' 	 	=> $_SESSION['atype'],
								'amethod'		=> $_SESSION['amethod'],
								'aemail'		=> $_SESSION['aemail']
							),
		 		        )
				);
			}

			if( isset( $_POST['wp-travel-engine-submit'] ) && isset( $_POST['wte_payment_options'] ) && $_POST['wte_payment_options'] == 'Test Payment' )
			{ 
			    $post = get_post( $_SESSION['trip-id'] ); 
				$slug = $post->post_title;
			   	$order_metas =
				Array
				(
				    'place_order' => Array
				        (
				            'traveler' 	=> esc_attr( $_SESSION['travelers'] ),
				            'cost' 		=> esc_attr( $_SESSION['trip-cost'] ),
				            'due' 		=> isset( $_SESSION['due'] ) ? $_SESSION['due']:'',
				            'tid' 		=> esc_attr( $_SESSION['trip-id'] ),
				            'tname' 	=> esc_attr( $slug ),
				            'datetime' 	=> esc_attr( $_SESSION['trip-date'] ),
				            'booking' 	=> Array
				            (
			                    'fname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['fname'] ),
			                    'lname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['lname'] ),
			                    'email' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['email'] ),
			                    'address' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['address'] ),
			                    'city' 		=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['city'] ),
			                    'country' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['country'] ),
			                    'survey'	=> isset( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ) ? esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ):'',
				            ),
				        )
				);
			}

			if( isset( $_POST['wp-travel-engine-submit'] ) && !isset( $_POST['wte_payment_options'] ) )
			{ 
			    $post = get_post( $_SESSION['trip-id'] ); 
				$slug = $post->post_title;
			   	$order_metas =
				Array
				(
				    'place_order' => Array
			        (
			            'traveler' 	=> esc_attr( $_SESSION['travelers'] ),
			            'cost' 		=> esc_attr( $_SESSION['trip-cost'] ),
			            'due' 		=> isset( $_SESSION['due'] ) ? $_SESSION['due']:'',
			            'tid' 		=> esc_attr( $_SESSION['trip-id'] ),
			            'tname' 	=> esc_attr( $slug ),
			            'datetime' 	=> esc_attr( $_SESSION['trip-date'] ),
			            'booking' 	=> Array
			            (
		                    'fname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['fname'] ),
		                    'lname' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['lname'] ),
		                    'email' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['email'] ),
		                    'address' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['address'] ),
		                    'city' 		=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['city'] ),
		                    'country' 	=> esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['country'] ),
		                    'survey'	=> isset( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ) ? esc_attr( $_POST['wp_travel_engine_booking_setting']['place_order']['booking']['survey'] ):'',
			            ),
			        )
				);
			}
			if( isset( $_GET['ID'] ) )
			{
				$url = $_SERVER['REQUEST_URI'];
				$parts = parse_url($url);
				parse_str($parts['query'], $query);
				if( isset( $query['ID'] ) && $query['ID']!='' )
				{
					$raw_post_data = file_get_contents('php://input');
					$raw_post_array = explode('&', $raw_post_data);
					$myPost = array();
					foreach ($raw_post_array as $keyval) {
					 $keyval = explode ('=', $keyval);
					 if (count($keyval) == 2)
					 $myPost[$keyval[0]] = urldecode($keyval[1]);
					}

					// Read the post from PayPal system and add 'cmd'
					$req = 'cmd=_notify-validate';
					if(function_exists('get_magic_quotes_gpc')) {
					 	$get_magic_quotes_exists = true;
					}
					foreach ($myPost as $key => $value) {
					 	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
					 	$value = urlencode(stripslashes($value));
					 	} else {
					 	$value = urlencode($value);
					 	}
					 	$req .= "&$key=$value";
					}
					
					/*
					 * Post IPN data back to PayPal to validate the IPN data is genuine
					 * Without this step anyone can fake IPN data
					 */
					$paypalURL = "https://www.paypal.com/cgi-bin/webscr";
					$ch = curl_init($paypalURL);
					if ($ch == FALSE) {
					    return FALSE;
					}
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
					curl_setopt($ch, CURLOPT_SSLVERSION, 6);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
					curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
					 
					// Set TCP timeout to 30 seconds
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
					$res = curl_exec($ch);
					/*
					 * Inspect IPN validation result and act accordingly
					 * Split response headers and payload, a better way for strcmp
					 */
					$tokens = explode("\r\n\r\n", trim($res));
					$res = trim(end($tokens));
					date_default_timezone_set('Europe/Berlin');
					$date = date("Y-m-d H:i:s");
					if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {
						$dtime = $_SESSION['trip-date'] ; 
						$postvar = $_POST;   
						$order_metas =
						Array
						(
						    'place_order' => Array
					        (
					            'traveler' 	=> isset( $_SESSION['travelers'] ) ? esc_attr( $_SESSION['travelers'] ) : $_GET['id'],
					            'cost' 		=> $_POST['payment_gross'],
					            'due' 		=> isset($_SESSION['due']) ? esc_attr( $_SESSION['due'] ):'',
					            'tid' 		=> $_POST['item_number'],
					            'tname' 	=> $_POST['item_name'],
					            'datetime' 	=> $dtime,
					            'booking' 	=> Array
					            (
				                    'fname' 	=> $_POST['first_name'],
				                    'lname' 	=> $_POST['last_name'],
				                    'email' 	=> $_POST['payer_email'],
				                    'address' 	=> $_POST['address_street'],
				                    'city' 		=> $_POST['address_city'],
				                    'country' 	=> $_POST['address_country_code'],
				                    'postcode' 	=> $_POST['address_zip'],
					            ),
					            'payment'	=> Array
					            (
				                	'payment_status' => $_POST['payment_status'],
									'payer_status' 	 => $_POST['payer_status'],
									'payment_type' 	 => $_POST['payment_type'],
									'txn_id'		 => $_POST['txn_id'],
									'payment_gateway'=> 'paypal'
								)
					        )
						);
					}
					?>
					<input type="hidden" name="wp_travel_engine_placeorder_setting[place_order][traveler]" value="<?php echo esc_attr( $_GET['ID'] );?>">
					<input type="hidden" name="wp_travel_engine_booking_setting[place_order][cost]" value="<?php echo esc_attr( $_POST['payment_gross']);?>">
					<input type="hidden" name="wp_travel_engine_booking_setting[place_order][tid]" value="<?php echo  esc_attr($_POST['item_number']);?>">
					<input type="hidden" name="wp_travel_engine_booking_setting[place_order][tname]" value="<?php echo esc_attr($_POST['item_name']);?>">
					<input type="hidden" name="wp_travel_engine_booking_setting[place_order][datetime]" value="<?php echo esc_attr($dtime);?>">
				<?php
				}
			}

			if ( isset( $_SESSION['travelers'] ) && $_SESSION['travelers']!='' )
			{
				$pno = esc_attr( $_SESSION['travelers'] );
			} 

			if( isset($order_metas) && is_array($order_metas) )
			{
			    global $wpdb;
			    $new_post = array(
			      'post_status' => 'publish',
			      'post_type' 	=> 'booking',
			      'post_title' 	=> 'booking',
			      );
			    $post_id = wp_insert_post( $new_post );

			    $book_post = array(
				      'ID'           => $post_id,
				      'post_title'   => 'booking '.$post_id,
				  	);
				// Update the post into the database
				$updated = wp_update_post( $book_post );
			   	
				$bid[] = $post_id;

				$order_metas = array_merge_recursive( $order_metas, $bid );
			    update_post_meta( $post_id, 'wp_travel_engine_booking_setting', $order_metas );
				
			    $this->insert_customer( $order_metas );
			    
			    if ( false === $updated ) {
			      _e( 'There was an error on update.','wp-travel-engine' );
			    }
			    $class = 'Wp_Travel_Engine_Mail_Template';
                $obj = apply_filters('mail_template_class', $class);
                $obj = new $obj;
                $obj->mail_editor( $order_metas,$post_id );
				
				$obj = new Wp_Travel_Engine_Functions();
				$personal_options = $obj->order_form_personal_options();
				$relation_options = $obj->order_form_relation_options();
				$_SESSION['tid'] = esc_attr( $post_id );
			}

			if(isset($options['travelers_information']))
			{
				if (isset($_POST))
				{
				    $error_found = FALSE;
				 
				    //  Some input field checking
				 
				    if ($error_found == FALSE)
				    {
				        
				        //  Use the wp redirect function
				        wp_redirect( esc_url( get_permalink( $wp_travel_engine_thankyou ) ) );
				    }
				    else
				    {
				        //  Some errors were found, so let's output the header since we are staying on this page
				        if (isset($_GET['noheader']))
				            require_once(ABSPATH . 'wp-admin/admin-header.php');
				    }
				}
			}
				for ($i=1; $i <=$pno; $i++) { ?>
					<div class='wp-travel-engine-personal-details-wrapper'>
						<div class='personal-options-title'>
						<?php
							_e('Personal details for Traveler: ','wp-travel-engine');echo $i;
						?>
						</div>
						<div class='wp-travel-engine-personal-details-inner-wrapper'>
							<?php
							$obj = new Wp_Travel_Engine_Functions();
							$personal_options = $obj->order_form_personal_options();
							$relation_options = $obj->order_form_relation_options();
							foreach ($personal_options as $key => $value) { ?>
								<div class='wp-travel-engine-personal-details'>
									<?php
									switch ($key) {
										case 'fname':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'lname':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'email':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'passport':?> 
										<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'address':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'city':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'country':?>
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<select <?php if( $value['required'] == '1' ) { echo 'required';   } ?> id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
												<option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>
												<?php
												$obj = new Wp_Travel_Engine_Functions();
												$options = $obj->wp_travel_engine_country_list();
												
												foreach ( $options as $key => $val ) {
													echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '">' . esc_html( $val ) . '</option>';
												}
												?>
										</select>
										<?php
										break;	

										case 'postcode':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="text" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'phone':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'dob':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input class="wp-travel-engine-datetime" type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'title':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<select id="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" name="wp_travel_engine_placeorder_setting[place_order][travelers][<?php echo esc_attr( $key );?>][<?php echo $i;?>]">
										<option value=" "><?php _e( 'Please choose&hellip;', 'wp-travel-engine' ); ?></option>
										<?php
											foreach ( $value['options'] as $key => $value ) {
												echo '<option value="' .( !empty($value)?esc_attr( $value ):"Please select")  . '">' . esc_html( $value ) . '</option>';
											}
										?>	
										</select>
										<?php
										break;
									} ?>
								</div>
							<?php
							} ?>
						</div>
					</div>
					<div class='wp-travel-engine-relation-details-wrapper'>
						<div class='relation-options-title'>
						<?php
						 	_e('Emergency contact details for Traveler: ','wp-travel-engine'); echo $i;
						?>
						</div>
						<div class='wp-travel-engine-relation-details-inner-wrapper'>
							<?php
							foreach ($relation_options as $key => $value) { ?>
								<div class='wp-travel-engine-relation-details'>
									<?php
									switch ($key) { 
										case 'title':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<select id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]">
											<option value=" "><?php _e( 'Please choose&hellip;', 'wp-travel-engine' ); ?></option>
											<?php
												foreach ( $value['options'] as $key => $value ) {
													echo '<option value="' .( !empty($value)?esc_attr( $value ):"Please select")  . '">' . esc_html( $value ) . '</option>';
												}
											?>	
										</select>	
										<?php
										break;

										case 'fname':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'lname':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'address':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'postcode':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'phone':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;

										case 'relation':?> 
										<label for="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]"><?php _e($value['label'],'wp-travel-engine');?></label>
										<input type="<?php echo $value['type'];?>" name="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" id="wp_travel_engine_placeorder_setting[place_order][relation][<?php echo esc_attr( $key );?>][<?php echo $i;?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
										<?php
										break;
									} ?>
								</div>	
							<?php
							} ?>
						</div>
						<div class="gp-confirmation">
						<?php 
						$options = get_option('wp_travel_engine_settings', true);
							if( isset( $options['placeorder']['gp'] ) && $options['placeorder']['gp']!='')
							{ ?>
							<p>
							<?php
							echo sprintf( '<b>%s</b>', __( 'GP confirmation ', 'wp-travel-engine' ) );
							echo isset($options['placeorder']['gp']) ?  wp_kses_post( $options['placeorder']['gp'] ): '';?>
							</p>
							<?php } 
							if( isset($options['placeorder']['disclaimer']) && $options['placeorder']['disclaimer']!='' )
								{ ?>
							<p>
							<?php 
							echo sprintf( '<b>%s</b>', __( 'Disclaimer ', 'wp-travel-engine' ) );
							echo isset($options['placeorder']['disclaimer']) ? wp_kses_post( $options['placeorder']['disclaimer'] ): '';?>
							</p>
							<?php } ?>
						</div>
					</div>
					<?php do_action('wp_travel_engine_medication_form', $i);
				} 
				$nonce = wp_create_nonce('wp_travel_engine_final_confirmation_nonce');
				?>
				<input type="hidden" name="nonce" value="<?php echo $nonce;?>">
				<input type="submit" name="wp-travel-engine-confirmation-submit" value="<?php _e('Confirm Booking','wp-travel-engine');?>">
		</form>
		<?php
		
		$i++;
	}

	/**
	*Insert new customer.
	* @since 1.0
	*/
	function insert_customer(&$order_metas)
	{
		global $wpdb;
		if ( ! is_admin() ) {
    		require_once( ABSPATH . 'wp-admin/includes/post.php' );
		}
	    $post = get_post( $_SESSION['trip-id'] ); 
		$slug = $post->post_title;
	    if( post_exists( $order_metas['place_order']['booking']['email'],'','' ) == 0 )
	    {
		    $new_post = array(
		      'post_status' => 'publish',
		      'post_type' => 'customer',
		      'post_title' => 'customer',
		    );
		    $post_id = wp_insert_post( $new_post );

			foreach ($order_metas['place_order'] as $key => $value) {
				$arr[$key][1] = $value;
			}
			unset($arr['booking']);
			
			$booked_id[] = $order_metas[0];

			if(!isset($booked_id) && !is_array($booked_id) )
			{
				$booked_id = array();
			}

		    update_post_meta( $post_id, 'wp_travel_engine_bookings', $booked_id );
		    update_post_meta( $post_id, 'wp_travel_engine_booking_setting', $order_metas );
		    update_post_meta( $post_id, 'wp_travel_engine_booked_trip_setting', $arr );

		    $customer_post = array(
			      'ID'           => $post_id,
			      'post_title'   => esc_attr( $order_metas['place_order']['booking']['email'] ),
			  	);
			// Update the post into the database
			$updated = wp_update_post( $customer_post );
		    
		    if ( false === $updated ) {
		      _e( 'There was an error on update.','wp-travel-engine' );
		    }
		}
		else{

			$pid = get_page_by_title( $order_metas['place_order']['booking']['email'], OBJECT, 'customer' );
		    $my_array = get_post_meta( $pid->ID, 'wp_travel_engine_booked_trip_setting', true );
		   
		    if( isset( $my_array ) && $my_array!='' )
		    {
		    	$size = sizeof( $my_array['traveler'] );
		    }
		    else{
		    	$my_array[] = '';
		    	$size = 0;
		    }
		    $size++;
		    foreach ($order_metas['place_order'] as $key => $value) {
				$arr[$key][$size] = $value;
			}
			unset( $arr['booking'] );
			$a = array_merge_recursive( $my_array, $arr );
		    $my_bookings = get_post_meta( $pid->ID, 'wp_travel_engine_bookings', true );
		    $booked_id[] = $order_metas[0];
		    if( !isset( $booked_id ) && !is_array( $booked_id )  )
			{
				$booked_id = array();
			}
		    if( isset( $my_bookings ) && $my_bookings!='' )
		    {
		    	$my_bookings = array_merge_recursive( $my_bookings, $booked_id );
		    }
		    else{
		    	$my_bookings[] = '';
		    }
		    update_post_meta( $pid->ID, 'wp_travel_engine_booked_trip_setting', $a );
		    update_post_meta( $pid->ID, 'wp_travel_engine_bookings', $my_bookings );
		}	
	}
}
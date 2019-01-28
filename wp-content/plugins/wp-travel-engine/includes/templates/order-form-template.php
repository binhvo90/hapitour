<?php		
	$obj = new Wp_Travel_Engine_Functions();
	$billing_options  = $obj->order_form_billing_options();
	$personal_options = $obj->order_form_personal_options();
	$relation_options = $obj->order_form_relation_options();
	$pid = isset($_POST['trip-id']) ? esc_attr( $_POST['trip-id'] ): $_SESSION['tid'] ;
	$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true );
	$wp_travel_engine_trip_setting = get_post_meta( $pid, 'wp_travel_engine_setting', true );
	$_SESSION = $_POST;
	$pno = isset($_POST['travelers']) ? esc_attr( $_POST['travelers'] ): $_SESSION['travelers'];
	
	$datetime = isset($_POST['trip-date']) ? esc_attr( $_POST['trip-date'] ):$_SESSION['trip-date'];
    
    $obj = new Wp_Travel_Engine_Functions();
    $code = isset($wp_travel_engine_settings['currency_code']) ? $wp_travel_engine_settings['currency_code']: 'USD';
    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
	
	$wp_travel_engine_confirm = isset($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) ? esc_attr($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) : '';
	$wp_travel_engine_confirm = get_permalink( $wp_travel_engine_confirm );
	
	//Fixed starting dates
	if( class_exists( 'WTE_Fixed_Starting_Dates' ) )
	{
		$WTE_Fixed_Starting_Dates_setting = get_post_meta($_POST['trip-id'], 'WTE_Fixed_Starting_Dates_setting', true);
		$wp_travel_engine_setting = get_post_meta( $_POST['trip-id'],'wp_travel_engine_setting',true );
    	$sortable_settings = get_post_meta($_POST['trip-id'], 'list_serialized', true);
    	if(!is_array($sortable_settings))
        {
          $sortable_settings = json_decode($sortable_settings);
        }
        if(isset($WTE_Fixed_Starting_Dates_setting) && $WTE_Fixed_Starting_Dates_setting!='' && isset($sortable_settings) && $sortable_settings!='')
		{ 
	        $today = strtotime(date("Y-m-d"))*1000;
			foreach($sortable_settings as $content)
			{
				if(isset($WTE_Fixed_Starting_Dates_setting['departure_dates']['edate'][$content->id]))
				{
		    		if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
		        	{
		        		if( $datetime == $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id] )
		        		{
		        			$trip_cost = $WTE_Fixed_Starting_Dates_setting['departure_dates']['cost'][$content->id];
		        			$tcost = esc_attr( str_replace( ',','', $trip_cost ) )*$pno;
		        		}
		        	}
		        }
		    }
		}
	}
	else{
		if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
		{
			$trip_cost = $wp_travel_engine_trip_setting['trip_price'];
		}
		else
		{
			$trip_cost = $wp_travel_engine_trip_setting['trip_prev_price'];
		}

		$tcost = esc_attr( str_replace( ',','', $trip_cost ) )*$pno;
	}

	//Group Discount
	if( class_exists('Wp_Travel_Engine_Group_Discount') && isset($wp_travel_engine_trip_setting['group']['discount']) )
    {
		if( isset($wp_travel_engine_trip_setting['group']['traveler']) && in_array( $pno, $wp_travel_engine_trip_setting['group']['traveler'] ) )
		{
			$key = array_search ( $pno, $wp_travel_engine_trip_setting['group']['traveler'] );
			$cost = $wp_travel_engine_trip_setting['group']['cost'][$key];
			$tcost = $cost;
			$per_traveler = $tcost;
		}
		else{
			if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
			{
				$cost = $wp_travel_engine_trip_setting['trip_price']*$_POST['travelers'];
				$per_traveler = $cost;
				$tcost = $cost;
			}
			else
			{
				$cost = $wp_travel_engine_trip_setting['trip_prev_price']*$_POST['travelers'];
				$per_traveler = $cost;
				$tcost = $cost;
			}
		}
	}

	////////////
	$wp_travel_engine_postmeta_settings = get_post_meta( $pid, 'wp_travel_engine_setting', true );
	if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_trip_setting['group']['discount']) && isset( $_POST['child-travelers'] ) && $_POST['child-travelers']!='0' )
	{ 
		$id = isset( $_POST['child-travelers'] ) ? esc_attr($_POST['child-travelers']):'';
		if( isset($wp_travel_engine_trip_setting['group']['child']) && in_array( $id, $wp_travel_engine_trip_setting['group']['child'] ) )
		{
			$key = array_search ( $id, $wp_travel_engine_trip_setting['group']['child'] );
			$cost = $wp_travel_engine_trip_setting['group']['child_cost'][$key];
		}
		else{
			if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
			{
				$cost = $wp_travel_engine_trip_setting['trip_price']*$_POST['child-travelers'];
			}
			else
			{
				$cost = $wp_travel_engine_trip_setting['trip_prev_price']*$_POST['child-travelers'];
			}
		}
	}
    if( class_exists('Wp_Travel_Engine_Group_Discount') && isset($wp_travel_engine_trip_setting['group']['discount'])  )
    {
		if(isset($wp_travel_engine_trip_setting['group']['traveler']))
		{
			if( in_array( $pno, $wp_travel_engine_trip_setting['group']['traveler'] ) )
			{
				$key = array_search ( $pno, $wp_travel_engine_trip_setting['group']['traveler'] );
				$cost = $wp_travel_engine_trip_setting['group']['cost'][$key];
				$tcost = $cost;
				$per_traveler = $tcost;
			}
		}
		else{
			$per_traveler = $tcost;
		}

		$id = isset( $_POST['child-travelers'] ) ? esc_attr($_POST['child-travelers']):'';
		if( isset( $wp_travel_engine_trip_setting['group']['child'] ) && in_array( $id, $wp_travel_engine_trip_setting['group']['child'] ) )
		{
			$key = array_search ( $id, $wp_travel_engine_trip_setting['group']['child'] );
			$cost = $wp_travel_engine_trip_setting['group']['child_cost'][$key];
			$tcost = $tcost+$cost;
		}
		else{

			if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
			{
				$cost = $wp_travel_engine_trip_setting['trip_price']*$_POST['child-travelers'];
			}
			else
			{
				$cost = $wp_travel_engine_trip_setting['trip_prev_price']*$_POST['child-travelers'];
			}
			$tcost = $tcost+$cost;
		}
	}
	////////////

	$deposit_cost = $tcost;

	//Partial Payment
	if( class_exists('Wte_Partial_Payment_Admin') && isset( $wp_travel_engine_settings['partial_payment_enable'] ) )
    {
    	if( isset( $wp_travel_engine_settings['partial_payment_enable'] ) && isset( $wp_travel_engine_trip_setting['partial_payment_enable'] ) )
    	{
			if( isset( $wp_travel_engine_settings['partial_payment_option'] ) && $wp_travel_engine_settings['partial_payment_option'] == 'percent' )
  			{
				if( isset( $wp_travel_engine_settings['partial_payment_percent'] ) && $wp_travel_engine_settings['partial_payment_percent']!='' )
				{
					$partial = $wp_travel_engine_settings['partial_payment_percent'];
				}
				
				if( isset( $wp_travel_engine_trip_setting['partial_payment_percent'] ) && $wp_travel_engine_trip_setting['partial_payment_percent']!='' )
				{
					$partial = $wp_travel_engine_trip_setting['partial_payment_percent'];
				}
				
				$partial = 100-$partial;
				$deposit_cost = ($tcost)-($partial/100)*$tcost;
				$_POST['due'] = $tcost-$deposit_cost;
				$_SESSION['due'] = $tcost-$deposit_cost;
				$_SESSION['trip-cost'] = $deposit_cost;
    		}

    		if( isset( $wp_travel_engine_settings['partial_payment_option'] ) && $wp_travel_engine_settings['partial_payment_option'] == 'amount' )
  			{
				if( isset( $wp_travel_engine_settings['partial_payment_amount'] ) && $wp_travel_engine_settings['partial_payment_amount']!='' )
				{
					$deposit_cost= $wp_travel_engine_settings['partial_payment_amount'];
					$_POST['due'] = $tcost-$deposit_cost;
					$_SESSION['due'] = $tcost-$deposit_cost;
					$_SESSION['trip-cost'] = $deposit_cost;
				}
				
				if( isset( $wp_travel_engine_trip_setting['partial_payment_amount'] ) && $wp_travel_engine_trip_setting['partial_payment_amount']!='' )
				{
					$deposit_cost = $wp_travel_engine_trip_setting['partial_payment_amount'];
					$_POST['due'] = $tcost-$deposit_cost;
					$_SESSION['due'] = $tcost-$deposit_cost;
					$_SESSION['trip-cost'] = $deposit_cost;
				}
    		}
    	}
	}

	if( isset($_POST['fdd-id']) && $_POST['fdd-id']!='' )
	{
		$_SESSION['fdd-id'] = $_POST['fdd-id'];
	}

?>
	<div class="place-order-form-secondary-wrapper">
		<?php 
		do_action('wte_cart_form_wrapper');
		do_action('wte_cart_trips');
		if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
		{
			$trip_cost = $wp_travel_engine_trip_setting['trip_price'];
		}
		else
		{
			$trip_cost = $wp_travel_engine_trip_setting['trip_prev_price'];
		}
		?>
		<span id="wte_upsell_holder"></span>
		<div class="wp-travel-engine-order-form-wrapper">
			<div class="wp-travel-engine-order-left-column">
	        	<?php echo get_the_post_thumbnail($pid,'medium',''); ?>
			</div>
			<div class="wp-travel-engine-order-right-column">
				<h3 class="trip-title"><?php echo get_the_title( $pid );?><input type="hidden" name="trips[]" value="<?php echo esc_attr( $pid );?>"></h3>
				<ul class="trip-property">
					<li><span><?php _e('Start Date: ','wp-travel-engine');?></span><?php echo esc_attr( $datetime );?><input type="hidden" name="trip-date[]" value="<?php echo esc_attr( $datetime );?>"></li>
					<li><span><?php _e('Trip Price: ','wp-travel-engine');?></span><?php echo esc_attr($currency.$trip_cost.' '.$code); ?></li>
    	        	<?php
    	        	if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_trip_setting['group']['discount']) )
					{ ?>
    	        		<li><span><?php _e('Group Discount Price Per Person: ','wp-travel-engine');?></span><?php
	    	        	if(isset($wp_travel_engine_trip_setting['group']['discount']))
    					{ ?>
	    	        		<?php echo esc_attr($currency).esc_attr($per_traveler/$pno).' '.esc_attr($code);?>
    					<?php
    					}
    					?>
    					</li>
					<?php
					}
					?>
					<?php
    	        	if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_trip_setting['group']['discount']) && isset( $_POST['child-travelers'] ) && $_POST['child-travelers']!='0' )
					{ ?>
    	        		<li><span><?php _e('Group Discount Price Per Child: ','wp-travel-engine');?></span>
							<?php
    	        			$id = isset( $_POST['child-travelers'] ) ? esc_attr($_POST['child-travelers']):'';
							if( isset($wp_travel_engine_trip_setting['group']['child']) && in_array( $id, $wp_travel_engine_trip_setting['group']['child'] ) )
							{
								$key = array_search ( $id, $wp_travel_engine_trip_setting['group']['child'] );
								$cost = $wp_travel_engine_trip_setting['group']['child_cost'][$key];
								echo esc_attr($currency).esc_attr($cost/$_POST['child-travelers']).' '.esc_attr($code);
							}
							else{
								if(isset($wp_travel_engine_trip_setting['sale']) && isset($wp_travel_engine_trip_setting['sale']) && $wp_travel_engine_trip_setting['trip_price']!='')
								{
									$cost = $wp_travel_engine_trip_setting['trip_price']*$_POST['child-travelers'];
								}
								else
								{
									$cost = $wp_travel_engine_trip_setting['trip_prev_price']*$_POST['child-travelers'];
								}
								if( isset( $_POST['child-travelers'] ) )
								{
			                    	echo esc_attr($currency).esc_attr($cost/$_POST['child-travelers']).' '.esc_attr($code);
								}
							}
							?>
    					</li>
					<?php
					}
					?>
					<li><span><?php _e('Duration: ','wp-travel-engine');?></span><?php echo isset( $wp_travel_engine_trip_setting['trip_duration'] ) ? esc_attr($wp_travel_engine_trip_setting['trip_duration'].' days'):''; ?></li>
					<li><span><?php _e('Number of Travelers: ','wp-travel-engine');?></span><?php echo '<span class="travelers-number">'.esc_attr($pno).'</span>'; ?><input type="hidden" name="travelers[]" value="<?php echo esc_attr($pno); ?>"></li>
    	        	<?php
    	        	if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_trip_setting['group']['discount']) && isset( $_POST['child-travelers'] ) && $_POST['child-travelers']!='0' )
					{ ?>
						<li><span><?php _e('Number of Child Travelers: ','wp-travel-engine');?></span><?php echo '<span class="travelers-number">'.esc_attr($_POST['child-travelers']).'</span>'; ?><input type="hidden" name="travelers[]" value="<?php echo esc_attr($_POST['child-travelers']); ?>"></li>
					<?php }?>
					<?php
    	        	if( class_exists('Wte_Partial_Payment_Admin') && isset( $wp_travel_engine_settings['partial_payment_enable'] ) )
					{ ?>
						<li><span><?php _e('Total Remaining Payment','wp-travel-engine');?></span><?php echo esc_attr($currency).'<span class="total-trip-price">'.esc_attr( $obj->wp_travel_engine_price_format( $tcost-$deposit_cost ) ).' '.esc_attr($code).'</span>';?></li>
						<li class="cart-trip-total-price"><span style="width: auto;"><?php _e('Deposit Payable Now:  ','wp-travel-engine');?></span><?php echo '<span class="currency" style="width: auto;">'.esc_attr($currency).'</span><span class="cart-trip-total-price-holder" style="width: auto;">'.esc_attr( $obj->wp_travel_engine_price_format( $deposit_cost ) ).'</span><span class="currency-code" style="width: auto;">'.esc_attr( ' '.$code ).'</span>';?></li>
					<?php 
					}
					?>
				</ul>
			</div>
		</div>
	    <div class="secondary-inner-wrapper"><?php
	    	if(isset($pid)):
	    	    
				if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_trip_setting['group']['discount']) && isset( $_POST['child-travelers'] ) && $_POST['child-travelers']!='0' )
				{
					$pno = $pno + $_POST['child-travelers'];
				}
	    	    $cost = esc_attr( $tcost );
	    	    if(isset($cost) && $cost!='')
	    	    {
	    	        ?>
	    	        <div class="person-price-table">
	    	        	<table id="wte-cart-table">
	    	        	<thead>
	    	        	<tr>
	    	        	<th><?php _e('Total Traveler(s)','wp-travel-engine');?></th>
	    	        	<th><?php _e('Total Price','wp-travel-engine');?></th>
	    	        	</tr>
	    	        	</thead>
	    	        	<tbody>
	    	        	<tr>
	    	        	<td><?php echo '<span class="total-trip-travelers">'.esc_attr($pno).'</span>'; ?></td>
	    	        	<td><?php echo esc_attr($currency).'<span class="total-trip-price">'.esc_attr( $obj->wp_travel_engine_price_format( $tcost ) ).'</span>'.' '.esc_attr($code);?></td>
	    	            </tr>
	    	            </tbody>
	    	            </table>
						<?php
						do_action('wte_cart_form_close'); ?>
	    	        </div>
	    	        <?php
	    	    }
	    	endif;
	    	?>
	    </div>
	    <?php
		$trip_id = $pid;
		// $_SESSION = $_POST;
		do_action( 'wte_cross_sell', $trip_id ); ?>
	</div>
	<form method="post" id="wp-travel-engine-order-form" method="post" name="wp-travel-engine-order-form" action="<?php echo esc_url($wp_travel_engine_confirm);?>">
		<div id="price-loader" style="display: none">
            <div class="table">
                <div class="table-row">
                    <div class="table-cell">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
		<div class="order-submit">
			<?php
			do_action('wte_payment_gateways_dropdown');
			?>
			<input type="hidden" name="wp_travel_engine_booking_setting[place_order][datetime]" value="<?php echo esc_attr( $datetime );?>">
		</div>
		<div class="place-order-form-primary-wrapper">
			<div class="wp-travel-engine-billing-details">
				<div class='relation-options-title'><?php $billing_details = __('Billing Details: ','wp-travel-engine'); echo apply_filters( 'wpte_billings_details_title',$billing_details);?></div>
				<div class="wp-travel-engine-billing-details-wrapper">
					<?php
					foreach ($billing_options as $key => $value) { ?>
					<div class='wp-travel-engine-billing-details-field-wrap'>
							<?php
							switch ($key) {

								case 'fname':?> 
								<label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'lname':?> 
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'email':?> 
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'passport':?> 
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'address':?> 
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'city':?> 
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
								<?php
								break;

								case 'country':?>
								<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
								<select required id="<?php echo esc_attr( $key );?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
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
							}
						 ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php do_action('wte_acqusition_form'); $checkout_nonce = wp_create_nonce( 'checkout-nonce' );?>
		<?php 
		do_action('wte_mailchimp_confirmation');
		do_action('wte_mailerlite_confirmation');
		do_action('wte_convertkit_confirmation');
		?>
			<input type="hidden" value="<?php echo $checkout_nonce;?>" name="check-nonce">
			<?php
			$options = get_option('wp_travel_engine_settings', true);
			$wp_travel_engine_terms_conditions = isset($options['pages']['wp_travel_engine_terms_and_conditions']) ? esc_attr($options['pages']['wp_travel_engine_terms_and_conditions']) : '';
			if( isset( $options['pages']['wp_travel_engine_terms_and_conditions'] ) && $options['pages']['wp_travel_engine_terms_and_conditions'] !='0' )
			{ ?>
			<div id="wp-travel-engine-terms">
				<label for="wp_travel_engine_booking_setting[terms_conditions]">
				<input type="checkbox" required value="0" id="wp_travel_engine_booking_setting[terms_conditions]" name="wp_travel_engine_booking_setting[terms_conditions]">
				<?php
				if( get_privacy_policy_url() )
				{
					printf( __( 'Check the box to confirm you\'ve read and agree to our <a href="%1$s" id="contact" target="_blank"> Terms and Conditions</a> and <a href="%2$s" id="contact" target="_blank">Privacy Policy</a>.', 'wp-travel-engine'), esc_url( get_permalink( $wp_travel_engine_terms_conditions ) ), esc_url( get_privacy_policy_url()) ); ?><span class="required">*</span>
				<?php
				}
				
				?>
				</label>
			</div>
			<?php } ?>
			<div class="error"></div>
			<div class="successful"></div>
			<?php 
			$confirm_booking = __('Confirm Booking','wp-travel-engine');
			?>
			<input type="submit" class="wp-travel-engine-submit" name="wp-travel-engine-submit" value="<?php echo apply_filters('wpte_confirm_bookig_button', $confirm_booking);?>">
			<div id="submit-loader" style="display: none">
                <div class="table">
                    <div class="table-row">
                        <div class="table-cell">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
			<?php do_action( 'wte_up_sell', $trip_id ); ?>
	</form>
	<?php do_action('wte_paypalexpress_form'); ?>
	<?php do_action('paypal_checkbox'); ?>    

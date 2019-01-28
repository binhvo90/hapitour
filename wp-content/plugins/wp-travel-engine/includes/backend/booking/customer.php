<?php
global $post;
$wp_travel_engine_postmeta_settings = get_post_meta( $post->ID, 'wp_travel_engine_booking_setting', true );
?>
<div class="customer-info-meta">
	<div class="customer-gravatar">
	<?php echo get_avatar( esc_attr( $wp_travel_engine_postmeta_settings['place_order']['booking']['email'] ), 100 ); ?>
	</div>
	<div class="customer-detail">
    	<label><?php _e('Customer ID: ','wp-travel-engine');?></label>
        <?php echo esc_attr( $post->ID ); ?> 
    </div>
    <div class="customer-detail-wrap">
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][fname]"><?php _e('First Name: ','wp-travel-engine');?></label>	
			<input type="text" id="wp_travel_engine_booking_setting[place_order][booking][fname]" name="wp_travel_engine_booking_setting[place_order][booking][fname]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['fname']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['fname']):'';?>">
		</div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][lname]"><?php _e('Last Name: ','wp-travel-engine');?></label>	
			<input type="text" id="wp_travel_engine_booking_setting[place_order][booking][lname]" name="wp_travel_engine_booking_setting[place_order][booking][lname]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['lname']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['lname']):''?>">
		</div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][email]"><?php _e('Email: ','wp-travel-engine');?></label>	
			<input type="email" id="wp_travel_engine_booking_setting[place_order][booking][email]" name="wp_travel_engine_booking_setting[place_order][booking][email]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['email']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['email']):'';?>">
		</div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][address]"><?php _e('Address: ','wp-travel-engine');?></label>	
			<input type="text" id="wp_travel_engine_booking_setting[place_order][booking][address]" name="wp_travel_engine_booking_setting[place_order][booking][address]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['address']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['address']):'';?>">
		</div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][city]"><?php _e('City: ','wp-travel-engine');?></label>	
			<input type="text" id="wp_travel_engine_booking_setting[place_order][booking][city]" name="wp_travel_engine_booking_setting[place_order][booking][city]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['city']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['city']):'';?>"><br/>
		</div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][country]"><?php _e('Country:','wp-travel-engine');?></label>
	    	<select required id="wp_travel_engine_booking_setting[place_order][booking][country]" name="wp_travel_engine_booking_setting[place_order][booking][country]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
	            <option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>
	            <?php
	            $value = $wp_travel_engine_postmeta_settings['place_order']['booking']['country'];
	            $obj = new Wp_Travel_Engine_Functions();
	            $options = $obj->wp_travel_engine_country_list();
	            foreach ( $options as $key => $val ) {
	                echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '"' . selected( $value, $val, false ) . '>' . esc_html( $val ) . '</option>';
	            }
	            ?>
	    	</select>
	    </div>
		<div class="customer-detail">
			<label for="wp_travel_engine_booking_setting[place_order][booking][postcode]"><?php _e('Post-code: ','wp-travel-engine');?></label>	
			<input type="number" id="wp_travel_engine_booking_setting[place_order][booking][postcode]" name="wp_travel_engine_booking_setting[place_order][booking][postcode]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['postcode']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['postcode']):'';?>">
		</div>
	</div>
</div>
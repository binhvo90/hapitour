<?php 
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true ); 
$feat_img = isset( $wp_travel_engine_settings['feat_img'] ) ? esc_attr($wp_travel_engine_settings['feat_img']):'0';
?>
<div class="wpte-row">
	<div class="wp-travel-engine-captcha">
		<label for="wp_travel_engine_settings[currency_code]"><?php _e('Currency code:','wp-travel-engine'); ?>
		</label>
		<select id="wp_travel_engine_settings[currency_code]" name="wp_travel_engine_settings[currency_code]" data-placeholder="<?php esc_attr_e( 'Choose a currency&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select">
			<option value=""><?php _e( 'Choose a currency&hellip;', 'wp-travel-engine' ); ?></option>
			<?php
			$obj = new Wp_Travel_Engine_Functions();
			$currencies = $obj->wp_travel_engine_currencies();
			$code = 'USD';
            if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
            {
                $code = $wp_travel_engine_settings['currency_code'];
            } 
			$currency = $obj->wp_travel_engine_currencies_symbol( $code );
			foreach ( $currencies as $key => $name ) {
				echo '<option value="' .( !empty($key)?esc_attr( $key ):"USD")  . '" ' . selected( $code, $key, false ) . '>' . esc_html( $name . ' (' . $obj->wp_travel_engine_currencies_symbol( $key ) . ')' ) . '</option>';
			}
			?>
		</select>
	</div>

	<div class="wp-travel-engine-captcha">
		<label for="wp_travel_engine_settings[book_btn_txt]"><?php _e('Book Now Button Text : ','wp-travel-engine');?></label> 
		<input type="text" id="wp_travel_engine_settings[book_btn_txt]" name="wp_travel_engine_settings[book_btn_txt]" value="<?php echo isset($wp_travel_engine_settings['book_btn_txt']) ? esc_attr( $wp_travel_engine_settings['book_btn_txt'] ): 'Book Now';?>" placeholder="<?php _e('Book now button label','wp-travel-engine');?>">
	</div>

	<div class="wp-travel-engine-settings">
		<label for="wp_travel_engine_settings[booking]"><?php _e('Hide Booking Form : ','wp-travel-engine');?></label>
		<input type="checkbox" id="wp_travel_engine_settings[booking]" class="hide-booking" name="wp_travel_engine_settings[booking]" value="1" <?php if(isset($wp_travel_engine_settings['booking']) && $wp_travel_engine_settings['booking']!='' ) echo 'checked'; ?>>
		<div class="settings-note"><?php _e( 'If checked, booking form in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></div>
	</div>
	
	<div class="wp-travel-engine-settings">
		<label for="wp_travel_engine_settings[enquiry]"><?php _e('Hide Enquiry Form : ','wp-travel-engine');?></label>
		<input type="checkbox" id="wp_travel_engine_settings[enquiry]" class="hide-enquiry" name="wp_travel_engine_settings[enquiry]" value="1" <?php if(isset($wp_travel_engine_settings['enquiry']) && $wp_travel_engine_settings['enquiry']!='' ) echo 'checked'; ?>>
		<div class="settings-note"><?php _e( 'If checked, enquiry form in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></div>
	</div>
	<div class="wp-travel-engine-settings">
		<label for="wp_travel_engine_settings[feat_img]"><?php _e('Hide Trip Featured Image : ','wp-travel-engine');?></label>
		<input type="checkbox" id="wp_travel_engine_settings[feat_img]" name="wp_travel_engine_settings[feat_img]" value="1" <?php echo checked('1',$feat_img); ?>>
		<div class="settings-note"><?php _e( 'If checked, featured image in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></div>
	</div>
	<div class="wp-travel-engine-settings enquiry-subject">
		<label for="wp_travel_engine_settings[query_subject]"><?php _e('Email Subject for Enquiry : ','wp-travel-engine');?></label>
		<input type="text" id="wp_travel_engine_settings[query_subject]" name="wp_travel_engine_settings[query_subject]" value="<?php echo isset($wp_travel_engine_settings['query_subject']) ? esc_attr( $wp_travel_engine_settings['query_subject'] ): 'Enquiry received';?>">
		<div class="settings-note"><?php _e( 'Email subject for admin if a query is received.', 'wp-travel-engine' ); ?></div>
	</div>

	<div class="wp_travel_engine_settings_pages thankyou-page">
		<label for="wp_travel_engine_settings[pages][enquiry]"><?php _e( 'Enquiry Thankyou Page:','wp-travel-engine' ); ?><span class="required">*</span></label>
			<?php 
			$enquiry = isset($options['pages']['enquiry']) ? esc_attr($options['pages']['enquiry']) : '';
		    wp_dropdown_pages(
		        array(
		             'name' => 'wp_travel_engine_settings[pages][enquiry]',
		             'echo' => 1,
		             'show_option_none' => __( '&mdash; Select &mdash;', 'wp-travel-engine' ),
		             'option_none_value' => '0',
		             'selected' => $enquiry,
		        )
		    );
		    ?>
	    <div class="settings-note"><?php _e('This is the thankyou page where user will be redirected after successful enquiry.','wp-travel-engine');?></div>
	</div>

	<div class="wp-travel-engine-settings">
		<label for="wp_travel_engine_settings[travelers_information]"><?php _e('Travelers Information : ','wp-travel-engine');?></label>
		<input type="checkbox" id="wp_travel_engine_settings[travelers_information]" name="wp_travel_engine_settings[travelers_information]" value="1" <?php if(isset($wp_travel_engine_settings['travelers_information']) && $wp_travel_engine_settings['travelers_information']!='' ) echo 'checked'; ?>>
		<div class="settings-note"><?php _e( 'If checked, information of all the travelers will be optional. After checkout, information of each of the travelers won\'t be asked to fill up.', 'wp-travel-engine' ); ?></div>
	</div>

	<div class="wp-travel-engine-captcha">
		<label for="wp_travel_engine_settings[person_format]"><?php _e('Per Person Format : ','wp-travel-engine');?></label> 
		<input type="text" id="wp_travel_engine_settings[person_format]" name="wp_travel_engine_settings[person_format]" value="<?php echo isset($wp_travel_engine_settings['person_format']) ? esc_attr( $wp_travel_engine_settings['person_format'] ): '/person';?>">
		<div class="settings-note"><?php _e( "Per Person format in the trip booking form. Default is '/person'", "wp-travel-engine" ); ?></div>
	</div>

	<div class="wp-travel-engine-captcha">
		<label for="wp_travel_engine_settings[confirmation_msg]"><?php _e('Booking Confirmation Message : ','wp-travel-engine');?></label> 
		<textarea rows="4" cols="30" id="wp_travel_engine_settings[confirmation_msg]" name="wp_travel_engine_settings[confirmation_msg]"><?php echo isset($wp_travel_engine_settings['confirmation_msg']) ? esc_attr( $wp_travel_engine_settings['confirmation_msg'] ): 'Thank you for booking the trip. Please check your email for confirmation. Below is your booking detail:';?></textarea>
	</div>

	<div class="wp-travel-engine-gdpr">
		<label for="wp_travel_engine_settings[gdpr_msg]"><?php _e('GDPR Message : ','wp-travel-engine');?></label> 
		<textarea rows="4" cols="30" id="wp_travel_engine_settings[gdpr_msg]" name="wp_travel_engine_settings[gdpr_msg]"><?php echo isset($wp_travel_engine_settings['gdpr_msg']) ? esc_attr( $wp_travel_engine_settings['gdpr_msg'] ): 'By contacting us, you agree to our ';?></textarea>
	</div>
	<?php 	
		do_action ('wp_travel_engine_settings_related_posts'); 
	?>
</div>
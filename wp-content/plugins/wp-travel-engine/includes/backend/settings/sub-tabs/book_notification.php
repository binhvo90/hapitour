<?php
	$wp_travel_engine_tabs = get_option( 'wp_travel_engine_settings' );
	if( isset( $wp_travel_engine_settings['email']['sale_subject'] ) && $wp_travel_engine_settings['email']['sale_subject']!='' )
	{
		$subject_book = esc_attr( $wp_travel_engine_tabs['email']['sale_subject'] );
	}
	$subject_book = 'New Booking Order #order_id';
?>
	<div class="book-subject">
		<label for="wp_travel_engine_settings[email][sale_subject]"><?php _e( 'Sale Notification Subject:','wp-travel-engine' ); ?></label>
		<input type="text" name="wp_travel_engine_settings[email][sale_subject]" id="wp_travel_engine_settings[email][sale_subject]" value="<?php echo esc_attr( $subject_book ); ?>">
		<div class="settings-note"><?php _e( 'Enter the booking subject for the purchase receipt email.', 'wp-travel-engine' ); ?></div>
	</div>
	<div class="sales-wpeditor">
		<label for="sales_wpeditor"><?php _e( 'Book Notification:','wp-travel-engine' ); ?></label>
		<?php
		$value_wysiwyg  = __( 'Dear Admin,', 'wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'The following booking has been successfully made.','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Trip Name : {trip_url}','wp-travel-engine' ).  "\n\n"; 
		$value_wysiwyg .= __( 'Trip Cost:  {price}','wp-travel-engine' ).  "\n\n";
		$value_wysiwyg .= __( 'Trip Start Date : {tdate}','wp-travel-engine' ). "\n\n";;
		$value_wysiwyg .= __( 'Total Number of Traveler(s): {traveler}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Total Cost: {price}','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Trip Booking URL: {booking_url}','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Thank you.','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Best regards,','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= get_bloginfo('name');
		if( isset( $wp_travel_engine_settings['email']['sales_wpeditor'] ) && $wp_travel_engine_settings['email']['sales_wpeditor']!='' )
		{
			$value_wysiwyg = $wp_travel_engine_settings['email']['sales_wpeditor'];
		}
		$editor_id = 'sales_wpeditor';
		$settings = array( 'media_buttons' => true, 'textarea_name' => 'wp_travel_engine_settings[email]['.$editor_id.']' );
		wp_editor( $value_wysiwyg, $editor_id, $settings ); ?>
	</div>


	<div class="book-note">
		<?php _e('Enter the text that is sent as sale notification email after completion of a purchase. HTML is accepted. Available template tags:','wp-travel-engine');?>
		<ul>
			<li><?php _e('{trip_url} - The trip URL for each booked trip','wp-travel-engine');?></li><br/>
			<li><?php _e('{name} - The buyer\'s first name','wp-travel-engine');?></li><br/>
			<li><?php _e('{fullname} - The buyer\'s full name, first and last','wp-travel-engine');?></li><br/>
			<li><?php _e('{user_email} - The buyer\'s email address','wp-travel-engine');?></li><br/>
			<li><?php _e('{billing_address} - The buyer\'s billing address','wp-travel-engine');?></li><br/>
			<li><?php _e('{tdate} - The starting date of the trip','wp-travel-engine');?></li><br/>
			<li><?php _e('{traveler} - The total number of traveler(s)','wp-travel-engine');?></li><br/>
			<li><?php _e('{tprice} - The trip price','wp-travel-engine');?></li><br/>
			<li><?php _e('{price} - The total price of the booking','wp-travel-engine');?></li><br/>
			<li><?php _e('{sitename} - Your site name','wp-travel-engine');?></li><br/>
			<li><?php _e('{booking_url} - The trip booking link','wp-travel-engine');?></li><br/>
			<li><?php _e('{ip_address} - The buyer\'s IP Address','wp-travel-engine');?></li><br/>
		</ul>
	</div>

	<div class="book-emails">
		<label for="wp_travel_engine_settings[email][emails]"><?php _e( 'Sale Notification Emails:','wp-travel-engine' ); ?></label>
		<textarea class="large-text" cols="50" rows="5" name="wp_travel_engine_settings[email][emails]" id="wp_travel_engine_settings[email][emails]"><?php 
		$admin_email = get_option( 'admin_email' ); 
		if ( isset( $wp_travel_engine_tabs['email']['emails'] ) && $wp_travel_engine_tabs['email']['emails']!='' ) { 
		
			 	echo esc_attr($wp_travel_engine_tabs['email']['emails']);
		} 
		else { echo esc_attr( $admin_email ); } ?>
		</textarea>
		<div class="settings-note"><?php _e( 'Enter the email address(es) that should receive a notification anytime a sale is made, separated by comma (,) and no spaces.', 'wp-travel-engine' ); ?></div>
	</div>
	<div class="disable-notif">
		<label for="wp_travel_engine_settings[email][disable_notif]"><?php _e( 'Disable Admin Notifications:','wp-travel-engine' ); ?></label>
		<input type="checkbox" name="wp_travel_engine_settings[email][disable_notif]" class="disable_notif" id="wp_travel_engine_settings[email][disable_notif]" <?php
        $j = isset( $wp_travel_engine_tabs['email']['disable_notif'] ) ? esc_attr( $wp_travel_engine_tabs['email']['disable_notif'] ): '0';?> value="<?php echo esc_attr($j);?>" <?php if($j=='1'){ echo "checked";}?>/>
		<div class="settings-note"><?php _e( 'Check this box if you do not want to receive sales notification emails.', 'wp-travel-engine' ); ?></div>
	</div>
	
		
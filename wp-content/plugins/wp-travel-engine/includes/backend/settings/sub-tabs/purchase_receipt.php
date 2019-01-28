<?php
	$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
?>	
	<h4 class="title">Purchase Receipt</h4>
	<div class="from-name">
		<label for="wp_travel_engine_settings[email][name]"><?php _e( 'From Name:','wp-travel-engine' ); ?> <span class="tooltip" title="Enter the name the purchase receipts are sent from. This should probably be your site or shop name."><i class="fas fa-question-circle"></i></span></label>
		<input type="text" name="wp_travel_engine_settings[email][name]" id="wp_travel_engine_settings[email][name]" 
		value="<?php if ( isset($wp_travel_engine_settings['email']['name']) && $wp_travel_engine_settings['email']['name']!='' ){ 
			echo esc_attr( $wp_travel_engine_settings['email']['name'] ); }else{ echo get_bloginfo('name'); } ?>" >
	</div>
	<div class="from-email">
		<label for="wp_travel_engine_settings[email][from]"><?php _e( 'From Email:','wp-travel-engine' ); ?> <span class="tooltip" title="Enter the mail address from which the purchase receipts will be sent. This will act as as the from and reply-to address."><i class="fas fa-question-circle"></i></span></label>
		<input type="text" name="wp_travel_engine_settings[email][from]" id="wp_travel_engine_settings[email][from]" 
		value="<?php if( isset($wp_travel_engine_settings['email']['from'] ) && $wp_travel_engine_settings['email']['from']!='' ){ echo esc_attr($wp_travel_engine_settings['email']['from']); } else{ echo get_option("admin_email"); } ?>" >
	</div>
	<div class="subject-email">
		<label for="wp_travel_engine_settings[email][subject]"><?php _e( 'Purchase Email Subject:','wp-travel-engine' ); ?> <span class="tooltip" title="Enter the subject line for the purchase receipt email."><i class="fas fa-question-circle"></i></span></label>
		<input type="text" name="wp_travel_engine_settings[email][subject]" id="wp_travel_engine_settings[email][subject]" 
		value="<?php if ( isset( $wp_travel_engine_settings['email']['subject'] ) && $wp_travel_engine_settings['email']['subject']!='' ){echo esc_attr( $wp_travel_engine_settings['email']['subject'] ); } else{ echo 'Booking Confirmation'; }?>" >
	</div>
	<div class="purchase-wpeditor">
		<label for="purchase_wpeditor"><?php _e( 'Message:','wp-travel-engine' ); ?></label>
		<?php
		$value_wysiwyg  = __( 'Dear {name},', 'wp-travel-engine' ) . "\n\n" ;
		$value_wysiwyg .= __( 'You have successfully made the trip booking. Your booking information is below.', 'wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= '' . "\n\n";
		$value_wysiwyg .= __( 'Trip Name: {trip_url}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Trip Cost: {tprice}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Trip Start Date : {tdate}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Total Number of Traveler(s): {traveler}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Total Number of Child Traveler(s): {child-traveler}','wp-travel-engine' ). "\n\n";
		$value_wysiwyg .= __( 'Total Cost: {price}','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Thank you.','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= __( 'Best regards,','wp-travel-engine'). "\n\n";
		$value_wysiwyg .= get_bloginfo('name');

		if( isset( $wp_travel_engine_settings['email']['purchase_wpeditor'] ) && $wp_travel_engine_settings['email']['purchase_wpeditor']!='' )
		{
			$value_wysiwyg = $wp_travel_engine_settings['email']['purchase_wpeditor'];
		}
		$editor_id = 'purchase_wpeditor';
		$settings = array( 'media_buttons' => true, 'textarea_name' => 'wp_travel_engine_settings[email]['.$editor_id.']' );
		wp_editor( $value_wysiwyg, $editor_id, $settings );
		?>
		<div class="book-note">
				<?php _e('Enter the text that is sent as purchase receipt email to users after completion of a successful purchase. HTML is accepted. Available template tags:','wp-travel-engine');?>
			<ul>
				<li><?php _e('{trip_url} - The trip URL for each booked trip','wp-travel-engine');?></li><br/>
				<li><?php _e('{name} - The buyer\'s first name','wp-travel-engine');?></li><br/>
				<li><?php _e('{fullname} - The buyer\'s full name, first and last','wp-travel-engine');?></li><br/>
				<li><?php _e('{user_email} - The buyer\'s email address','wp-travel-engine');?></li><br/>
				<li><?php _e('{billing_address} - The buyer\'s billing address','wp-travel-engine');?></li><br/>
				<li><?php _e('{tdate} - The starting date of the trip','wp-travel-engine');?></li><br/>
				<li><?php _e('{traveler} - The total number of traveler(s)','wp-travel-engine');?></li><br/>
				<li><?php _e('{child-traveler} - The total number of child traveler(s)','wp-travel-engine');?></li><br/>
				<li><?php _e('{tprice} - The trip price','wp-travel-engine');?></li><br/>
				<li><?php _e('{price} - The total price of the booking','wp-travel-engine');?></li><br/>
				<li><?php _e('{sitename} - Your site name','wp-travel-engine');?></li><br/>
				<li><?php _e('{booking_url} - The trip booking link','wp-travel-engine');?></li><br/>
				<li><?php _e('{ip_address} - The buyer\'s IP Address','wp-travel-engine');?></li><br/>
			</ul>
		</div>
	</div>

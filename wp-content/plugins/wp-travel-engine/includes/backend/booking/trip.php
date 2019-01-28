<?php
global $post;
$wp_travel_engine_postmeta_settings = get_post_meta( $post->ID, 'wp_travel_engine_booking_setting', true );
$wp_travel_engine_option_setting = get_option( 'wp_travel_engine_settings', true );
?>
<div class="trip-info-meta">
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][traveler]"><?php _e('Travelers: ','wp-travel-engine');?></label>	
	<input type="number" id="wp_travel_engine_booking_setting[place_order][traveler]" name="wp_travel_engine_booking_setting[place_order][traveler]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['traveler']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['traveler']):'';?>">
	</div>
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][cost]"><?php _e('Total Cost: ','wp-travel-engine');?><?php
	$code = 'USD';
    if( isset( $wp_travel_engine_option_setting['currency_code'] ) && $wp_travel_engine_option_setting['currency_code']!= '' )
    {
        $code = $wp_travel_engine_option_setting['currency_code'];
    } 
    $obj = new Wp_Travel_Engine_Functions();
    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
    echo esc_attr($currency);
    ?></label>	
	<input type="text" id="wp_travel_engine_booking_setting[place_order][cost]" name="wp_travel_engine_booking_setting[place_order][cost]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['cost']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['cost']):''?>">
	</div>
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][tid]"><?php _e('Remaining Payment: ','wp-travel-engine');echo esc_attr($currency);?></label>
	<input type="text" id="wp_travel_engine_booking_setting[place_order][due]" name="wp_travel_engine_booking_setting[place_order][due]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['due']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['due']):'-'?>">
	</div>
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][tid]"><?php _e('Trip ID: ','wp-travel-engine');?></label>	
	<input type="number" id="wp_travel_engine_booking_setting[place_order][tid]" name="wp_travel_engine_booking_setting[place_order][tid]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['tid']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['tid']):'';?>">
	</div>
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][tname]"><?php _e('Trip Name: ','wp-travel-engine');?></label>	
	<input type="text" id="wp_travel_engine_booking_setting[place_order][tname]" name="wp_travel_engine_booking_setting[place_order][tname]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['tname']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['tname']):'';?>">
	</div>
	<div>
	<label for="wp_travel_engine_booking_setting[place_order][datetime]"><?php _e('Trip Start Date: ','wp-travel-engine');?></label>
	<input type="text" class="wp-travel-engine-datetime" id="wp_travel_engine_booking_setting[place_order][datetime]" name="wp_travel_engine_booking_setting[place_order][datetime]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['datetime']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['datetime']):'';?>">
	</div>
	<?php
	if( isset( $wp_travel_engine_postmeta_settings['place_order']['booking']['survey'] ) && $wp_travel_engine_postmeta_settings['place_order']['booking']['survey']!= '' )
	{ ?>
		<div>
		<label for="wp_travel_engine_booking_setting[place_order][booking][survey]"><?php _e('Acquisition Method: ','wp-travel-engine');?></label>	
		<input type="text" id="wp_travel_engine_booking_setting[place_order][booking][survey]" name="wp_travel_engine_booking_setting[place_order][booking][survey]" value="<?php echo isset($wp_travel_engine_postmeta_settings['place_order']['booking']['survey']) ? esc_attr($wp_travel_engine_postmeta_settings['place_order']['booking']['survey']):'';?>">
		</div>
	<?php
	}
	?>
</div>
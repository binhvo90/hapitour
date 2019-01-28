<?php
global $post;
$wp_travel_engine_setting = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
?>
<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][pname]"><?php _e('Package Name','wp-travel-engine');?></label>
<a target="_blank" href="<?php echo esc_url( get_edit_post_link( $wp_travel_engine_setting['enquiry']['pname'], 'display' ) ); ?>"><?php   
	$postid = get_post( $wp_travel_engine_setting['enquiry']['pname'] );
	$slug = $postid->post_name; 
	echo esc_attr( $slug );
	?>
</a>
</div>
<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][name]"><?php _e('Name','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['name'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['name'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][name]" readonly> 
</div> 
<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][email]"><?php _e('Email','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['email'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['email'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][email]" readonly>
</div>

<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][country]"><?php _e('Country','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['country'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['country'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][country]" readonly>
</div>

<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][contact]"><?php _e('Contact Number','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['contact'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['contact'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][contact]" readonly>
</div>

<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][adults]"><?php _e('Number of Adults','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['adults'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['adults'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][adults]" readonly>  
</div>

<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][children]"><?php _e('Number of Children','wp-travel-engine');?></label>
<input type="text" value="<?php echo isset( $wp_travel_engine_setting['enquiry']['children'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['children'] ):'' ;?>" name="wp_travel_engine_setting[enquiry][children]" readonly>  
</div>

<div class="enquiry-row">
<label for="wp_travel_engine_setting[enquiry][message]"><?php _e('Message','wp-travel-engine');?></label>
<textarea name="wp_travel_engine_setting[enquiry][message]" readonly><?php echo isset( $wp_travel_engine_setting['enquiry']['message'] ) ? esc_attr( $wp_travel_engine_setting['enquiry']['message'] ):'' ;?></textarea>
</div>  
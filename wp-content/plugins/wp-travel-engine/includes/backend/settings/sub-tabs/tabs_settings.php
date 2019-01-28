<div class="wpte-row">
	<div class="tabs-inner">
		<ul class="tabs-accordion">
			<?php
			$wp_travel_engine_tabs = get_option( 'wp_travel_engine_settings' );
			if( isset( $wp_travel_engine_tabs['trip_tabs'] ) && !empty( $wp_travel_engine_tabs['trip_tabs'] ) )
			{
				$maxlen = max( array_keys( $wp_travel_engine_tabs['trip_tabs']['name'] ) );
				$arr_keys  = array_keys( $wp_travel_engine_tabs['trip_tabs']['name'] );
				foreach ($arr_keys as $key => $value)
				{ 
					$wp_travel_engine_tabs = get_option( 'wp_travel_engine_settings' ); 
					if ( array_key_exists( $value,$wp_travel_engine_tabs['trip_tabs']['name'] ) )
				  	{
					?>
						<li id="trip-tabs<?php echo esc_attr( $value );?>" data-id="<?php echo esc_attr( $value );?>" class="trip-row">
						<span class="tabs-handle"></span>
						<?php if($wp_travel_engine_tabs['trip_tabs']['id'][$value]!='1' && $wp_travel_engine_tabs['trip_tabs']['id'][$value]!='2' && $wp_travel_engine_tabs['trip_tabs']['id'][$value]!='3' && $wp_travel_engine_tabs['trip_tabs']['id'][$value]!='4')
						{ ?>
						 <i class="dashicons dashicons-no-alt delete-tab delete-icon" data-id="<?php echo $value;?>"></i>   
						<?php 
						}
						?> 
		              		<a class="accordion-tabs-toggle" href="javascript:void(0);"><div class="tabs-span-name"><?php echo ( isset($wp_travel_engine_tabs['trip_tabs']['name'][$value] ) ? esc_attr( $wp_travel_engine_tabs['trip_tabs']['name'][$value] ):'' ); ?></div><span class="dashicons dashicons-arrow-down custom-toggle-tabs"></span></a>
		              		<div class="tabs-content">
								<div class="tabs-id">
									<input type="hidden" class="trip-tabs-id" name="wp_travel_engine_settings[trip_tabs][id][<?php  echo $value;?>]" id="wp_travel_engine_settings[trip_tabs][id][<?php echo $value;?>]" 
									value="<?php echo ( isset($wp_travel_engine_tabs['trip_tabs']['id'][$value] ) ? esc_attr( $wp_travel_engine_tabs['trip_tabs']['id'][$value] ):'' ); ?>">
								</div>
								
								<div class="tabs-field">
									<input type="hidden" class="trip-tabs-id" name="wp_travel_engine_settings[trip_tabs][field][<?php  echo $value;?>]" id="wp_travel_engine_settings[trip_tabs][field][<?php echo $value;?>]" 
									value="<?php echo ( isset($wp_travel_engine_tabs['trip_tabs']['field'][$value] ) ? esc_attr( $wp_travel_engine_tabs['trip_tabs']['field'][$value] ):'' ); ?>">
								</div>

								<div class="tabs-name">
									<label for="wp_travel_engine_settings[trip_tabs][name][<?php echo $value;?>]"><?php _e( 'Tab Name:','wp-travel-engine' ); ?><span class="required">*</span></label>
									<input type="text" class="trip-tabs-name" name="wp_travel_engine_settings[trip_tabs][name][<?php echo $value;?>]" id="wp_travel_engine_settings[trip_tabs][name][<?php echo $value;?>]" 
									value="<?php echo ( isset($wp_travel_engine_tabs['trip_tabs']['name'][$value] ) ? esc_attr( $wp_travel_engine_tabs['trip_tabs']['name'][$value] ):'' ); ?>" required>
									<div class="settings-note"><?php _e( 'Tab Name is the label that appears on each of the tabs.', 'wp-travel-engine' ); ?></div>
								</div>
								<div class="tabs-icon">
									<label for="wp_travel_engine_settings[trip_tabs][icon][<?php echo $value;?>]"><?php _e( 'Tab Icon:','wp-travel-engine' ); ?></label>
									<input type="text" class="trip-tabs-icon" name="wp_travel_engine_settings[trip_tabs][icon][<?php echo $value;?>]" id="wp_travel_engine_settings[trip_tabs][icon][<?php echo $value;?>]" 
									value="<?php echo ( isset($wp_travel_engine_tabs['trip_tabs']['icon'][$value] ) ? esc_attr( $wp_travel_engine_tabs['trip_tabs']['icon'][$value] ):'' ); ?>">
									<div class="settings-note"><?php _e( 'Choose icon for the tab. Leave blank if no icon is required.', 'wp-travel-engine' ); ?></div>
								</div>
				 			</div>	
						</li>
			<?php 	} 
				}
			} 
			?>
		</ul>
	<span class="tabs-note"><?php _e( 'Press "Add Tab" to add Tabs...','wp-travel-engine' ); ?></span>
	<span id="writetrip"></span>
	</div>
</div>
<div id="add_remove_tabs">
	<?php
	$other_attributes = array( 'id' => 'add_remove_tab' );
	submit_button( 'Add Tab', '', '', true, $other_attributes ); ?>
</div>

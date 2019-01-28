<div class="wpte-row">	
	<ul class="fields-accordion">
		<?php $wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );
		if( isset( $wp_travel_engine_settings['trip_facts'] ) ) {
			$trip_facts = $wp_travel_engine_settings['trip_facts'];
			$arr_keys = array_keys( $trip_facts['field_id'] );
			$len = sizeof( $wp_travel_engine_settings['trip_facts']['field_id'] );
			$i=1;
			foreach ( $arr_keys as $key => $value ) { ?>		
				<li id="trip_facts_template-<?php echo $value;?>" data-id="<?php echo esc_attr($value);?>" class="trip_facts">
				 	<span class="handle"></span>
					<div class="form-builder">
						<div class="fid">
							<label for="wp_travel_engine_settings[trip_facts][fid][<?php echo $value;?>]"></label> 
							<input type="hidden" name="wp_travel_engine_settings[trip_facts][fid][<?php echo $value;?>]" value="<?php echo isset($wp_travel_engine_settings['trip_facts']['fid'][$value]) ? esc_attr( $wp_travel_engine_settings['trip_facts']['fid'][$value] ): '';?>" required>
						</div>
						<div class="field-id">
							<label for="wp_travel_engine_settings[trip_facts][field_id][<?php echo $value;?>]"><?php _e('Field Name:', 'wp-travel-engine');?><span class="required">*</span></label> 
							<input type="text" name="wp_travel_engine_settings[trip_facts][field_id][<?php echo $value;?>]" value="<?php echo isset($wp_travel_engine_settings['trip_facts']['field_id'][$value]) ? esc_attr( $wp_travel_engine_settings['trip_facts']['field_id'][$value] ): '';?>" required>
							<div class="settings-note"><?php _e( 'Field Name is the unique id of the input field.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="field-icon">
							<label for="wp_travel_engine_settings[trip_facts][field_icon][<?php echo $value;?>]"><?php _e('Field Icon:', 'wp-travel-engine');?></label> 
							<input class="trip-tabs-icon" type="text" name="wp_travel_engine_settings[trip_facts][field_icon][<?php echo $value;?>]" value="<?php echo isset($wp_travel_engine_settings['trip_facts']['field_icon'][$value]) ? esc_attr( $wp_travel_engine_settings['trip_facts']['field_icon'][$value] ): '';?>">
							<div class="settings-note"><?php _e( 'Choose icon for the tab. Leave blank if no icon is required.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="field-type">
							<label for="wp_travel_engine_settings[trip_facts][field_type][<?php echo $value;?>]"><?php _e('Field Type:', 'wp-travel-engine');?><span class="required">*</span></label>
							<select id="wp_travel_engine_settings[trip_facts][field_type][<?php echo $value;?>]" name="wp_travel_engine_settings[trip_facts][field_type][<?php echo $value;?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select">
									<option value=" "><?php _e( 'Choose input type&hellip;', 'wp-travel-engine' ); ?></option>
								<?php
									$obj = new Wp_Travel_Engine_Functions();
									$fields = $obj->trip_facts_field_options();
									$selected_field = esc_attr( $wp_travel_engine_settings['trip_facts']['field_type'][$value] );
									foreach ( $fields as $key => $val ) {
									echo '<option value="' .( !empty($key)?esc_attr( $key ):"Please select")  . '" ' . selected( $selected_field, $val, false ) . '>' . esc_html( $key ) . '</option>';
									}
								?>
							</select>
							<div class="settings-note"><?php _e( 'Field type is the input types.', 'wp-travel-engine' ); ?></div>
						</div>
						<div class="select-options">
							<label for="wp_travel_engine_settings[trip_facts][select_options][<?php echo $value;?>]"><?php _e('Select Options: ','wp-travel-engine');?><span class="required">*</span></label>
							<textarea id="wp_travel_engine_settings[trip_facts][select_options][<?php echo $value;?>]" name="wp_travel_engine_settings[trip_facts][select_options][<?php echo $value;?>]" rows="2" cols="25" required placeholder="<?php _e( 'Enter drop-down values separated by commas','wp-travel-engine' );?>"><?php echo isset( $wp_travel_engine_settings['trip_facts']['select_options'][$value] ) ? esc_attr( $wp_travel_engine_settings['trip_facts']['select_options'][$value] ): '';?></textarea>
						</div>
						<div class="input-placeholder">
						<label for="wp_travel_engine_settings[trip_facts][input_placeholder][<?php echo $value;?>]"><?php _e( 'Field Placeholder:','wp-travel-engine' );?></label> 
							<input type="text" name="wp_travel_engine_settings[trip_facts][input_placeholder][<?php echo $value;?>]" value="<?php echo isset( $wp_travel_engine_settings['trip_facts']['input_placeholder'][$value] ) ? esc_attr( $wp_travel_engine_settings['trip_facts']['input_placeholder'][$value] ): '';?>">
							<div class="settings-note"><?php _e( 'Placeholder for the input field.', 'wp-travel-engine' ); ?></div>
						</div>
					</div>
					<a href="#" class="del-li">X</a>
				</li>
			<?php
			$i++;
			}
		}
		?>
		<span class="fields-note"><?php _e( 'Press "Add Field" to add input fields...','wp-travel-engine' ); ?></span>
	<span id="writefacts"></span>
	</ul>	
</div>
<div id="add_remove_fields">
	<?php
	$other_attributes = array( 'id' => 'add_remove_field' );
	submit_button( 'Add Field', '', '', true, $other_attributes ); ?>
</div>
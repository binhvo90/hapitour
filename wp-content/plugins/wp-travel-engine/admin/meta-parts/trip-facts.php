<div id="trip-info">
	<div class="settings-note">
		<?php 
		global $post;
		$custom_id = $post->ID;
		_e('You can add, edit and delete the trip info via <b>Trips > Settings > Trip Info</b>.','wp-travel-engine');
		$page_shortcode = '<b>[Trip_Info_Shortcode id='."'".$custom_id."'".']</b>';
		$template_shortcode = "<b>&lt;?php echo do_shortcode('[Trip_Facts_Shortcode id=".$custom_id."]'); ?&gt;</b>";
		_e( sprintf('<br><b>Note:</b> You can use this shortcode %1$s to display Trip Info of this trip in posts/pages/tabs or use this snippet %2$s to display Trip Info in templates.',$page_shortcode, $template_shortcode),'wp-travel-engine'); 
		?>
	</div>
	<?php
	$wp_travel_engine_option_settings = get_option( 'wp_travel_engine_settings', true );
	$wp_travel_engine_postmeta_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
		if(isset( $wp_travel_engine_option_settings['trip_facts'])){
			$trip_facts = $wp_travel_engine_option_settings['trip_facts'];
			?>
			<select id="trip_facts" data-nonce="<?php echo wp_create_nonce('trip-info-nonce') ?>" name="trip_facts" data-placeholder="<?php esc_attr_e( 'Info Type&hellip;', 'wp-travel-engine' ); ?>">
				<option value=""><?php _e( 'Choose info type&hellip;', 'wp-travel-engine' ); ?></option>
				<?php
				foreach ($trip_facts['field_type'] as $key => $value) {
					$id = $wp_travel_engine_option_settings['trip_facts']['field_id'][$key];
					echo '<option value="' .esc_attr($id). '">' . esc_html( $id ) . '</option>';
				}
				?>
			</select>
			<input type="button" class="button button-small add-info" value="Add Trip Info">
				<div class="settings-note"><?php $bold_open = '<b>'; $bold_close = '</b>';
				 	_e( sprintf('Add Trip Info by choosing a field from the drop-down and then press the %1$s Add Trip Info %2$s button. The fields that are created in %3$s Trips > Settings > Trip Info %4$s will appear in the drop-down.', $bold_open, $bold_close, $bold_open, $bold_close), 'wp-travel-engine' ); ?>
				</div>
			<ul class="trip-info-list">
				<?php
			if(isset( $wp_travel_engine_postmeta_setting['trip_facts'] )){
				$wp_travel_engine_option_settings = get_option( 'wp_travel_engine_settings', true );
				foreach ($wp_travel_engine_postmeta_setting['trip_facts']['field_type'] as $key => $value) {
					if(isset($wp_travel_engine_option_settings['trip_facts']['fid'][$key]))
					{
					$id = $wp_travel_engine_option_settings['trip_facts']['field_id'][$key];?>
					<li class="trip_facts">
						<?php $icon = isset($wp_travel_engine_option_settings['trip_facts']['field_icon'][$key]) ? esc_attr( $wp_travel_engine_option_settings['trip_facts']['field_icon'][$key] ):'';
                            echo '<i class="'.$icon.'"></i>';
                         ?>
            			<a href="#" class="del-li">X</a>
					 	<span class="handle"></span>
						<?php
						switch ($value) {
							case 'select': 
								$options = $trip_facts['select_options'][$key];
								$options = explode( ',', $options );
								$selected_field = isset( $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key] ) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key] ):'';
								?>
								<label for="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]"><?php _e($id.': ','wp-travel-engine');?></label>
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id][<?php echo $key;?>]" value="<?php echo $id;?>">
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type][<?php echo $key;?>]" value="<?php echo $wp_travel_engine_option_settings['trip_facts']['field_type'][$key];?>"> 
								<select id="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" name="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
										<option value=" "><?php _e( 'Choose input type&hellip;', 'wp-travel-engine' ); ?></option>
										<?php
										foreach ( $options as $key => $val ) {
											echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '" ' . selected( $selected_field, $val, false ) . '>' . esc_html( $val ) . '</option>';
										}
										?>
								</select>		
							<?php
								break;
							case 'duration': ?>
							<label for="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]"><?php _e($id.': ','wp-travel-engine');?> </label>
							<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id][<?php echo $key;?>]" value="<?php echo $id;?>">
							<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type][<?php echo $key;?>]" value="<?php echo $wp_travel_engine_option_settings['trip_facts']['field_type'][$key];?>">
	    					<input type="number" min="1" placeholder = "<?php _e('Number of days','wp-travel-engine');?>" class="duration" id="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" name="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key] ): '';?>"/>
							<?php
							break;
							case 'number':?>
								<label for="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]"><?php _e($id.': ','wp-travel-engine');?></label>
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id][<?php echo $key;?>]" value="<?php echo $id;?>">
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type][<?php echo $key;?>]" value="<?php echo $wp_travel_engine_option_settings['trip_facts']['field_type'][$key];?>"> 
								<input  type="number" min="1" id="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" name="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key] ): '';?>" placeholder="<?php echo isset($trip_facts['input_placeholder'][$key]) ? esc_attr( $trip_facts['input_placeholder'][$key] ): '';?>" >
								<?php
								break;

							case 'text': ?>
								<label for="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]"><?php _e($id.': ','wp-travel-engine');?></label>
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id][<?php echo $key;?>]" value="<?php echo $id;?>">
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type][<?php echo $key;?>]" value="<?php echo $wp_travel_engine_option_settings['trip_facts']['field_type'][$key];?>"> 
								<input type="text" id="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" name="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key] ): '';?>" placeholder="<?php echo isset($trip_facts['input_placeholder'][$key]) ? esc_attr( $trip_facts['input_placeholder'][$key] ): '';?>">
								<?php
								break;
							
							case 'textarea':?>
								<label for="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]"><?php _e($id.': ','wp-travel-engine');?></label>
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_id][<?php echo $key;?>]" value="<?php echo $id;?>">
								<input type="hidden" name="wp_travel_engine_setting[trip_facts][field_type][<?php echo $key;?>]" value="<?php echo $wp_travel_engine_option_settings['trip_facts']['field_type'][$key];?>"> 
								<textarea id="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" name="wp_travel_engine_setting[trip_facts][<?php echo $key;?>][<?php echo $key;?>]" placeholder="<?php echo isset($trip_facts['input_placeholder'][$key]) ? $trip_facts['input_placeholder'][$key]: '';?>" ><?php echo isset($wp_travel_engine_postmeta_setting['trip_facts'][$key][$key]) ? $wp_travel_engine_postmeta_setting['trip_facts'][$key][$key]: '';?></textarea>

							<?php
								break;
						}
						?>
					</li>
				<?php
					}
				}
			}
				?>
				<div id="loader" style="display: none">
		        	<div class="table">
			    		<div class="table-row">
			    			<div class="table-cell">
			    				<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</ul>
	<?php
		} 
	?>
</div>

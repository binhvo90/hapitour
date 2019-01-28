<div class="settings-note">
	<?php 
	$bold_open = '<b>'; $bold_close = '</b>';
 	_e( sprintf('You can add, edit, delete and change order of the tabs via %1$s Trips > Settings > Trip Tab Settings %2$s.', $bold_open, $bold_close),'wp-travel-engine');?></div>
	<div class="tabs">
		<?php		
		global $post;
		add_filter('the_content', 'do_shortcode',10 );

			$wp_travel_engine_tab_settings = get_option( 'wp_travel_engine_settings' );
			if(isset(  $wp_travel_engine_tab_settings['trip_tabs'] ) && $wp_travel_engine_tab_settings['trip_tabs']!='' )  
			{
			$wp_travel_engine_tabs_id = $wp_travel_engine_tab_settings['trip_tabs']['id'];

				if( isset( $wp_travel_engine_tabs_id ) )
				{?>
				<ul class="itinerary-accordion">
					<?php	
					$obj = new Wp_Travel_Engine_Functions();
					$arr = array_keys( $wp_travel_engine_tab_settings['trip_tabs']['id'] );
					
					$count = 0;
					foreach( $arr as $tab=>$value ) { 
						if ( array_key_exists( $value, $wp_travel_engine_tabs_id ) )
						{ 
							$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
							$tab_name = $wp_travel_engine_tab_settings['trip_tabs']['name'][$value];
							$tab_tag = preg_replace( '/-/', ' ', $val );
							$val = $obj->wpte_clean( $val );
							if( $tab_tag!='' )
							{
							?>
							<li <?php if( $count==0 ){ ?>class="current"<?php } ?>><a href="<?php echo '#'.$val;?>"><?php echo $tab_name;?></a></li>
						<?php
							}
						}
						$count++;
					} ?>
				</ul>
					<?php
					$counter=0;
					$tab_settings = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
					if( isset( $tab_settings['tab_content'] ) )
					{
						$tab_settings = $tab_settings['tab_content'];
					}
					if( isset( $wp_travel_engine_tabs_id ) && $wp_travel_engine_tabs_id!='' )
					{
						foreach( $arr as $tab=>$value ) {  
							if( isset( $wp_travel_engine_tab_settings['trip_tabs']['id'][$value] ) && $wp_travel_engine_tab_settings['trip_tabs']['id'][$value]!='' )
							{ 
								switch( $wp_travel_engine_tab_settings['trip_tabs']['field'][$value] )
								{
									case 'wp_editor':
										$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
										$val = $obj->wpte_clean( $val );?>
									   	<div id="<?php echo $val;?>" class="tab-content" <?php if( $counter==0 ){ ?> style="display: block;" <?php } ?>>
											<?php
												$value_wysiwyg = '';
												$value = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
												if( isset( $tab_settings[$val.'_wpeditor'] ) )
												{
													$value_wysiwyg = $tab_settings[$val.'_wpeditor'];
												}
												$editor_id = $val.'_wpeditor';
												$settings = array( 'media_buttons' => true,'textarea_name' => 'wp_travel_engine_setting[tab_content]['.$editor_id.']' );
												wp_editor( html_entity_decode($value_wysiwyg), $editor_id, $settings );
											?> 
										</div>
									<?php
									break;

									case 'itinerary':
										$wp_travel_engine_tabs = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
										$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
										$val = $obj->wpte_clean( $val );?>
									   	<div id="<?php echo $val;?>" class="tab-content" <?php if( $counter==0 ){ ?> style="display: block;" <?php } ?>>
									   		<div class="expand-itinerary">
										   		<a href="#" class="expand-all-itinerary">
					                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
					                                <?php _e('Expand/Close', 'wp-travel-engine'); ?>
					                            </a>
				                        	</div>
											<?php
												if( isset( $wp_travel_engine_tabs['itinerary'] ) && !empty( $wp_travel_engine_tabs['itinerary']['itinerary_title'] ) )
												{
													$maxlen = max( array_keys( $wp_travel_engine_tabs['itinerary']['itinerary_title'] ) );
													$arr_keys  = array_keys( $wp_travel_engine_tabs['itinerary']['itinerary_title'] );
													foreach ($arr_keys as $key => $value)
													{ 
														if ( array_key_exists( $value,$wp_travel_engine_tabs['itinerary']['itinerary_title'] ) )
													  	{
														?>
														<li id="itinerary-tabs<?php echo esc_attr($value);?>" data-id="<?php echo esc_attr($value);?>" class="itinerary-row">
															<span class="tabs-handle"></span>
															<i class="dashicons dashicons-no-alt delete-faq delete-icon" data-id="<?php echo esc_attr($value);?>"></i>    
													        <a class="accordion-tabs-toggle" href="javascript:void(0);"><span class="dashicons dashicons-arrow-down custom-toggle-tabs"></span><span class="faq-count"><?php _e('Day-','wp-travel-engine');echo esc_attr($value);?></span></a>
													        <div class="itinerary-content">
																<div class="title">
																	<label for="wp_travel_engine_setting[itinerary][itinerary_title][<?php echo esc_attr($value);?>]"><?php _e('Itinerary Title:','wp-travel-engine'); ?></label>
																	<input type="text" class="itinerary-title" name="wp_travel_engine_setting[itinerary][itinerary_title][<?php echo esc_attr($value);?>]" id="wp_travel_engine_setting[itinerary][itinerary_title][<?php echo esc_attr($value);?>]" value="<?php echo ( isset($wp_travel_engine_tabs['itinerary']['itinerary_title'][$value] ) ? esc_attr( $wp_travel_engine_tabs['itinerary']['itinerary_title'][$value] ):'' ); ?>">
																</div>
																<div class="content">
																	<label for="wp_travel_engine_setting[itinerary][itinerary_content][<?php echo esc_attr($value);?>]"><?php _e('Itinerary Content:','wp-travel-engine'); ?></label>
																	<textarea rows="5" cols="32" class="itinerary-content" name="wp_travel_engine_setting[itinerary][itinerary_content][<?php echo esc_attr($value);?>]" id="wp_travel_engine_setting[itinerary][itinerary_content][<?php echo esc_attr($value);?>]"><?php echo ( isset($wp_travel_engine_tabs['itinerary']['itinerary_content'][$value] ) ? esc_attr( $wp_travel_engine_tabs['itinerary']['itinerary_content'][$value] ):'' ); ?></textarea>
																	<textarea rows="5" cols="32" class="itinerary-content-inner" name="wp_travel_engine_setting[itinerary][itinerary_content_inner][<?php echo esc_attr($value);?>]" id="wp_travel_engine_setting[itinerary][itinerary_content_inner][<?php echo esc_attr($value);?>]"><?php echo ( isset($wp_travel_engine_tabs['itinerary']['itinerary_content_inner'][$value] ) ? esc_attr( $wp_travel_engine_tabs['itinerary']['itinerary_content_inner'][$value] ):'' ); ?></textarea>
																</div>
															</div>	
														</li>
												<?php 	} 
													}
												} 
												?>
											<span id="itinerary-holder"></span>
											<input type="button" class="button button-small add-itinerary" value="<?php _e('Add Itinerary','wp-travel-engine');?>">
											<div class="settings-note"><?php _e( 'Add Itinerary for the trip days by pressing the above button. You can write title and description for each day.', 'wp-travel-engine' ); ?></div>

										</div>
									<?php
									break;

									case 'cost':
										$wp_travel_engine_tabs = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
										$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
										$val = $obj->wpte_clean( $val );?>
									   	<div id="<?php echo $val;?>" class="tab-content" <?php if( $counter==0 ){ ?> style="display: block;" <?php } ?>>
									   		<div class="content">
									   			<label for="wp_travel_engine_setting[cost][includes_title]"><?php _e('Title:','wp-travel-engine'); ?></label>
												<input type="text" class="includes_title" name="wp_travel_engine_setting[cost][includes_title]" id="wp_travel_engine_setting[cost][includes_title]" value="<?php echo ( isset($wp_travel_engine_tabs['cost']['includes_title'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['includes_title'] ):'' ); ?>">
												<p>
													<label for="cost_includes"><?php _e('Price Includes:','wp-travel-engine'); ?></label>
													<textarea rows="3" cols="25" name="wp_travel_engine_setting[cost][cost_includes]" id="cost_includes"><?php echo ( isset($wp_travel_engine_tabs['cost']['cost_includes'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['cost_includes'] ):''); ?></textarea>
													<textarea style="display: none;" rows="3" cols="25" name="wp_travel_engine_setting[cost][cost_includes_val]" id="include-result"><?php echo ( isset($wp_travel_engine_tabs['cost']['cost_includes_val'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['cost_includes_val'] ):''); ?></textarea>
												</p>
											</div>
											<div class="content">
												<label for="wp_travel_engine_setting[cost][excludes_title]"><?php _e('Title:','wp-travel-engine'); ?></label>
												<input type="text" class="excludes_title" name="wp_travel_engine_setting[cost][excludes_title]" id="wp_travel_engine_setting[cost][excludes_title]" value="<?php echo ( isset($wp_travel_engine_tabs['cost']['excludes_title'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['excludes_title'] ):'' ); ?>">
												<p>
												<label for="cost_excludes"><?php _e("Price doesn't Include:","wp-travel-engine"); ?></label>
												<textarea  rows="3" cols="25" name="wp_travel_engine_setting[cost][cost_excludes]" id="cost_excludes"><?php echo ( isset($wp_travel_engine_tabs['cost']['cost_excludes'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['cost_excludes'] ):''); ?></textarea>
												<textarea style="display: none;" rows="3" cols="25" name="wp_travel_engine_setting[cost][cost_excludes_val]" id="exclude-result"><?php echo ( isset($wp_travel_engine_tabs['cost']['cost_excludes_val'] ) ? esc_attr( $wp_travel_engine_tabs['cost']['cost_excludes_val'] ):''); ?></textarea>
												</p>
											</div>
									   	</div>
									   	<?php
									break;

									case 'faqs':
										$wp_travel_engine_tabs = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
										$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
										$val = $obj->wpte_clean( $val );?>
									   	<div id="<?php echo $val;?>" class="tab-content" <?php if( $counter==0 ){ ?> style="display: block;" <?php } ?>>
									   		<label for="wp_travel_engine_setting[faq][title]"><?php _e('Title:','wp-travel-engine'); ?></label>
											<input type="text" class="title" name="wp_travel_engine_setting[faq][title]" id="wp_travel_engine_setting[faq][title]" value="<?php echo ( isset($wp_travel_engine_tabs['faq']['title'] ) ? esc_attr( $wp_travel_engine_tabs['faq']['title'] ):'' ); ?>">
											<?php
												$wp_travel_engine_tabs = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
												if( isset( $wp_travel_engine_tabs['faq']['faq_title'] ) && !empty( $wp_travel_engine_tabs['faq']['faq_title'] ) )
												{
													$maxlen = max( array_keys( $wp_travel_engine_tabs['faq']['faq_title'] ) );
													$arr_keys  = array_keys( $wp_travel_engine_tabs['faq']['faq_title'] );
													foreach ($arr_keys as $key => $value)
													{ 
														if ( array_key_exists( $value,$wp_travel_engine_tabs['faq']['faq_title'] ) )
													  	{
														?>
														<li id="faq-tabs<?php echo esc_attr($value);?>" data-id="<?php echo esc_attr($value);?>" class="faq-row">
															<span class="tabs-handle"></span>
															<i class="dashicons dashicons-no-alt delete-faq delete-icon" data-id="<?php echo esc_attr($value);?>"></i>    
													        <a class="accordion-tabs-toggle" href="javascript:void(0);"><span class="dashicons dashicons-arrow-down custom-toggle-tabs"></span><span class="day-count"><?php _e('Faq-','wp-travel-engine');echo esc_attr($value);?></span></a>
													        <div class="faq-content">
																<div class="title">
																	<label for="wp_travel_engine_setting[faq][faq_title][<?php echo esc_attr($value);?>]"><?php _e('Question:','wp-travel-engine'); ?></label>
																	<input type="text" class="faq-title" name="wp_travel_engine_setting[faq][faq_title][<?php echo esc_attr($value);?>]" id="wp_travel_engine_setting[faq][faq_title][<?php echo esc_attr($value);?>]" value="<?php echo ( isset($wp_travel_engine_tabs['faq']['faq_title'][$value] ) ? esc_attr( $wp_travel_engine_tabs['faq']['faq_title'][$value] ):'' ); ?>">
																</div>
																<div class="content">
																	<label for="wp_travel_engine_setting[faq][faq_content][<?php echo esc_attr($value);?>]"><?php _e('Answer:','wp-travel-engine'); ?></label>
																	<textarea rows="3" cols="78" name="wp_travel_engine_setting[faq][faq_content][<?php echo esc_attr($value);?>]" id="wp_travel_engine_setting[faq][faq_content][<?php echo esc_attr($value);?>]"><?php echo ( isset($wp_travel_engine_tabs['faq']['faq_content'][$value] ) ? esc_attr( $wp_travel_engine_tabs['faq']['faq_content'][$value] ):'' ); ?></textarea>
																</div>
															</div>	
														</li>
												<?php 	} 
													}
												} 
												?>
											<span id="faq-holder"></span>
											<input type="button" class="button button-small add-faq" value="<?php _e('Add Faq','wp-travel-engine');?>">
											<div class="settings-note"><?php _e( 'Add Frequently Asked Questions for the trip by pressing the above button. You can write question and answer for each FAQs.', 'wp-travel-engine' ); ?></div>
										</div>
									<?php
									break;
									
									case 'review': 
										$wp_travel_engine_tabs = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
										$val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
										$val = $obj->wpte_clean( $val );?>
										<div id="<?php echo $val;?>" class="tab-content" <?php if( $counter==0 ){ ?> style="display: block;" <?php } ?>>
									   		<div class="content">
									   			<label for="wp_travel_engine_setting[review][review_title]"><?php _e('Review Title:','wp-travel-engine'); ?></label>
												<input type="text" class="review_title" name="wp_travel_engine_setting[review][review_title]" id="wp_travel_engine_setting[review][review_title]" value="<?php echo ( isset($wp_travel_engine_tabs['review']['review_title'] ) ? esc_attr( $wp_travel_engine_tabs['review']['review_title'] ):'' ); ?>">
											</div>
										</div>
									<?php	
									break;
								}
							}
							$counter++;
						}
					}
				}
			}
			?>
		</div>
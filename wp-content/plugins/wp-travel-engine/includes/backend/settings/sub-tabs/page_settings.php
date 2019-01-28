<div class="wpte-row">
	<div class="page-settings-inner">
		<div class="wp_travel_engine_settings_pages">
			<label for="wp_travel_engine_settings[pages][wp_travel_engine_place_order]"><?php _e( 'Checkout:','wp-travel-engine' ); ?><span class="required">*</span></label>
				<?php 
				$options = get_option('wp_travel_engine_settings', true);
				$wp_travel_engine_place_order = isset($options['pages']['wp_travel_engine_place_order']) ? esc_attr($options['pages']['wp_travel_engine_place_order']) : '';
			    wp_dropdown_pages(
			        array(
			             'name' => 'wp_travel_engine_settings[pages][wp_travel_engine_place_order]',
			             'echo' => 1,
			             'show_option_none' => __( '&mdash; Select &mdash;', 'wp-travel-engine' ),
			             'option_none_value' => '0',
			             'selected' => $wp_travel_engine_place_order,
			        )
			    );
			    ?>
		    <div class="settings-note"><?php _e('This is the checkout page where buyers will complete their order. The [WP_TRAVEL_ENGINE_PLACE_ORDER] shortcode must be on this page.','wp-travel-engine');?></div>
	    </div>
	    <div class="wp_travel_engine_settings_pages">
		    <label for="wp_travel_engine_settings[pages][wp_travel_engine_terms_and_conditions]"><?php _e( 'Terms and Conditions:','wp-travel-engine' ); ?><span class="required">*</span></label>
			    <?php
			    $wp_travel_engine_terms_conditions = isset($options['pages']['wp_travel_engine_terms_and_conditions']) ? esc_attr($options['pages']['wp_travel_engine_terms_and_conditions']) : '';
			    wp_dropdown_pages(
			        array(
			             'name' => 'wp_travel_engine_settings[pages][wp_travel_engine_terms_and_conditions]',
			             'echo' => 1,
			             'show_option_none' => __( '&mdash; Select &mdash;', 'wp-travel-engine' ),
			             'option_none_value' => '0',
			             'selected' => $wp_travel_engine_terms_conditions,
			        )
			    );
			    ?>
		    <div class="settings-note"><?php _e('This is the terms and conditions page where trip bookers will see the terms and conditions for booking.','wp-travel-engine');?></div>
		</div>
	    <div class="wp_travel_engine_settings_pages">
		    <label for="wp_travel_engine_settings[pages][wp_travel_engine_thank_you]"><?php _e( 'Thank You:','wp-travel-engine' ); ?><span class="required">*</span></label>
			    <?php
			    $wp_travel_engine_thank_you = isset($options['pages']['wp_travel_engine_thank_you']) ? esc_attr($options['pages']['wp_travel_engine_thank_you']) : '';
			    wp_dropdown_pages(
			        array(
			             'name' => 'wp_travel_engine_settings[pages][wp_travel_engine_thank_you]',
			             'echo' => 1,
			             'show_option_none' => __( '&mdash; Select &mdash;', 'wp-travel-engine' ),
			             'option_none_value' => '0',
			             'selected' => $wp_travel_engine_thank_you,
			        )
			    );
				?>
		    <div class="settings-note"><?php _e('This is the thank you page where trip bookers will get the payment confirmation message. The [WP_TRAVEL_ENGINE_THANK_YOU] shortcode must be on this page.','wp-travel-engine');?></div>
		</div>

		<div class="wp_travel_engine_settings_pages">
		    <label for="wp_travel_engine_settings[pages][wp_travel_engine_confirmation]"><?php _e( 'Confirmation Page:','wp-travel-engine' ); ?><span class="required">*</span></label>
			    <?php
			    $wp_travel_engine_confirmation = isset($options['pages']['wp_travel_engine_confirmation_page']) ? esc_attr($options['pages']['wp_travel_engine_confirmation_page']) : '';
			    wp_dropdown_pages(
			        array(
			             'name' => 'wp_travel_engine_settings[pages][wp_travel_engine_confirmation_page]',
			             'echo' => 1,
			             'show_option_none' => __( '&mdash; Select &mdash;', 'wp-travel-engine' ),
			             'option_none_value' => '0',
			             'selected' => $wp_travel_engine_confirmation,
			        )
			    );
				?>
		    <div class="settings-note"><?php _e('This is the confirmation page where trip bookers will fill the full form of the travelers. The [WP_TRAVEL_ENGINE_BOOK_CONFIRMATION] shortcode must be on this page.','wp-travel-engine');?></div>
		</div>
	<?php do_action( 'wte_advanced_search_page' ); ?>

	</div>
</div>
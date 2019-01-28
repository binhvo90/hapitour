<?php
    /**
    * General Sub-tabs.
    *
    * @since    1.0.0
    */
    function wp_travel_engine_settings_email_subtabs() {
        $options[] = array(
            'email_settings'   	   => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/email_settings.php',
            'purchase_receipt'     => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/purchase_receipt.php',
            'booking_notification' => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/book_notification.php',
            );
        $options[] = apply_filters_ref_array( 'wp_travel_engine_settings_email_sub_tabs', $options );
        return $options;
    }
    ?>
    <div class="email-content clearfix" name="1">
        <div class="email-custom">
        	<ul>
        	   	<?php $args = wp_travel_engine_settings_email_subtabs();
        	   	$args = array_map( "unserialize", array_unique( array_map( "serialize", $args ) ) );
        	   	foreach ( $args as $key ) { 
                    foreach ( $key as $k=>$val ){ ?>
               			<li><a href="#<?php echo $k;?>"><?php $k = str_replace('_', ' ', $k); echo $k;?></a></li>
        	   		<?php	
        			}  
        	   	} ?>
            </ul>
            <?php
            foreach ( $args as $key ) { 
        	   	foreach ( $key as $k=>$val ){ ?>
	        		<div id = "<?php echo $k;?>">
			        	<?php
							include $val;
						?>	
	        		</div>
	        	<?php }
			} ?>
		</div>
	</div>	
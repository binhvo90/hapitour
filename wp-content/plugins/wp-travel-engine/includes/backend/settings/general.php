<?php
    /**
    * General Sub-tabs.
    *
    * @since    1.0.0
    */
    function wp_travel_engine_settings_general_subtabs() {
        $options[] = array(
            'page_settings'        => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/page_settings.php',
            'trip_tabs_settings'   => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/tabs_settings.php',
            'trip_info'           => WP_TRAVEL_ENGINE_BASE_PATH.'/includes/backend/settings/sub-tabs/trip_info.php'
            );
        $options[] = apply_filters( 'wp_travel_engine_settings_general_sub_tabs', $options );
        return $options;
    }
    ?>
    <div class="accordion-content clearfix" name="1">
        <div class="tabs-custom">
        	<ul>
        	   	<?php 
                $args = wp_travel_engine_settings_general_subtabs();
        	   	foreach ( $args[1] as $key ) { 
                    foreach ( $key as $k=>$val ){ ?>
               			<li><a href="#<?php echo $k;?>"><?php $k = str_replace('_', ' ', $k); echo $k;?></a></li>
        	   		<?php	
        			}  
        	   	} ?>
            </ul>
            <?php
            foreach ( $args[1] as $key ) { 
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
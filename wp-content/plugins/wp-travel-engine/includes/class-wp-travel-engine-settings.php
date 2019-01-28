<?php

/**
 * Settings section of the plugin.
 *
 * Maintain a list of functions that are used for settings purposes of the plugin
 *
 * @package    WP Travel Engine
 * @subpackage WP_Travel_Engine/includes
 * @author    code wing
 */
class Wp_Travel_Engine_Settings {

	/**
	* Settings Tabs.
	*
	* @since    1.0.0
	*/
	function wp_travel_engine_settings_options() {

        $options = array(
            'general'           => 'general.php',
            'emails'            => 'emails.php',
            'misc'            	=> 'misc.php',
            'payment'			=> 'payment.php',
            'extensions'		=> 'extensions.php',
            'license'		=> 'license.php'
            );
        $options = apply_filters( 'wp_travel_engine_settings_option_tabs', $options );
        return $options;
    }


	/**
	* Settings panel of the plugin.
	*
	* @since    1.0.0
	*/
	function wp_travel_engine_backend_settings(){ 
		if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ==true )
		{
			echo '<div id="message" class="updated inline"><p><strong>'.__('Your settings have been saved.','wp-travel-engine').'</strong></p></div>';
		}
		?>
		<div id="tabs-container">
		    <ul class="tabs-menu">
			<?php
			$settings_tab = $this->wp_travel_engine_settings_options();
				$count = 0;
				foreach ($settings_tab as $key => $value) { 
					$tab_label = preg_replace('/_/', ' ', $key);
					?>
		        	<li <?php if($count==0){ ?>class="current"<?php } ?>><a href="<?php echo $key;?>"><?php echo $tab_label;?></a></li>
		        <?php $count++;
		        } ?>
		    </ul>
		    <div class="tab">
				<form method="POST" name="form1" action="options.php" id="form1">			
			        <?php
				    settings_fields( 'wp_travel_engine_settings' );
					do_settings_sections( __FILE__ );
					$option = get_option( 'wp_travel_engine_settings' );

					if ( empty( $option ) ) {
						$option = array();
					}

					$plugin_common = new Wp_Travel_Engine_Functions();

					if(isset($option['currency_code']))
					{
						$currency = $option['currency_code'];
					}
				
			        $counter = 0; 
			        foreach ($settings_tab as $key => $value) { ?>
			        <div id="<?php echo $key;?>" class="tab-content" <?php if($counter==0){ ?> style="display: block;" <?php } ?>>
			           	<?php	
							include_once WP_TRAVEL_ENGINE_BASE_PATH . '/includes/backend/settings/'.$value;
			        	?>
			        </div>
			        <?php $counter++; } ?>
			        <div class="wpte-settings-submit">
			        	<?php echo submit_button();?>
			        </div>
		        </form>
		    </div>
		</div>
	<?php 
	}
}

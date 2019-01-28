<?php
    global $post;
    $facts = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
    $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
    $wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true);
    if( isset($facts['trip_facts']) && $facts['trip_facts']!='' ):
        $trip_facts  = $facts['trip_facts'];
        if( isset( $wp_travel_engine_setting['trip_facts'] ) && $wp_travel_engine_setting['trip_facts']!='' && isset( $trip_facts['field_type'] ) && $trip_facts['field_type']!='' && isset($wp_travel_engine_setting_option_setting['trip_facts']['field_id']) )
        {
        ?>
            <div class="secondary-trip-info">
                <?php
                $i = 0; 
                foreach ($trip_facts['field_type'] as $key => $value) {
                    if(isset($wp_travel_engine_setting_option_setting['trip_facts']['field_id'][$key]))
                    {
                        $id = $wp_travel_engine_setting_option_setting['trip_facts']['field_id'][$key];
                        if( isset( $wp_travel_engine_setting['trip_facts'][$key][$key] ) && $wp_travel_engine_setting['trip_facts'][$key][$key]!='' )
                        {
                            $i =1;
                        }
                    }
                }
                if($i==1): ?>
                    <div class="wte-trip-facts">
                        <h2 class="widget-title">
                            <?php $trip_facts_title = __( 'Trip Facts','wp-travel-engine' );  echo apply_filters('wp_travel_engine_trip_facts_title', $trip_facts_title);?>
                        </h2> 
                        <ul  class="trip-facts-value">
                            <?php
                             foreach ($trip_facts['field_type'] as $key => $value) {
                                if(isset($wp_travel_engine_setting_option_setting['trip_facts']['fid'][$key]) && isset($wp_travel_engine_setting_option_setting['trip_facts']['field_id'][$key]))
                                {
                                    $id = $wp_travel_engine_setting_option_setting['trip_facts']['field_id'][$key]; 
                                    if( isset( $wp_travel_engine_setting['trip_facts'][$key][$key] ) && !empty( $wp_travel_engine_setting['trip_facts'][$key][$key] ) ) {
                                        $icon = isset($wp_travel_engine_setting_option_setting['trip_facts']['field_icon'][$key]) ? esc_attr( $wp_travel_engine_setting_option_setting['trip_facts']['field_icon'][$key] ):'';
                                        echo '<li><i class="'.$icon.'"></i>';
                                            switch ($value) {
                                                case 'select': 
                                                    $options = $trip_facts['select_options'][$key];
                                                    $options = explode( ',', $options );
                                                    $selected_field = isset( $wp_travel_engine_setting['trip_facts'][$key][$key] ) ? esc_attr( $wp_travel_engine_setting['trip_facts'][$key][$key] ):'';
                                                    ?>
                                                    <div class="trip-facts-select">
                                                        <label>
                                                            <?php _e($id.': ','wp-travel-engine');?>
                                                        </label>
                                                        <div class="value"><?php echo esc_attr( $selected_field ); ?></div>
                                                    </div>
                                                <?php
                                                break;
                                            
                                                case 'number':?>
                                                    <div class="trip-facts-number">
                                                        <label>
                                                            <?php _e($id.': ','wp-travel-engine');?>
                                                        </label>
                                                        <div class="value"><?php echo isset($wp_travel_engine_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_setting['trip_facts'][$key][$key] ): '';?></div>
                                                    </div>
                                                <?php
                                                break;
                                                
                                                case 'text':?>
                                                    <div class="trip-facts-text">
                                                        <label>
                                                            <?php _e($id.': ','wp-travel-engine');?>
                                                        </label>
                                                        <div class="value"><?php echo isset($wp_travel_engine_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_setting['trip_facts'][$key][$key] ): '';?></div>
                                                    </div>
                                                <?php
                                                break;
                                                
                                                case 'duration':?>
                                                    <div class="trip-facts-text">
                                                        <label>
                                                            <?php _e($id.': ','wp-travel-engine');?>
                                                        </label>
                                                        <div class="value"><?php if( isset($wp_travel_engine_setting['trip_facts'][$key][$key] ) && $wp_travel_engine_setting['trip_facts'][$key][$key]!='' ){ echo isset($wp_travel_engine_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_setting['trip_facts'][$key][$key] ): ''; if( $wp_travel_engine_setting['trip_facts'][$key][$key]>1 ){ _e(' days','wp-travel-engine');} else{ _e(' day','wp-travel-engine');} }?></div>
                                                    </div>
                                                <?php
                                                break;
                                                
                                                case 'textarea':?>
                                                    <div class="trip-facts-textarea">
                                                        <label>
                                                            <?php echo $id ;?>
                                                        </label>
                                                        <div class="value"><?php echo isset($wp_travel_engine_setting['trip_facts'][$key][$key]) ? esc_attr( $wp_travel_engine_setting['trip_facts'][$key][$key] ): '';?></div>
                                                    </div>
                                                <?php
                                                break;
                                            }
                                        echo '</li>';
                                    }
                                }
                                ?>
                            <?php
                             }
                             ?>
                        </ul>
                    </div>
                <?php
                    endif;
                ?>
            </div>
        <?php   
        }
    endif;
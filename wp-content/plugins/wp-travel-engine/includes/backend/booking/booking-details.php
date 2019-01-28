<?php
    global $post;
    $wp_travel_engine_settings = get_post_meta( $post->ID, 'wp_travel_engine_booking_setting', true );
    $pno = $wp_travel_engine_settings['place_order']['traveler'];
    $billing_options  = $wp_travel_engine_settings['place_order'];
?>
<div class="wp-travel-engine-billing-details">
    <div class="wp-travel-engine-billing-details-wrapper">
        <div class="bookers-profile">
            <?php
            $cid = get_page_by_title( $wp_travel_engine_settings['place_order']['booking']['email'], OBJECT, 'customer' );?>
               <label><?php _e('Customer ID: ','wp-travel-engine');?><a target="_blank" href="<?php echo esc_url( get_edit_post_link( $cid->ID, 'display' ) ); ?>"><?php echo esc_attr( $cid->ID );?></a></label> 
        </div>
        <?php
        foreach ($billing_options['booking'] as $key => $value) { ?>
        <div class='wp-travel-engine-billing-details-field-wrap'>
                <?php
                switch ($key) {

                    case 'title':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Title','wp-travel-engine');?></label>
                    <select id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]">
                    <option value=" "><?php _e( 'Please choose&hellip;', 'wp-travel-engine' ); ?></option>
                    <?php
                    $obj = new Wp_Travel_Engine_Functions();
                    $options = $obj->order_form_title_options();
                    $title = $billing_options['booking']['title'];
                        foreach ( $options as $key => $val ) {
                            echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '"' . selected( $title, $val, false ) . '>' . esc_html( $val ) . '</option>';
                        }
                    ?>  
                    </select>
                    <?php
                    break;
                    case 'fname':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('First Name','wp-travel-engine');?></label>
                    <input type="text" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]">    
                    <?php
                    break;

                    case 'lname':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Last Name','wp-travel-engine');?></label>
                    <input type="text" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;

                    case 'email':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Email','wp-travel-engine');?></label>
                    <input type="email" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;

                    case 'address':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Address','wp-travel-engine');?></label>
                    <input type="text" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;

                    case 'city':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('City','wp-travel-engine');?></label>
                    <input type="text" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;

                    case 'country':?>
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Country','wp-travel-engine');?></label>
                    <select required id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
                            <option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>
                            <?php
                            $obj = new Wp_Travel_Engine_Functions();
                            $options = $obj->wp_travel_engine_country_list();
                            foreach ( $options as $key => $val ) {
                                echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '"' . selected( $value, $val, false ) . '>' . esc_html( $val ) . '</option>';
                            }
                            ?>
                    </select>
                    <?php
                    break;  

                    case 'postcode':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Post-code','wp-travel-engine');?></label>
                    <input type="number" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;

                    case 'phone':?> 
                    <label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e('Phone','wp-travel-engine');?></label>
                    <input type="tel" value="<?php echo isset( $value ) ? esc_attr( $value ):'' ;?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" >    
                    <?php
                    break;
                }
            ?>
        </div>
        <?php } ?>
    </div>
</div>
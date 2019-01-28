<?php
    global $post;
    $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
    $wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true);
    
    if(isset($wp_travel_engine_setting_option_setting['booking']))
        return;

    $obj = new Wp_Travel_Engine_Functions(); 
        $cost = isset( $wp_travel_engine_setting['trip_price'] ) ? $wp_travel_engine_setting['trip_price']: '';
        if(isset( $wp_travel_engine_setting['trip_prev_price'] ) && $wp_travel_engine_setting['trip_prev_price']!='' || isset($wp_travel_engine_setting['trip_price'] ) && $wp_travel_engine_setting['trip_price']!='' )
        { ?>
        <div class="secondary-trip-info trip-price">
            <div class="price-holder">
                <?php do_action( 'wp_travel_engine_before_price_info' ); ?>
                <div class="top-price-holder">
                    <span class="price-from"><?php $price_info = __( 'Price From','wp-travel-engine' ); 
                    echo apply_filters( 'wp_travel_engine_price_info', $price_info );?></span>
                    <strong class="prev-price">
                        <?php
                        $code = 'USD';
                        if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
                        {
                            $code = $wp_travel_engine_setting_option_setting['currency_code'];
                        } 
                        $obj = new Wp_Travel_Engine_Functions();
                        $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                        $prev_cost = isset($wp_travel_engine_setting['trip_prev_price']) ? $wp_travel_engine_setting['trip_prev_price']: '';
                        $person_format = isset($wp_travel_engine_setting_option_setting['person_format']) ? $wp_travel_engine_setting_option_setting['person_format']:'/person';
                        if( $cost!='' && isset($wp_travel_engine_setting['sale']) )
                        {
                            if($prev_cost!='')
                            {
                                $obj = new Wp_Travel_Engine_Functions();
                                echo "<strike style='color:red'>";
                                echo "<span class='currency-code'>".esc_attr($code).'</span><span class="currency">'.esc_attr($currency).'</span>';
                                echo '<span class="trip-cost">'.$obj->wp_travel_engine_price_format($prev_cost).'</span>';
                                echo '</strike>';
                            }
                            ?>
                            <strong class="price">
                                <?php
                                    $actual_price = $cost;
                                    $obj = new Wp_Travel_Engine_Functions();
                                    echo '<span class="currency-code">'.esc_attr( ' '.$code ).'</span>';
                                    echo '<span class="currency">'.esc_attr($currency).'</span>';
                                    echo '<strong class="trip-cost-holder">'.esc_attr( $obj->wp_travel_engine_price_format($cost) ).'</strong>';
                                    echo '<span class="per-person">'.$person_format.'</span>';
                                ?>
                            </strong>
                        <?php
                        }
                        else{ ?>
                            <strong class="price">
                                <?php
                                    $actual_price = $wp_travel_engine_setting['trip_prev_price'];
                                    $obj = new Wp_Travel_Engine_Functions();
                                    echo '<span class="currency-code">'.esc_attr( ' '.$code ).'</span>';
                                    echo '<span class="currency">'.esc_attr($currency).'</span>';
                                    echo '<strong class="trip-cost-holder">'.esc_attr( $obj->wp_travel_engine_price_format($wp_travel_engine_setting['trip_prev_price']) ).'</strong>';
                                    echo '<span class="per-person">'.$person_format.'</span>';
                                ?>
                            </strong>
                        <?php
                        }
                        ?>
                    </strong>
                    <?php do_action( 'wp_travel_engine_group_discount_info' );?>
                </div>
                <?php do_action( 'wp_travel_engine_after_price_info' );?>
                <?php
                $options = get_option('wp_travel_engine_settings', true);
                $wp_travel_engine_placeorder = isset($options['pages']['wp_travel_engine_place_order']) ? esc_attr($options['pages']['wp_travel_engine_place_order']) : '';
                ?>
                <?php
                do_action( 'wp_travel_engine_before_price_form' ); ?>
                <form method="POST" action="<?php echo esc_url( get_permalink( $wp_travel_engine_placeorder ) );?>">
                    <?php do_action('wp_travel_engine_group_discount_guide'); ?>
                    <label>
                    <?php $no_of_travelers = __('Number of Adult Travelers: ','wp-travel-engine'); 
                    echo apply_filters('wp_travel_engine_no_of_travelers_text', $no_of_travelers);?>
                    <input type="number" min="1" name="travelers" class="travelers-no" value="1" required></label>
                    <?php 
                    if( class_exists('Wp_Travel_Engine_Group_Discount') && isset( $wp_travel_engine_setting['child-group']['discount'] ) && isset( $wp_travel_engine_setting_option_setting['group']['discount'] ) )
                    {
                        do_action('wpte_child_field',$post); 
                    }
                    ?> 
                    <div class="date-time-wrapper">
                        <input type="text" min="1" autocomplete="off" class="wp-travel-engine-price-datetime" id="wp-travel-engine-trip-datetime" name="trip-date" placeholder="<?php _e('Pick a date','wp-travel-engine');?>">
                    </div>
                    <?php 
                    if( class_exists( 'Wp_Travel_Engine_Group_Discount' ) && isset( $wp_travel_engine_setting['group']['discount'] ) && isset( $wp_travel_engine_setting_option_setting['group']['discount'] ) ){
                        echo '<div class="discount-price-per-traveler">'.__('Cost Per Adult Traveler: ','wp-travel-engine').'<span class="currency">'.$currency.' </span><span class="discount-price-traveler">'.$actual_price.'</span><span class="currency-code">'.$code.'</span></div>';
                        echo '<div class="discount-price-per-child-traveler">'.__('Cost Per Child Traveler: ','wp-travel-engine').'<span class="currency">'.$currency.' </span><span class="discount-price-child-traveler">'.$actual_price.'</span><span class="currency-code">'.$code.'</span></div>';  
                    } ?>
                    <input type="hidden" min="1" id="travelers" name="trip-id" value="<?php echo $post->ID;?>">
                    <?php
                    $nonce = wp_create_nonce('wp_travel_engine_booking_nonce');
                    ?>
                    <input type="hidden" id="nonce" name="nonce" value="<?php echo $nonce;?>">
                    <?php
                    if( $cost!='' && isset($wp_travel_engine_setting['sale']) )
                    { ?>
                        <span class="hidden-price"><?php echo $obj->wp_travel_engine_price_format($cost); ?></span>
                        <div class="total-amt"><b><?php _e('Total','wp-travel-engine');?></b>
                            <?php echo '<span class="currency">'.esc_attr($currency).'</span>'.' ';?><span class="total"><?php echo $obj->wp_travel_engine_price_format($cost);?></span><?php echo ' '.'<span class="currency-code">'.esc_attr( $code ).'</span>';?>
                        </div>
                    <?php } 
                    else{ ?>
                        <span class="hidden-price"><?php echo $obj->wp_travel_engine_price_format($prev_cost); ?></span>
                        <div class="total-amt"><b><?php _e('Total','wp-travel-engine');?></b>
                            <?php echo '<span class="currency">'.esc_attr($currency).'</span>'.' ';?><span class="total"><?php echo $obj->wp_travel_engine_price_format($prev_cost);?></span><?php echo ' '.'<span class="currency-code">'.esc_attr( $code ).'</span>';?>
                        </div>
                    <?php } ?>
                    <?php
                    if( $cost!='' && isset($wp_travel_engine_setting['sale']) )
                    { ?>
                        <input type="hidden" id="trip-cost" name="trip-cost" value="<?php echo esc_attr($cost);?>"> 
                    <?php } 
                    else{ ?>
                        <input type="hidden" id="trip-cost" name="trip-cost" value="<?php echo esc_attr($prev_cost);?>"> 
                    <?php } ?>
                    <input type="hidden" name="fdd-id" class="fdd-id" value="">
                    <button class="check-availability"><?php $button_txt =  __('Check Availability','wp-travel-engine'); echo apply_filters( 'wp_travel_engine_check_availability_button_text', $button_txt );?></button>
                    <?php 
                    $btn_txt = __('Book Now','wp-travel-engine');
                    if( isset( $wp_travel_engine_setting_option_setting['book_btn_txt'] ) && $wp_travel_engine_setting_option_setting['book_btn_txt']!='')
                    {
                        $btn_txt = $wp_travel_engine_setting_option_setting['book_btn_txt'];
                    } ?>
                    <input type="submit" class="book-submit" value="<?php echo esc_attr( $btn_txt ); ?>">
                </form>
                <?php
                do_action( 'wp_travel_engine_after_price_form' ); ?>
            <div id="price-loading"><div id="price-loading-wrap"><div id="price-loading-outer"><div id="price-loading-inner"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div></div></div></div>
            </div>
        </div>
        <?php } 
        do_action('wte_quick_enquiry');
        do_action('wte_up_sell');
        
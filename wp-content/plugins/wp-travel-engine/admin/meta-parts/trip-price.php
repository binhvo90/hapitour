<div id="general">
<?php
global $post;
$wp_travel_engine_postmeta_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true );
?>
<div class="trip-prev-price">
    <label for="wp_travel_engine_setting[trip_prev_price]"><?php _e('Regular Price : ','wp-travel-engine');?><?php
    $code = 'USD';
    if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
    {
        $code = $wp_travel_engine_settings['currency_code'];
    } 
    $obj = new Wp_Travel_Engine_Functions();
    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
    echo esc_attr($currency);
    ?></label> 
    <input type="text" id="wp_travel_engine_setting[trip_prev_price]" name="wp_travel_engine_setting[trip_prev_price]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_prev_price']) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_prev_price'] ): '';?>" placeholder="<?php _e('Regular Price for the trip','wp-travel-engine');?>">
</div>
<div class="sale-price">
    <label for="wp_travel_engine_setting[sale]"><?php _e('Enable Sale Price:','wp-travel-engine') ?></label>
    <input type="checkbox" class="wp-travel-engine-setting-sale" id="wp_travel_engine_setting[sale]" name="wp_travel_engine_setting[sale]" value="1" <?php if(isset($wp_travel_engine_postmeta_setting['sale']) && $wp_travel_engine_postmeta_setting['sale']!='' ) echo 'checked'; ?>>
</div>
<div class="trip-price">
    <label for="wp_travel_engine_setting[trip_price]"><?php _e('Sales Price : ','wp-travel-engine');?><?php
    $code = 'USD';
    if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
    {
        $code = $wp_travel_engine_settings['currency_code'];
    } 
    $obj = new Wp_Travel_Engine_Functions();
    $currency = $obj->wp_travel_engine_currencies_symbol( $code );
    echo esc_attr($currency);
    ?></label> 
    <input type="text" id="wp_travel_engine_setting[trip_price]" name="wp_travel_engine_setting[trip_price]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_price']) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_price'] ): '';?>" placeholder="<?php _e('Price for the trip','wp-travel-engine');?>">
</div>

<?php echo do_action('wpte_partial_payment_add_meta_boxes'); ?>

<div class="trip-duration">
    <label for="wp_travel_engine_setting[trip_duration]"><?php _e('Trip Duration (Days) : ','wp-travel-engine');?></label> 
    <input type="number" id="wp_travel_engine_setting[trip_duration]" name="wp_travel_engine_setting[trip_duration]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_duration']) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_duration'] ): '';?>" placeholder="<?php _e('Number of days','wp-travel-engine');?>">
</div>
<div class="trip-duration">
    <label for="wp_travel_engine_setting[trip_duration_nights]"><?php _e('Trip Duration (Nights) : ','wp-travel-engine');?></label> 
    <input type="number" id="wp_travel_engine_setting[trip_duration_nights]" name="wp_travel_engine_setting[trip_duration_nights]" value="<?php echo isset($wp_travel_engine_postmeta_setting['trip_duration_nights']) ? esc_attr( $wp_travel_engine_postmeta_setting['trip_duration_nights'] ): '';?>" placeholder="<?php _e('Number of nights','wp-travel-engine');?>">
</div>
    <?php echo do_action('wpte_child_discount_add_meta_boxes'); ?>
    <?php echo do_action('wp_travel_engine_trip_group_discount'); ?>
</div>

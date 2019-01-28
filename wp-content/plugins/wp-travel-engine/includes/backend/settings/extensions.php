<?php
do_action( 'wte_fixed_departure_dates_settings' );
if( class_exists('WTE_Fixed_Starting_Dates') ){
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true ); 
?>
<div class="wp-travel-engine-fields-settings">
    <h3>Number of Dates </h3>
    <label for="wp_travel_engine_settings[trip_dates][number]"><?php _e('Number of Trip Dates: ','wp-travel-engine');?></label>
    <input type="number" id="wp_travel_engine_settings[trip_dates][number]" name="wp_travel_engine_settings[trip_dates][number]" value="<?php echo isset($wp_travel_engine_settings['trip_dates']['number']) ? $wp_travel_engine_settings['trip_dates']['number']:3; ?>">
</div>
<?php
}
do_action( 'mailchimp_settings' );
do_action( 'mailerlite_settings' );
do_action( 'convertkit_settings' );
do_action( 'wp_travel_engine_group_discount' );
do_action( 'wp_travel_engine_search_fields' );
do_action( 'wte_partial_payment_enable' );
do_action( 'wte_partial_payment_settings' );
do_action( 'wte_variable_pricing_enable' );
do_action( 'wte_variable_pricing_settings' );
do_action( 'wp_travel_engine_trip_review_form' );
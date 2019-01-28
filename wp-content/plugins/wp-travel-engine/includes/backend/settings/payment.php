<?php
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true ); 
?>
<h3><?php _e('Enable Payment Gateways','wp-travel-engine');?></h3>
<div class="wp-travel-engine-settings">
	<label for="wp_travel_engine_settings[test_payment]"><?php _e('Test Payment : ','wp-travel-engine');?></label>
	<input type="checkbox" id="wp_travel_engine_settings[test_payment]" name="wp_travel_engine_settings[test_payment]" value="1" <?php if(isset($wp_travel_engine_settings['test_payment']) && $wp_travel_engine_settings['test_payment']!='' ) echo 'checked'; ?>>
	<div class="settings-note"><?php _e( 'If checked, payment gateways will be disabled and booking will be done on a test mode. However, booking email will be received and booking will be successfully completed.', 'wp-travel-engine' ); ?></div>
</div>
<div class="wp-travel-engine-settings">
	<label for="wp_travel_engine_settings[paypal_payment]"><?php _e('Paypal Standard: ','wp-travel-engine');?></label>
	<input type="checkbox" class="paypal-payment" id="wp_travel_engine_settings[paypal_payment]" name="wp_travel_engine_settings[paypal_payment]" value="1" <?php if(isset($wp_travel_engine_settings['paypal_payment']) && $wp_travel_engine_settings['paypal_payment']!='' ) echo 'checked'; ?>>
	<div class="settings-note"><?php _e( 'Please check this to enable Paypal Standard booking system for trip booking and fill the account info below.', 'wp-travel-engine' ); ?></div>
</div>
<?php
if( has_action( 'wte_stripe_form' ) )
{ ?>
	<div class="wp-travel-engine-settings">
		<label for="wp_travel_engine_settings[stripe_payment]"><?php _e('Stripe : ','wp-travel-engine');?></label>
		<input type="checkbox" class="stripe-payment" id="wp_travel_engine_settings[stripe_payment]" name="wp_travel_engine_settings[stripe_payment]" value="1" <?php if(isset($wp_travel_engine_settings['stripe_payment']) && $wp_travel_engine_settings['stripe_payment']!='' ) echo 'checked'; ?>>
		<div class="settings-note"><?php _e( 'Please check this to enable Stripe booking system for trip booking and fill the account info below.', 'wp-travel-engine' ); ?></div>
	</div>
<?php
}
do_action( 'wte_authorize_net_enable' );
do_action( 'wte_payu_enable' );
do_action( 'wte_payfast_enable' );
do_action( 'wte_paypalexpress_enable' );
do_action( 'wte_hbl_enable' );
if( has_action( 'wte_paypal_form' ) )
{ ?>
	<h3><?php _e('Payment Gateways','wp-travel-engine'); ?></h3>
<?php
}
do_action( 'wte_paypal_form' );
do_action( 'wte_stripe_form' );
do_action( 'wte_authorize_net_admin' );
do_action( 'wte_payu_settings' );
do_action( 'wte_payfast_settings' );
do_action( 'wte_paypalexpress_settings' );
do_action( 'wte_hbl_settings' );
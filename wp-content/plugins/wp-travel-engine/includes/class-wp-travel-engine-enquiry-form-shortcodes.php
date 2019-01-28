<?php

/**

* Class for enquiry form shortcodes.

*/

class WP_Travel_Engine_Enquiry_Form_Shortcodes

{

	

	function init()

	{

		add_action('wp_travel_engine_enquiry_form', array( $this, 'wpte_enquiry_form' ));

		add_action('wp_ajax_wte_enquiry_send_mail', array($this, 'wte_enquiry_send_mail') );

		add_action('wp_ajax_nopriv_wte_enquiry_send_mail', array($this, 'wte_enquiry_send_mail') );

	}



	//Enquiry form main function

	function wpte_enquiry_form()

	{ ?>

		<form name="wte_enquiry_contact_form" id="wte_enquiry_contact_form" action="#" method="POST" enctype="multipart/form-data">

			<h2><?php $title = __('You can send your inquiry via the form below.','wp-travel-engine'); echo apply_filters('wp_travel_engine_enquiry_form_title',$title);?></h2>

			<input id="package_id" class="input" name="package_id" type="hidden" value="<?php global $post; echo $post->ID;?>" size="30" readonly />

			<div class="row-repeater package-name-holder">

				<label for="package_name"><?php _e('Package name:','wp-travel-engine');?><span class="required">*</span></label>

				<input id="package_name" class="input" name="package_name" type="text" value="<?php echo esc_attr(get_the_title($post->ID));?>" size="30" readonly />

			</div>

			

			<div class="row-repeater name-holder">

				<label for="enquiry_name"><?php _e('Your name:','wp-travel-engine');?><span class="required">*</span></label>

				<input id="enquiry_name" class="input" name="enquiry_name" type="text" value="" size="30" placeholder="<?php _e('Enter Your Name', 'wp-travel-engine' ); ?>" required />

			</div>

			<div class="row-repeater email-holder">

				<label for="enquiry_email"><?php _e('Your email:','wp-travel-engine');?><span class="required">*</span></label>

				<input id="enquiry_email" class="input" name="enquiry_email" type="email" value="" size="30" placeholder="<?php _e('Enter Your Email', 'wp-travel-engine' ); ?>" required />

            </div>

			<?php

			$obj = new Wp_Travel_Engine_Functions;

			$fields = $obj->wpte_enquiry_options();

			foreach ($fields as $key => $value) {

				switch ($key) {

					case 'contact': ?>

			            <div class="row-repeater contact">

							<label for="enquiry_contact"><?php _e('Contact No.:','wp-travel-engine');?><span class="required">*</span></label>

							<input id="enquiry_contact" class="input" name="enquiry_contact" type="text" value="" size="30" placeholder="<?php _e('Enter Your Contact Number', 'wp-travel-engine' ); ?>" <?php if($value['required'] == '1'){ echo 'required'; } ?>/>

			            </div>

					<?php

					break;



					case 'adults': ?>

			            <div class="row-repeater adult">

							<label for="enquiry_adult"><?php _e('Adults:','wp-travel-engine');?><span class="required">*</span></label>

							<input id="enquiry_adult" class="input" name="enquiry_adult" type="number" value="" size="30" placeholder="<?php _e('Enter Number of Adults', 'wp-travel-engine' ); ?>" <?php if($value['required'] == '1'){ echo 'required'; } ?> />

			            </div>

					<?php

					break;



					case 'children': ?>

			            <div class="row-repeater children">

							<label for="enquiry_children"><?php _e('Children:','wp-travel-engine');?></label>

							<input id="enquiry_children" class="input" name="enquiry_children" type="number" value="" size="30" placeholder="<?php _e('Enter Number of Children', 'wp-travel-engine' ); ?>" <?php if($value['required'] == '1'){ echo 'required'; } ?> />

						</div>

					<?php

					break;

						

					case 'message': ?>

			            <div class="row-repeater msg-holder">

			            	<div class="row-form">

			            		<label for="enquiry_message"><?php _e('Your message:','wp-travel-engine');?><span class="required">*</span></label>

								<textarea id="enquiry_message" class="input" name="enquiry_message" rows="7" cols="30" placeholder="<?php _e('Your Message', 'wp-travel-engine' ); ?>" <?php if($value['required'] == '1'){ echo 'required'; } ?> ></textarea>

			            	</div>

			            </div>

					<?php

					break;



					case 'country': ?>

						<div class="row-repeater country-holder">

							<label for="enquiry_country"><?php _e('Country:','wp-travel-engine');?><span class="required">*</span></label>

			                <select  id="enquiry_country" name="enquiry_country" data-placeholder="<?php esc_attr_e( 'Choose a country&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" <?php if($value['required'] == '1'){ echo 'required'; } ?>>

			                        <option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>

			                        <?php

			                        $obj = new Wp_Travel_Engine_Functions();

			                        $options = $obj->wp_travel_engine_country_list();

			                        foreach ( $options as $key => $val ) {

			                            echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '">' . esc_html( $val ) . '</option>';

			                        }

			                        ?>

			                </select>

			            </div>

			        <?php

					break;

				}

			}



			$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );

			$url = '';

			if ( isset($wp_travel_engine_settings['pages']['enquiry']) && $wp_travel_engine_settings['pages']['enquiry']!= '' )

			{

				$url = $wp_travel_engine_settings['pages']['enquiry'];

				$url = get_permalink( $url );

			}



			if ( !function_exists( 'get_the_privacy_policy_link' ) ) {

				function get_the_privacy_policy_link( $before = '', $after = '' ) {

					$link               = '';

					$privacy_policy_url = get_privacy_policy_url();



					if ( $privacy_policy_url ) {

						$link = sprintf(

							'<a class="privacy-policy-link" href="%s">%s</a>',

							esc_url( $privacy_policy_url ),

							__( 'Privacy Policy', 'wp-travel-engine' )

						);

					}



					/**

					 * Filters the privacy policy link.

					 *

					 * @since 4.9.6

					 *

					 * @param string $link               The privacy policy link. Empty string if it

					 *                                   doesn't exist.

					 * @param string $privacy_policy_url The URL of the privacy policy. Empty string

					 *                                   if it doesn't exist.

					 */

					$link = apply_filters( 'the_privacy_policy_link', $link, $privacy_policy_url );



					if ( $link ) {

						return $before . $link . $after;

					}



					return '';

				}

			}

			?>

            <div class="row-repeater confirm-holder">

                <div class="row-form">

					<label for="enquiry_confirmation"><input type="checkbox" id="enquiry_confirmation" name="enquiry_confirmation" required/>

						<?php echo isset($wp_travel_engine_settings['gdpr_msg']) ? esc_attr( $wp_travel_engine_settings['gdpr_msg'] ): 'By contacting us, you agree to our ';

   						echo get_the_privacy_policy_link().'.';

					?></label>

				</div>

			</div>

			<input type="hidden" id="redirect-url" name="redirect-url" value="<?php echo $url;?>">

			<div class="row-repeater submit">

				<input id="enquiry_submit_button" type="submit" value="<?php _e('Send email','wp-travel-engine');?>" />

			</div>

			<div class="row-repeater confirm-msg">

				<span class="success-msg"></span>

				<span class="failed-msg"></span>

			</div>

		</form>

	<?php

	}





	/**

	 * Sends mail to subscriber and admin. 

	 * 

	 * @since 3.0.0

	 */

	function wte_enquiry_send_mail()

	{

		$email = sanitize_email( $_POST['enquiry_email'] );

		

		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings',true );



	    $name = esc_attr( $_POST['enquiry_name'] );

	    $country = isset( $_POST['enquiry_country'] ) ? esc_attr( $_POST['enquiry_country'] ):'N/A';

	    $contact = esc_attr( $_POST['enquiry_contact'] );

	    $adult = isset( $_POST['enquiry_adult'] ) ? esc_attr( $_POST['enquiry_adult'] ):'N/A';

	    $children = isset( $_POST['enquiry_children'] ) ? esc_attr( $_POST['enquiry_children'] ):'N/A';

	    $message1 = esc_attr( $_POST['enquiry_message'] );

	    

	    $postid = get_post( $_POST['enquiry_pid'] );

		$slug = $postid->post_name;



	    $url = '<a href='.esc_url( get_permalink( $postid ) ).'>'.esc_attr( $slug ).'</a>';

	    $subject = isset( $wp_travel_engine_settings['query_subject'] ) ? esc_attr( $wp_travel_engine_settings['query_subject'] ):'Enquiry received';

	    $admin_email = get_option ('admin_email');



	    $to = sanitize_email($admin_email);

	    

		$email_from = $name.'<'.$email.'>';

		$ipaddress = '';

	    if (getenv('HTTP_CLIENT_IP'))
	    {

	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    }
	    else if(getenv('HTTP_X_FORWARDED_FOR')){

	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    }
	    else if(getenv('HTTP_X_FORWARDED')){

	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    }
	    else if(getenv('HTTP_FORWARDED_FOR')){

	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    }
	    else if(getenv('HTTP_FORWARDED')){

	        $ipaddress = getenv('HTTP_FORWARDED');
	    }
	    else if(getenv('REMOTE_ADDR')){

	        $ipaddress = getenv('REMOTE_ADDR');
	    }
	    else{

	        $ipaddress = 'UNKNOWN';
	    }
	        

    	$headers[] = 'From: '.$name.' <'.$admin_email .'>';

    	$headers[] = 'Reply-To: '.$name.' <'.$email .'>';

	    $country = esc_attr( $_POST['enquiry_country'] );

	    $message = __("Name: ","wp-travel-engine"). $name.'<br/>';

	    $message.= __("Country: ","wp-travel-engine"). $country.'<br/>';

	    $message.= __("Trip: ",'wp-travel-engine'). $url.'<br/>';

	    $message.= __("Email: ","wp-travel-engine"). $email.'<br/>';

	    $message.= __("Contact: ",'wp-travel-engine'). $contact.'<br/>';

	    $message.= __("IP Address: ",'wp-travel-engine'). $ipaddress.'<br/>';

	    $message.= __("Adult: ","wp-travel-engine"). $adult.'<br/>';

	    $message.= __("Children: ",'wp-travel-engine'). $children.'<br/>';

	    $message.= __("Message: ",'wp-travel-engine'). $message1.'<br/>';



		add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

	    

	    if ( strpos( $wp_travel_engine_settings['email']['emails'], ',') !== false ) {

	    	$wp_travel_engine_settings['email']['emails'] = str_replace(' ', '', $wp_travel_engine_settings['email']['emails']);

			$admin_emails = explode( ',', $wp_travel_engine_settings['email']['emails'] );

			foreach ( $admin_emails as $key => $value ) {

	    		$admin_sent = wp_mail( $value, $subject, $message, $headers );

			}

		}

		else{

			$wp_travel_engine_settings['email']['emails'] = str_replace(' ', '', $wp_travel_engine_settings['email']['emails']);

	    	$admin_sent = wp_mail( $to, $subject, $message, $headers );

		}

		

		remove_filter('wp_mail_content_type', 'set_html_content_type');

	    

	    if( $admin_sent==1 && isset( $_POST['enquiry_confirmation']) && $_POST['enquiry_confirmation'] == 'on' )

	    {	

	    	$new_post = array( 

			'post_title' => 'enquiry ',

			'post_status' => 'publish',

			'post_type' => 'enquiry',

			);



			// Insert the post into the database.

			$post_id = wp_insert_post( $new_post );



			if( !$post_id ){

				return false;

			}



			$arr['enquiry'] = array(

					'name' 	  => $name,

					'country' => $country,

					'email'	  => $email,

					'pname'	  => $_POST['enquiry_pid'],

					'contact' => $contact,

					'adults'  => $adult,

					'children'=> $children,

					'message' => $message1

			);

			add_post_meta( $post_id, 'wp_travel_engine_setting', $arr );



			$title = 'Enquiry #'.$post_id;



			$post_data = array(

				'ID'           => $post_id,

				'post_title'   => $title

			);



			// Update the post into the database.

			wp_update_post( $post_data );





			$result['type'] = "success";

			$result['message'] = __( "Your query has been successfully sent. Thank You.", 'wp-travel-engine' );		

		

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX )

			{

				$result = json_encode($result);

				echo $result;

			}			

		}



		if( $admin_sent == 0 )

	    {	

			$result['type'] = "failed";

			$result['message'] = __( "Sorry, your query could not be sent at the moment. May be try again later. Thank You.","wp-travel-engine" );		

		

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX )

			{

				$result = json_encode($result);

				echo $result;

			}

		}

		if( isset($_POST['query_confirmation']) && $_POST['query_confirmation']!= 'on' ) {

			$result['type'] = "failed";

			$result['message'] = __( "Confirmation failed, please try again. Thank You.","wp-travel-engine" );		

		}

		exit;	

	}

}

$obj = new WP_Travel_Engine_Enquiry_Form_Shortcodes;

$obj->init();
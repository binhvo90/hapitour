<?php
/**
 * Email Functionality
 *
 * Maintain a list of tags and functions that are used in email templates.
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Mail_Template
{
	function wpte_get_client_ip()
	{
	 	$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;
	}
	
	function mail_editor( $settings, $pid )
	{
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
		$booking_url = get_edit_post_link( $pid );
		$booking_url = '#<a href="'.esc_url($booking_url).'">'.$pid.'</a>';
		$subject_receipt = __( 'Booking Confirmation', 'wp-travel-engine' );
		if( isset( $wp_travel_engine_settings['email']['subject'] ) && $wp_travel_engine_settings['email']['subject']!='' )
		{
			$subject_receipt = $wp_travel_engine_settings['email']['subject'];
		}
		
		$from_name = get_bloginfo("name");
		if( isset( $wp_travel_engine_settings['email']['name'] ) && $wp_travel_engine_settings['email']['name']!='' )
		{
			$from_name = $wp_travel_engine_settings['email']['name'];
		}

		$from_email = get_option("admin_email");
		if( isset( $wp_travel_engine_settings['email']['from'] ) && $wp_travel_engine_settings['email']['from']!='' )
		{
			$from_email = $wp_travel_engine_settings['email']['from'];
		}

		$from_receipt =$from_name.'*<'.$from_email.'>';
		// $from_receipt = trim($from_receipt);
		  // To send HTML mail, the Content-type header must be set
		$headers_receipt  = 'MIME-Version: 1.0' . "\r\n";
		$charset = apply_filters('wp_travel_engine_mail_charset', 'Content-type: text/html; charset=iso-8859-1');
		$headers_receipt .= $charset . "\r\n";
		  // Create email headers
		$headers_receipt .='From:'.$from_receipt."\r\n".
		    'Reply-To: '.$from_receipt."\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		$sitename = get_bloginfo( 'name' );
		$purchase_open = '<html><body>';
		$post = get_post( $_SESSION['trip-id'] ); 
		$slug = $post->post_name;
		$trip = '<a href='.esc_url( get_permalink( $_SESSION['trip-id'] ) ).'>'.$slug.'</a>';
		$tdate = $_SESSION['trip-date'];
		$traveler = $_SESSION['travelers'];
        
		$code = 'USD';
        if( isset( $wp_travel_engine_settings['currency_code'] ) && $wp_travel_engine_settings['currency_code']!= '' )
        {
            $code = $wp_travel_engine_settings['currency_code'];
        } 
        $obj = new Wp_Travel_Engine_Functions();
        $currency = $obj->wp_travel_engine_currencies_symbol( $code );		

		$price = $currency.$_SESSION['trip-cost'].' '.$code; 
		$fullname = $settings['place_order']['booking']['fname'].' '.$settings['place_order']['booking']['lname'];
		$trip_settings = get_post_meta( $_SESSION['trip-id'],'wp_travel_engine_setting',true );
		$singletripprice = str_replace( ',', '', $_SESSION['trip-cost'] );
        $cost = isset( $trip_settings['trip_price'] ) ? $trip_settings['trip_price']: '';
		if( $cost!='' && isset($trip_settings['sale']) )
        {
			$tripprice = $cost;
		}
		else{
			if( isset( $trip_settings['trip_prev_price'] ) && $trip_settings['trip_prev_price']!='' ) 
			{
				$tripprice = $trip_settings['trip_prev_price'];
			}
		}

		$tprice = $currency.number_format($tripprice).' '.$code;

		if( isset( $wp_travel_engine_settings['email']['purchase_wpeditor'] ) && $wp_travel_engine_settings['email']['purchase_wpeditor']!='' )
		{
			$purchase_receipt = apply_filters( 'meta_content', $wp_travel_engine_settings['email']['purchase_wpeditor'] );	
			$purchase_receipt = str_replace( '{name}', $settings['place_order']['booking']['fname'], $purchase_receipt );
			$purchase_receipt = str_replace( '{fullname}', $fullname. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{user_email}', $settings['place_order']['booking']['email']. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{billing_address}', $settings['place_order']['booking']['address']. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{sitename}', $sitename. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{price}', $price. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{tprice}', $tprice. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{trip_url}', '#'.$trip. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{tdate}', $_SESSION['trip-date']. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{traveler}', $traveler. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{child-traveler}', $_SESSION['child-travelers']. "<br />", $purchase_receipt );
			$purchase_receipt = str_replace( '{booking_url}', $booking_url. "<br />", $purchase_receipt );

			$ip = $this->wpte_get_client_ip();
			
			$purchase_receipt = str_replace( '{ip_address}', $ip. "<br />", $purchase_receipt );
		}
		else{

			$purchase_receipt  = '<div style="background:#f5f5f5; padding:15px;"><div style=" border-radius:7px; background:#fff; marin:0 auto; width:90%; margin:0 auto; margin-bottom:20px; margin-top:20px; padding:10px 10px;line-height: 30px;"><h3 style="color:#777; font-size:17px; margin:0px;padding:8px; ">'.__( 'Dear {name},', 'wp-travel-engine' ) . "<br />" ;
			$purchase_receipt .= '</h3>'.'<p style="padding:0 10px; color:#555; font-size:21px;">'.__( 'You have successfully made the trip booking. Your booking information is below.', 'wp-travel-engine' ).'</p>'.'<p style="color:#555; font-size:15px; margin:0; padding:0 0 0 8px; line-height:1.6; ">'.'<br />'."<br />";
			$purchase_receipt .= '' . "<br />";
			$purchase_receipt .= __( 'Trip Name: {trip_url}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Trip Cost: {tprice}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Trip Start Date : {tdate}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Total Number of Traveler(s): {traveler}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Total Number of Child Traveler(s): {child-traveler}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Booking Url: {booking_url}','wp-travel-engine' ). "<br />";
			$purchase_receipt .= __( 'Total Cost: {price}','wp-travel-engine'). "<br />";
			$purchase_receipt .= __( 'Thank you.','wp-travel-engine'). "<br />";
			$purchase_receipt .= __( 'Best regards,','wp-travel-engine'). "<br />";
			$purchase_receipt .= get_bloginfo('name').'<br /></div></div></body></html>';


			$purchase_receipt = str_replace( '{name}', $settings['place_order']['booking']['fname'], $purchase_receipt );
			$purchase_receipt = str_replace( '{fullname}', $fullname, $purchase_receipt );
			$purchase_receipt = str_replace( '{user_email}', $settings['place_order']['booking']['email'], $purchase_receipt );
			$purchase_receipt = str_replace( '{billing_address}', $settings['place_order']['booking']['address'], $purchase_receipt );
			$purchase_receipt = str_replace( '{date}', date('Y-m-d H:i:s'), $purchase_receipt );
			$purchase_receipt = str_replace( '{sitename}', $sitename, $purchase_receipt );
			$purchase_receipt = str_replace( '{price}', $price, $purchase_receipt );
			$purchase_receipt = str_replace( '{tprice}', $tprice, $purchase_receipt );
			$purchase_receipt = str_replace( '{trip_url}', '#'.$trip, $purchase_receipt );
			$purchase_receipt = str_replace( '{tdate}', $_SESSION['trip-date'], $purchase_receipt );
			$purchase_receipt = str_replace( '{traveler}', $traveler, $purchase_receipt );
			$purchase_receipt = str_replace( '{child-traveler}', $_SESSION['child-travelers'], $purchase_receipt );
			$purchase_receipt = str_replace( '{booking_url}', $booking_url. "<br />", $purchase_receipt );

			$ip = $this->wpte_get_client_ip();
			
			
			$purchase_receipt = str_replace( '{ip_address}', $ip, $purchase_receipt );
		}

		$purchase_close = '</body></html>';
		$purchase_receipt = $purchase_open.'<div style="background:#f5f5f5; padding:15px;"><div style=" border-radius:7px; background:#fff; marin:0 auto; width:90%; margin:0 auto; margin-bottom:20px; margin-top:20px; padding:10px 10px;line-height: 30px;">'.$purchase_receipt.'</div></div>'.$purchase_close;
		// die;
		wp_mail( $settings['place_order']['booking']['email'], $subject_receipt, $purchase_receipt, $headers_receipt );
		

		//Mail for Admin
		if( isset( $wp_travel_engine_settings['email']['sale_subject'] ) && $wp_travel_engine_settings['email']['sale_subject']!='' )
		{
			$subject_book = esc_attr( $wp_travel_engine_settings['email']['sale_subject'] );
		}
		$subject_book = 'New Booking Order #'.$pid;
		$from_book = $from_name.'*<'.$from_email.'>';
		// $from_book = trim($from_book);
		  // To send HTML mail, the Content-type header must be set
		$headers_book  = 'MIME-Version: 1.0' . "\r\n";
		$charset = apply_filters('wp_travel_engine_mail_charset', 'Content-type: text/html; charset=iso-8859-1');
		$headers_book .= $charset . "\r\n";
		  // Create email headers
		$headers_book .= 'From: '.$from_book."\r\n".
		    'Reply-To: '.$from_receipt."\r\n" .
		    'X-Mailer: PHP/' . phpversion();


		$book_open = '<html><body>';
		$post = get_post( $_SESSION['trip-id'] ); 
		$slug = $post->post_name;
		$trip = '<a href='.esc_url( get_permalink( $_SESSION['trip-id'] ) ).'>'.$slug.'</a>';
		
		if( isset( $wp_travel_engine_settings['email']['sales_wpeditor'] ) && $wp_travel_engine_settings['email']['sales_wpeditor']!='' )
		{
			$book_receipt = apply_filters( 'meta_content', $wp_travel_engine_settings['email']['sales_wpeditor'] );
			$book_receipt = str_replace( '{name}', $settings['place_order']['booking']['fname'], $book_receipt );
			$book_receipt = str_replace( '{fullname}', $fullname. "<br />", $book_receipt );
			$book_receipt = str_replace( '{user_email}', $settings['place_order']['booking']['email']. "<br />", $book_receipt );
			$book_receipt = str_replace( '{billing_address}', $settings['place_order']['booking']['address']. "<br />", $book_receipt );
			$book_receipt = str_replace( '{date}', date('Y-m-d H:i:s'). "<br />", $book_receipt );
			$book_receipt = str_replace( '{sitename}', $sitename. "<br />", $book_receipt );
			$book_receipt = str_replace( '{price}', $price. "<br />", $book_receipt );
			$book_receipt = str_replace( '{tprice}', $tprice. "<br />", $book_receipt );
			$book_receipt = str_replace( '{trip_url}', '#'.$trip. "<br />", $book_receipt );
			$book_receipt = str_replace( '{tdate}', $_SESSION['trip-date']. "<br />", $book_receipt );
			$book_receipt = str_replace( '{traveler}', $traveler. "<br />", $book_receipt );
			$book_receipt = str_replace( '{booking_url}', $booking_url. "<br />", $book_receipt );
			$book_receipt = str_replace( '{child-traveler}', $_SESSION['child-travelers']. "<br />", $book_receipt );
			$ip = $this->wpte_get_client_ip();
			$book_receipt = str_replace( '{ip_address}', $ip. "<br />", $book_receipt );
		}
		else{
			
			$book_receipt  = '<div style="background:#f5f5f5; padding:15px;"><div style=" border-radius:7px; background:#fff; marin:0 auto; width:90%; margin:0 auto; margin-bottom:20px; margin-top:20px; padding:10px 10px;line-height: 30px;"><h3 style="color:#777; font-size:17px; margin:0px;padding:8px; ">'.__( 'Dear Admin,', 'wp-travel-engine' ).'</h3>'.'<p style="padding:0 10px; color:#555; font-size:21px;">'. "<br />";
			$book_receipt .= __( 'The following booking has been successfully made.','wp-travel-engine'). "<br />";
			$book_receipt .= "<br />".__( 'Trip Name : {trip_url}','wp-travel-engine' ).  "<br />"; 
			$book_receipt .= __( 'Trip Cost:  {price}','wp-travel-engine' ).  "<br />";
			$book_receipt .= __( 'Trip Start Date : {tdate}','wp-travel-engine' ). "<br />";
			$book_receipt .= __( 'Total Number of Traveler(s): {traveler}','wp-travel-engine' ). "<br />";
			$book_receipt .= __( 'Total Number of Child Traveler(s): {child-traveler}','wp-travel-engine' ). "<br />";
			$book_receipt .= __( 'Trip Booking URL: {booking_url}','wp-travel-engine' ). "<br />";
			$book_receipt .= __( 'Total Cost: {price}','wp-travel-engine'). "<br />";
			$book_receipt .= __( 'Thank you.','wp-travel-engine'). "<br />";
			$book_receipt .= __( 'Best regards,','wp-travel-engine'). "<br />";
			$book_receipt .= get_bloginfo('name').'<br /></div></div></body></html>';

			$book_receipt = str_replace( '{name}', $settings['place_order']['booking']['fname'], $book_receipt );
			$book_receipt = str_replace( '{fullname}', $fullname, $book_receipt );
			$book_receipt = str_replace( '{user_email}', $settings['place_order']['booking']['email'], $book_receipt );
			$book_receipt = str_replace( '{billing_address}', $settings['place_order']['booking']['address'], $book_receipt );
			$book_receipt = str_replace( '{date}', date('Y-m-d H:i:s'), $book_receipt );
			$book_receipt = str_replace( '{sitename}', $sitename, $book_receipt );
			$book_receipt = str_replace( '{price}', $price, $book_receipt );
			$book_receipt = str_replace( '{tprice}', $tprice, $book_receipt );
			$book_receipt = str_replace( '{trip_url}', '#'.$trip, $book_receipt );
			$book_receipt = str_replace( '{tdate}', $_SESSION['trip-date'], $book_receipt );
			$book_receipt = str_replace( '{traveler}', $traveler, $book_receipt );
			$book_receipt = str_replace( '{booking_url}', $booking_url, $book_receipt );
			$book_receipt = str_replace( '{child-traveler}', $_SESSION['child-travelers'], $book_receipt );
		}	

		$book_close = '</body></html>';

		if( !isset ( $wp_travel_engine_settings['email']['disable_notif'] ) || $wp_travel_engine_settings['email']['disable_notif'] != '1' )
		{	
			if ( strpos( $wp_travel_engine_settings['email']['emails'], ',') !== false ) {
				$wp_travel_engine_settings['email']['emails'] = str_replace(' ', '', $wp_travel_engine_settings['email']['emails']);
				$admin_emails = explode( ',', $wp_travel_engine_settings['email']['emails'] );
				$book_receipt = $book_open.'<div style="background:#f5f5f5; padding:15px;"><div style=" border-radius:7px; background:#fff; marin:0 auto; width:90%; margin:0 auto; margin-bottom:20px; margin-top:20px; padding:10px 10px;line-height: 30px;">'.$book_receipt.'</div></div>'.$book_close;
				foreach ( $admin_emails as $key => $value ) {
					wp_mail( $value, $subject_book, $book_receipt, $headers_book );
				}
			}
			else{
				$wp_travel_engine_settings['email']['emails'] = str_replace(' ', '', $wp_travel_engine_settings['email']['emails']);
				$book_receipt = $book_open.'<div style="background:#f5f5f5; padding:15px;"><div style=" border-radius:7px; background:#fff; marin:0 auto; width:90%; margin:0 auto; margin-bottom:20px; margin-top:20px; padding:10px 10px;line-height: 30px;">'.$book_receipt.'</div></div>'.$book_close;
				wp_mail( $wp_travel_engine_settings['email']['emails'], $subject_book, $book_receipt, $headers_book );
			}
		}
	}
}

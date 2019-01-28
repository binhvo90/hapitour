<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/public
 * @author     WP Travel Engine <https://wptravelengine.com/>
 */
class Wp_Travel_Engine_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = WP_TRAVEL_ENGINE_VERSION;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Travel_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Travel_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-travel-engine-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style('smoothness-style', plugin_dir_url( __FILE__ ) . 'css/datepicker-style.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );
		wp_enqueue_style('trip-gallery', plugin_dir_url( __FILE__ ) . 'css/wpte-gallery-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Travel_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Travel_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( $this->plugin_name.'custom', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-public.js', array( 'jquery' ), $this->version, false );
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true );
		$wp_travel_engine_confirm = isset($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) ? esc_attr($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) : '';
		$wp_travel_engine_confirm = get_permalink( $wp_travel_engine_confirm );
		$link = esc_url($wp_travel_engine_confirm);
		wp_enqueue_script( $this->plugin_name);
		wp_localize_script(
			$this->plugin_name,
			'WTEAjaxData',
			array( 'ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce( 'wp_rest' ) )
			);
		$extra_array = array(
					'ajax' => array(
						'success'       => __( 'Cart sucessfully updated!', 'wp-travel-engine' ),
						'failed'		=> __( 'Cart update failed!', 'wp-travel-engine')
					),
				);
		if ( is_rtl() )
		{
			wp_localize_script( $this->plugin_name, 'rtl', array( 'enable' => '1' ) );
		}
		else{
			wp_localize_script( $this->plugin_name, 'rtl', array( 'enable' => '0' ) );
		}
		wp_localize_script( $this->plugin_name, 'WPMSG_OBJ', $extra_array );
		wp_enqueue_script( 'owl', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wpte-gallery-public', plugin_dir_url( __FILE__ ) . 'js/wpte-gallery-public.js', array( 'jquery' ), $this->version, false );
		$wp_travel_engine_confirm = isset($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) ? esc_attr($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) : '';
		$wp_travel_engine_confirm = get_permalink( $wp_travel_engine_confirm );
		wp_localize_script(
			$this->plugin_name,
			'Url',
			array( 'paypalurl' => 'https://www.paypal.com/cgi-bin/webscr', 'normalurl' => esc_url($wp_travel_engine_confirm) )
			);
		
		global $post;
        $wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
        if(class_exists('Wp_Travel_Engine_Group_Discount'))
        {
	        if(isset($wp_travel_engine_settings['group']['discount']) && !is_404() && is_object( $post ))
	        { 
	    		$wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
	        	if(!isset($wp_travel_engine_setting['group']['discount']))
	        	{
					wp_enqueue_script( 'wp-travel-engine-group-discount'.$post->ID, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-travelers-number.js', array( 'jquery' ), $this->version, false );
				}
			}
			if(!isset($wp_travel_engine_settings['group']['discount']) && !is_404() && is_object( $post ))
	        { 
	    		$wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
	        	if(!isset($wp_travel_engine_setting['group']['discount']))
	        	{
					wp_enqueue_script( 'wp-travel-engine-group-discount'.$post->ID, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-travelers-number.js', array( 'jquery' ), $this->version, false );
				}
			}
			if(!isset($wp_travel_engine_settings['group']['discount']) && !is_404() && is_object( $post ))
	        { 
	    		$wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
	        	if(isset($wp_travel_engine_setting['group']['discount']))
	        	{
					wp_enqueue_script( 'wp-travel-engine-group-discount'.$post->ID, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-travelers-number.js', array( 'jquery' ), $this->version, false );
				}
			}
		}
		else{
			if( is_object( $post ) )
			{
				wp_enqueue_script( 'wp-travel-engine-group-discount'.$post->ID, plugin_dir_url( __FILE__ ) . 'js/wp-travel-engine-travelers-number.js', array( 'jquery' ), $this->version, false );
			}
		}
	}

	/**
    * Start Session.
    *
    * @since    1.0.0
    */
	 function wpte_start_session() {
		if(!session_id()) {
			session_start();
		}
	}

	/**
	 * Callback function for add to cart ajax.
	 *
	 * @since    1.0.0
	 */
	function wp_add_trip_cart()
	{
		$nonce = $_REQUEST['nonce'];

		if( array_key_exists( $_SESSION['cart_item'][$_REQUEST['trip_id']], $_SESSION['cart_item'] ) )
		{
			$result['type'] = 'already';
			$result['message'] = __('Already added to cart!','wp-travel-engine');
		}


		else if( !array_key_exists( $_SESSION['cart_item'][$_REQUEST['trip_id']], $_SESSION['cart_item'] ) && wp_verify_nonce( $nonce, 'wp-travel-engine-nonce' ) )
		{
			$_SESSION['cart_item'][$_REQUEST['trip_id']] = $_REQUEST['trip_id'];
			$result['type'] = 'success';
			$result['message'] = __('Added to cart successfully!','wp-travel-engine');
		}
		else {
			$result['type'] = 'error';
			$result['message'] = __('Unable to add to cart!','wp-travel-engine');
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			$result = json_encode($result);
			echo $result;
		}
		else {
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}

   		die();
	}
	
	/**
	 * Array of payment gateways
	 *
	 */
	function wte_payment_gateways_dropdown()
	{ 
		$options = apply_filters( 'wte_payment_gateways_dropdown_options', array() );
		?>
			<?php
			if( sizeof($options) > 0 )
			{ ?>
			<div class="payment-method">
				<div class="payment-options">
					<h3><?php _e( 'Select Payment Method','wp-travel-engine' ); ?></h3>	
					<div class="payment-options-holder">
						<img src="<?php echo WP_TRAVEL_ENGINE_URL;?>/public/css/icons/mastercard.png">
						<img src="<?php echo WP_TRAVEL_ENGINE_URL;?>/public/css/icons/visa.png">
						<img src="<?php echo WP_TRAVEL_ENGINE_URL;?>/public/css/icons/americanexpress.png">
						<img src="<?php echo WP_TRAVEL_ENGINE_URL;?>/public/css/icons/discover.png">
						<img src="<?php echo WP_TRAVEL_ENGINE_URL;?>/public/css/icons/paypal.png">
					</div>
					<select name="wte_payment_options" id="wte_payment_options" required>
						<?php
						echo '<option value="">'.__('Please choose a gateway','wp-travel-engine').'</option>';
						foreach ( $options as $option ) {
							echo '<option value="'.$option.'">'.$option.'</option>';
						}
						?>
					</select>
				</div>
			</div>
			<?php
			} 
			?>
	<?php
	}

	/**
	 * Shows trips added to cart.
	 *
	 * @since    1.0.2
	 */
	function wte_cart_trips()
	{
		if( isset( $_SESSION['cart_item'] ) && $_SESSION['cart_item']!='' )
		{
			unset($_SESSION['cart_item'][$_POST['trip-id']]);
			$matches = array_unique( $_SESSION['cart_item'] );
			echo '<h2>'.__( 'Trips:', 'wp-travel-engine' ).'</h2>';

    		foreach ($matches as $key => $value) { 
				$wp_travel_engine_trip_setting = get_post_meta( $value, 'wp_travel_engine_setting', true );
   				$wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true); 
				$cost = $wp_travel_engine_trip_setting['trip_price'];
				$nonce = wp_create_nonce( 'wte-remove-nonce' );
    			?>
				<div class="wp-travel-engine-order-form-wrapper" id="wp-travel-engine-order-form-wrapper-<?php echo esc_attr($value);?>"><a href="#" class="remove-from-cart" data-id="<?php echo esc_attr($value);?>" data-nonce="<?php echo $nonce;?>"></a>
					<div class="wp-travel-engine-order-left-column">
			        	<?php echo get_the_post_thumbnail($value,'medium',''); ?>
					</div>
					<div class="wp-travel-engine-order-right-column">
						<h3 class="trip-title"><?php echo get_the_title( $value );?><input type="hidden" name="trips[]" value="<?php echo esc_attr( $value );?>"></h3>
						<ul class="trip-property">
							<li><span><?php _e('Start Date: ','wp-travel-engine');?></span> <input type="text" min="1" class="wp-travel-engine-price-datetime" id="wp-travel-engine-trip-datetime-<?php echo esc_attr($value);?>" name="trip-date[]" placeholder="<?php _e('Pick a date','wp-travel-engine');?>"></li>
							<li class="trip-price-holder"><span><?php _e('Trip Price: ','wp-travel-engine');?></span>
							<?php  
							$code = 'USD';
	                        if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
	                        {
	                            $code = $wp_travel_engine_setting_option_setting['currency_code'];
	                        } 
	                        $obj = new Wp_Travel_Engine_Functions();
	                        $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                            echo esc_attr($currency);
                            echo '<span class="cart-price-holder">'.esc_attr( $obj->wp_travel_engine_price_format($cost) ).'</span>';
                            echo esc_attr( ' '.$code );?></li>
							<li><span><?php _e('Duration: ','wp-travel-engine');?></span><?php if( isset( $wp_travel_engine_trip_setting['trip_duration']) && $wp_travel_engine_trip_setting['trip_duration']!=''){echo $wp_travel_engine_trip_setting['trip_duration']; if( $wp_travel_engine_trip_setting['trip_duration']>1){ _e(' Days','wp-travel-engine'); } else{ _e(' Day','wp-travel-engine'); }}?></li>
							<li><span><?php $no_of_travelers = __('Number of Travelers: ','wp-travel-engine'); echo apply_filters('wp_travel_engine_no_of_travelers_text', $no_of_travelers);?>
	                    		<input type="number" min="1" name="travelers[]" class="travelers-number" value="" placeholder="0" required></span></li>
	                    	<li class="cart-trip-total-price"><span><?php _e('Total: ','wp-travel-engine');?></span><?php echo esc_attr($currency).'<span class="cart-trip-total-price-holder">0</span>'.esc_attr( ' '.$code );?></li>
						</ul>
					</div>
				</div>
    		<?php

    		}
		}
	}

	/**
	 * update cart button.
	 *
	 * @since    1.0.2
	 */
	function wte_update_cart()
	{
		echo '<div class="wte-update-cart-button-wrapper"><div class="wte-update-cart-button"><input type="submit" name="submit" value="'.__( 'Update cart','wp-travel-engine' ).'" class="wte-update-cart"></div><div class="wte-update-cart-msg"></div></div>';
	}

	/**
	 * update cart form.
	 *
	 * @since    1.0.2
	 */
	function wte_cart_form_wrapper()
	{
		echo '<form method="post" id="wp-travel-engine-cart-form" action="'.admin_url('admin-ajax.php').'">';
	}

	/**
	 * update cart form close.
	 *
	 * @since    1.0.2
	 */
	function wte_cart_form_close()
	{
		wp_nonce_field( 'update_cart_action_nonce', 'update_cart_action_nonce' );
		echo '</form>';
	}

	/**
	 * Callback function for remove to cart ajax.
	 *
	 * @since    1.0.0
	 */
	function wte_remove_from_cart()
	{
		$nonce = $_REQUEST['nonce'];
		if( wp_verify_nonce( $nonce, 'wte-remove-nonce' ) )
		{
			unset($_SESSION['cart_item'][$_REQUEST['trip_id']]);
			$result['type'] = 'success';
		}
		else {
			$result['type'] = 'error';
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			$result = json_encode($result);
			echo $result;
		}
		else {
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}

   		die();
	}


	/**
	 * Callback function for update to cart ajax.
	 *
	 * @since    1.0.0
	 */

	function wte_ajax_update_cart()
	{
		$nonce = $_REQUEST['nonce'];
		if( wp_verify_nonce( $nonce, 'update_cart_action_nonce' ) )
		{
			$result['type'] = 'success';
		}
		else {
			$result['type'] = 'error';
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			parse_str($_REQUEST['data2'], $values);
			
			$cost = '';
			foreach ($values['trips'] as $key => $value) {
				$option = get_post_meta( $value, 'wp_travel_engine_setting', true );
				$cost = $option['trip_price'];
				$cost += $cost;
			}
			
			$travelers = '';
			foreach ($values['travelers'] as $key => $value) {
				$travelers = $value;
				$travelers += $travelers;
			}
			$len= sizeof($values['trips']);

			for ($i=0; $i < $len; $i++) { 
				$option = get_post_meta( $values['trips'][$i], 'wp_travel_engine_setting', true );
				$cost = $option['trip_price'];
				$tc = $tc + ($cost*$values['travelers'][$i]);
			}
			
			$post = max(array_keys($values['trips']));
			$pid = get_post( $values['trips'][$post] );
			$slug = $pid->post_title;
			$arr =  array(
						'place_order' 		=> array(
							'travelers' 	=> esc_attr( $travelers ),
				            'trip-cost' 	=> esc_attr( $tc ),
				            'trip-id' 		=> esc_attr( end( $values['trips'] ) ),
				            'tname' 		=> esc_attr( $slug ),
				            'trip-date' 	=> esc_attr( end( $values['trip-date'] ) ),
						)
					);
			$_SESSION = $arr;
		}
		else {
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}

   		die();
	}

	/**
     * Secondary content such as trip gallery for single trip.
     *
     * @since    1.0.0
     */
    function wp_travel_engine_feat_img_trip_galleries()
    {
       require WP_TRAVEL_ENGINE_BASE_PATH . '/includes/frontend/trip-meta/trip-meta-parts/trip-feat-img-gallery.php'; 
    }

    //Ajax load more on activities
    function wpte_be_load_more_js() {
		global $wp_query;
		if(!isset(get_queried_object()->slug))
			return;
		$cats = str_replace("/",",",end($wp_query->query));
        $wte_trip_cat_slug = get_queried_object()->slug;
		$args = array(
			'nonce' => wp_create_nonce( 'wpte-be-load-more-nonce' ),
			'url'   => admin_url( 'admin-ajax.php' ),
			'query' => $cats,
			'slug'  => $wte_trip_cat_slug,
			'current_page' => isset($_POST['page']) ? esc_attr($_POST['page']) : 1,
			'max_page' => $wp_query->max_num_pages
		);
		wp_enqueue_script( 'wpte-be-load-more', plugin_dir_url( __FILE__ ) . 'js/load-more.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'wpte-be-load-more', 'beloadmore', $args );
	}
	/**
	 * AJAX Load More 
	 *
	 */
	function wpte_ajax_load_more() {
		check_ajax_referer( 'wpte-be-load-more-nonce', 'nonce' );                                               
		$wp_travel_engine_setting_option_setting = get_option( 'wp_travel_engine_settings', true );					
		$keys = $_POST['query'];
		$arr = $_POST['second_class'];
        $default_posts_per_page = get_option( 'posts_per_page' );

        $display_count = $default_posts_per_page;

		// // Next, get the current page
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;


		// After that, calculate the offset
		$offset = $_POST['postoffset'];

		// echo "offset=".$offset;
        $args = 
		array(
            'post_type' => 'trip', // Your Post type Name that You Registered
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => $keys,
                    'field' => 'slug',
                    'terms' => $_POST['second_class'],
                    'include_children' => true
                )
            ),
            'number'     =>  $display_count,
  			'page'       =>  $page,
  			'offset'     =>  $offset
        );
		ob_start();
		$loop = new WP_Query( $args );
		if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post(); 
			global $post;
            $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );?>
			<div class="col">
                <div class="holder">
                        <div class="img-holder">
                            <a href="<?php echo esc_url( get_the_permalink() );?>" class="trip-post-thumbnail"><?php
                            $trip_feat_img_size = apply_filters('wp_travel_engine_archive_trip_feat_img_size','destination-thumb-trip-size');
                            $feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $trip_feat_img_size );
                            if(isset($feat_image_url[0]))
                            { ?>
                                <img src="<?php echo esc_url( $feat_image_url[0] );?>">
                            <?php
                            }
                            else{ ?>
                                <img src="<?php echo esc_url(  WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/trip-listing-fallback.jpg' );?>">
                            <?php } ?>
                            </a>
                              <?php
                                $code = 'USD';
                                if( isset($wp_travel_engine_setting_option_setting['currency_code']) && $wp_travel_engine_setting_option_setting['currency_code']!='')
                                {
                                    $code = esc_attr( $wp_travel_engine_setting_option_setting['currency_code'] );
                                }
                                $obj = new Wp_Travel_Engine_Functions();
                                $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                                $cost = isset( $wp_travel_engine_setting['trip_price'] ) ? $wp_travel_engine_setting['trip_price']: '';
                                
                                $prev_cost = isset( $wp_travel_engine_setting['trip_prev_price'] ) ? $wp_travel_engine_setting['trip_prev_price']: '';

                                $code = 'USD';
                                if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
                                {
                                    $code = $wp_travel_engine_setting_option_setting['currency_code'];
                                } 
                                $obj = new Wp_Travel_Engine_Functions();
                                $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                                $prev_cost = isset($wp_travel_engine_setting['trip_prev_price']) ? $wp_travel_engine_setting['trip_prev_price']: '';
                                if( $cost!='' && isset($wp_travel_engine_setting['sale']) )
                                {
                                    $obj = new Wp_Travel_Engine_Functions();
                                    echo '<span class="price-holder" itemprop="priceRange"><span>'.esc_attr($currency).esc_attr( $obj->wp_travel_engine_price_format($cost) ).'</span></span>';
                                }
                                else{ 
                                    if( $prev_cost!='' )
                                    {
                                        $obj = new Wp_Travel_Engine_Functions();
                                        echo '<span class="price-holder" itemprop="priceRange"><span>'.esc_attr($currency).esc_attr( $obj->wp_travel_engine_price_format($prev_cost) ).'</span></span>';
                                    }
                                }
                                if( class_exists( 'Wp_Travel_Engine_Group_Discount' ) && isset( $wp_travel_engine_setting['group']['discount'] ) && isset( $wp_travel_engine_setting['group']['traveler'] ) && ! empty( $wp_travel_engine_setting['group']['traveler'] ) ){ ?>
                                        <span class="group-discount"><span class="tooltip"><?php _e( 'You have group discount in this trip.', 'wp-travel-engine' ) ?></span><?php _e( 'Group Discount', 'wp-travel-engine' ) ?></span>
                                        <?php
                                    }
                                    ?>    
                        </div>
                        <div class="text-holder">
                            <?php
                            if(class_exists('Wte_Trip_Review_Init'))
                            { ?>
                                <div class="star-holder">
                                    <?php
                                        global $post;
                                        $comments = get_comments( array(
                                            'post_id' => $post->ID,
                                            'status' => 'approve',
                                        ) );
                                        if ( !empty( $comments ) ){
                                            echo '<div class="review-wrap"><div class="average-rating">';
                                            $sum = 0;
                                            $i = 0;
                                            foreach($comments as $comment) {
                                                $rating = get_comment_meta( $comment->comment_ID, 'stars', true );
                                                $sum = $sum+$rating;
                                                $i++;
                                            }
                                            $aggregate = $sum/$i;
                                            $aggregate = round($aggregate,2);

                                            echo 
                                            '<script>
                                                jQuery(document).ready(function($){
                                                    $(".agg-rating").rateYo({
                                                        rating: '.$aggregate.'
                                                    });
                                                });
                                            </script>';
                                            echo '<div class="agg-rating"></div><div itemprop="aggregateRating" class="aggregate-rating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                            <span class="rating-star" itemprop="ratingValue">'.$aggregate.'</span><span itemprop="reviewCount">'.$i.'</span> '. esc_html( _nx( 'review', 'reviews', $i, 'reviews count', 'wp-travel-engine' ) ) .'</div>';
                                            echo '</div></div><!-- .review-wrap -->';
                                        }
                                    ?>  
                                </div>
                        <?php } ?>
                            <h3 class="title"><a href="<?php echo esc_url( get_the_permalink() );?>"><?php the_title();?></a></h3>
                            <?php
                            $nonce = wp_create_nonce( 'wp-travel-engine-nonce' );
                            ?>
                            <?php
                            if( isset( $wp_travel_engine_setting['trip_duration'] ) && $wp_travel_engine_setting['trip_duration']!='' )
                            { ?>
                                <div class="meta-info">
                                    <span class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <?php echo esc_attr($wp_travel_engine_setting['trip_duration']); if($wp_travel_engine_setting['trip_duration']>1){ _e(' days','wp-travel-engine');} else{ _e(' day','wp-travel-engine'); }
                                        ?>
                                    </span>
                                </div>
                            <?php }
                            if( class_exists('WTE_Fixed_Starting_Dates') ){ 
                                $starting_dates = get_post_meta( get_the_ID(), 'WTE_Fixed_Starting_Dates_setting',true );
                                if( isset( $starting_dates['departure_dates'] ) && ! empty( $starting_dates['departure_dates'] ) && isset($starting_dates['departure_dates']['sdate']) ){ ?>
                                    <div class="next-trip-info">
                                        <?php echo '<h3>'.esc_html__( 'Next Departure', 'wp-travel-engine' ).'</h3>'; ?>
                                        <ul class="next-departure-list">
                                            <?php
                                            global $post;
                                            $WTE_Fixed_Starting_Dates_setting = get_post_meta( $post->ID, 'WTE_Fixed_Starting_Dates_setting', true);
                                            $wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true);
                                            $sortable_settings = get_post_meta( $post->ID, 'list_serialized', true);
                                            $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );

                                            if(!is_array($sortable_settings))
                                            {
                                              $sortable_settings = json_decode($sortable_settings);
                                            }
                                            $today = strtotime(date("Y-m-d"))*1000;
                                            $i = 0;
                                            foreach( $sortable_settings as $content )
                                            {
                                                $new_date = substr( $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id], 0, 7 );
                                                if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['edate'][$content->id])*1000 )
                                                {
                                                    
                                                    $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:3;
                                                    if($i < $num)
                                                    {
                                                        if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                        {
                                                            $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'wp-travel-engine' ) : __( '0 space left', 'wp-travel-engine' );
                                                            echo '<li><span class="left"><i class="fa fa-clock-o"></i>'. date_i18n( get_option( 'date_format' ), strtotime( $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id] ) ).'</span><span class="right">'. esc_html( $remaining) .'</span></li>';
                                                        }
                                                    
                                                    }
                                                $i++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php 
                                } 
                            }
                            ?>
                            <div class="btn-holder">
                                <a href="<?php echo esc_url( get_the_permalink() );?>" class="btn-more"><?php _e('View Details','wp-travel-engine');?></a>
                            </div>
                        </div>
                    </div>
            </div>
        <?php
		endwhile; 
		wp_reset_postdata();
		endif;
		wp_reset_query(); 
		$data = ob_get_clean();
		wp_send_json_success( $data );
		exit;
	}

	/**
	 * AJAX Load More Destination
	 * 
	 */
	function wpte_ajax_load_more_destination() {
		check_ajax_referer( 'wpte-be-load-more-nonce', 'nonce' );
		$wp_travel_engine_setting_option_setting = get_option( 'wp_travel_engine_settings', true );					
		$keys=array_keys($_POST['query']);
		$default_posts_per_page = get_option( 'posts_per_page' );

        $display_count = $default_posts_per_page;

		// // Next, get the current page
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$cat_terms = explode( ',', $_POST['query'] );

		// After that, calculate the offset
		$offset = $_POST['postoffset'];
		if( isset( $_POST['first_class'] ) && $_POST['first_class']!= 'other' )
		{
			$args = array(
	            'post_type'           => 'trip',
	            'order'               => 'ASC',
	            'tax_query'           => array(
	                'relation' => 'AND',
	                array(
	                    'taxonomy'    => 'destination',
	                    'field'       => 'slug',
	                    'terms'       => $cat_terms
	                ),
	                array(
	                    'taxonomy'    => 'activities',
	                    'field'       => 'slug',
	                    'terms'       => array( $_POST['first_class'] )
	                )
	            ),
	            'number'     =>  $display_count,
	  			'page'       =>  $page,
	  			'offset'     =>  $offset
	        );
		}
		elseif( isset($_POST['first_class']) && $_POST['first_class'] == 'other' ){
			$terms = get_terms([
                    'taxonomy' => 'activities',
                    'hide_empty' => false,
                ]);
            foreach ($terms as $key => $value) {
                $activities_terms[] = $value->term_id;
            }
			$args = array(
                'post_type' 	 => 'trip', // Your Post type Name that You Registered
                'order' 		 => 'ASC',
                'tax_query'      => array(
                    'relation'   => 'AND',
                    array(
                        'taxonomy'    => 'destination',
                        'field'       => 'slug',
                        'terms'       => $cat_terms,
                    ),
                    array(
                        'taxonomy'    => 'activities',
                        'field'       => 'id',
                        'terms'       => $activities_terms,
                        'operator'    => 'NOT IN'
                    )
                ),
                'number'     =>  $display_count,
	  			'page'       =>  $page,
	  			'offset'     =>  $offset
            );
		}
		else{
			$terms = get_terms([
                    'taxonomy' => 'activities',
                    'hide_empty' => false,
                ]);
            foreach ($terms as $key => $value) {
                $activities_terms[] = $value->term_id;
            }
			$args = array(
                'post_type' 	 => 'trip', // Your Post type Name that You Registered
                'order' 		 => 'ASC',
                'tax_query'      => array(
                    'relation'   => 'AND',
                    array(
                        'taxonomy'    => 'destination',
                        'field'       => 'slug',
                        'terms'       => $cat_terms,
                    ),
                    array(
                        'taxonomy'    => 'activities',
                        'field'       => 'id',
                        'terms'       => $activities_terms,
                        'operator'    => 'NOT IN'
                    )
                ),
                'number'     =>  $display_count,
	  			'page'       =>  $page,
	  			'offset'     =>  $offset
            );
		}
		ob_start();
		$loop1 = new WP_Query( $args );
		if( $loop1->have_posts() ): while( $loop1->have_posts() ): $loop1->the_post(); 
			global $post;
            $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
			?>
			<div class="col">
                <div class="holder">
                    <div class="img-holder">
                        <a href="<?php echo esc_url( get_the_permalink() );?>" class="trip-post-thumbnail"><?php
                        $trip_feat_img_size = apply_filters('wp_travel_engine_archive_trip_feat_img_size','destination-thumb-trip-size');
                        $feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $trip_feat_img_size );
                        if(isset($feat_image_url[0]))
                        { ?>
                            <img src="<?php echo esc_url( $feat_image_url[0] );?>">
                        <?php
                        }
                        else{ ?>
                            <img src="<?php echo esc_url(  WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/trip-listing-fallback.jpg' );?>">
                        <?php } ?>
                        </a>
                          <?php
                            $code = 'USD';
                            if( isset($wp_travel_engine_setting_option_setting['currency_code']) && $wp_travel_engine_setting_option_setting['currency_code']!='')
                            {
                                $code = esc_attr( $wp_travel_engine_setting_option_setting['currency_code'] );
                            }
                            $obj = new Wp_Travel_Engine_Functions();
                            $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                            $cost = isset( $wp_travel_engine_setting['trip_price'] ) ? $wp_travel_engine_setting['trip_price']: '';
                            
                            $prev_cost = isset( $wp_travel_engine_setting['trip_prev_price'] ) ? $wp_travel_engine_setting['trip_prev_price']: '';

                            $code = 'USD';
                            if( isset( $wp_travel_engine_setting_option_setting['currency_code'] ) && $wp_travel_engine_setting_option_setting['currency_code']!= '' )
                            {
                                $code = $wp_travel_engine_setting_option_setting['currency_code'];
                            } 
                            $obj = new Wp_Travel_Engine_Functions();
                            $currency = $obj->wp_travel_engine_currencies_symbol( $code );
                            $prev_cost = isset($wp_travel_engine_setting['trip_prev_price']) ? $wp_travel_engine_setting['trip_prev_price']: '';
                            if( $cost!='' && isset($wp_travel_engine_setting['sale']) )
                            {
                                $obj = new Wp_Travel_Engine_Functions();
                                echo '<span class="price-holder" itemprop="priceRange"><span>'.esc_attr($currency).esc_attr( $obj->wp_travel_engine_price_format($cost) ).'</span></span>';
                            }
                            else{ 
                                if( $prev_cost!='' )
                                {
                                    $obj = new Wp_Travel_Engine_Functions();
                                    echo '<span class="price-holder" itemprop="priceRange"><span>'.esc_attr($currency).esc_attr( $obj->wp_travel_engine_price_format($prev_cost) ).'</span></span>';
                                }
                            }
                            if( class_exists( 'Wp_Travel_Engine_Group_Discount' ) && isset( $wp_travel_engine_setting['group']['discount'] ) && isset( $wp_travel_engine_setting['group']['traveler'] ) && ! empty( $wp_travel_engine_setting['group']['traveler'] ) ){ ?>
                                    <span class="group-discount"><span class="tooltip"><?php _e( 'You have group discount in this trip.', 'wp-travel-engine' ) ?></span><?php _e( 'Group Discount', 'wp-travel-engine' ) ?></span>
                                    <?php
                                }
                                ?>    
                    </div>
                    <div class="text-holder">
                        <?php
                        if(class_exists('Wte_Trip_Review_Init'))
                        { ?>
                            <div class="star-holder">
                                <?php
                                    global $post;
                                    $comments = get_comments( array(
                                        'post_id' => $post->ID,
                                        'status' => 'approve',
                                    ) );
                                    if ( !empty( $comments ) ){
                                        echo '<div class="review-wrap"><div class="average-rating">';
                                        $sum = 0;
                                        $i = 0;
                                        foreach($comments as $comment) {
                                            $rating = get_comment_meta( $comment->comment_ID, 'stars', true );
                                            $sum = $sum+$rating;
                                            $i++;
                                        }
                                        $aggregate = $sum/$i;
                                        $aggregate = round($aggregate,2);

                                        echo 
                                        '<script>
                                            jQuery(document).ready(function($){
                                                $(".agg-rating").rateYo({
                                                    rating: '.$aggregate.'
                                                });
                                            });
                                        </script>';
                                        echo '<div class="agg-rating"></div><div itemprop="aggregateRating" class="aggregate-rating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                        <span class="rating-star" itemprop="ratingValue">'.$aggregate.'</span><span itemprop="reviewCount">'.$i.'</span> '. esc_html( _nx( 'review', 'reviews', $i, 'reviews count', 'wp-travel-engine' ) ) .'</div>';
                                        echo '</div></div><!-- .review-wrap -->';
                                    }
                                ?>  
                            </div>
                    <?php } ?>
                        <h3 class="title"><a href="<?php echo esc_url( get_the_permalink() );?>"><?php the_title();?></a></h3>
                        <?php
                        $nonce = wp_create_nonce( 'wp-travel-engine-nonce' );
                        ?>
                        <?php
                        if( isset( $wp_travel_engine_setting['trip_duration'] ) && $wp_travel_engine_setting['trip_duration']!='' )
                        { ?>
                            <div class="meta-info">
                                <span class="time">
                                    <i class="fa fa-clock-o"></i>
                                    <?php echo esc_attr($wp_travel_engine_setting['trip_duration']); if($wp_travel_engine_setting['trip_duration']>1){ _e(' days','wp-travel-engine');} else{ _e(' day','wp-travel-engine'); }
                                    ?>
                                </span>
                            </div>
                        <?php }
                        if( class_exists('WTE_Fixed_Starting_Dates') ){ 
                            $starting_dates = get_post_meta( get_the_ID(), 'WTE_Fixed_Starting_Dates_setting',true );
                            if( isset( $starting_dates['departure_dates'] ) && ! empty( $starting_dates['departure_dates'] ) && isset($starting_dates['departure_dates']['sdate']) ){ ?>
                                <div class="next-trip-info">
                                    <?php echo '<h3>'.esc_html__( 'Next Departure', 'wp-travel-engine' ).'</h3>'; ?>
                                    <ul class="next-departure-list">
                                        <?php
                                        global $post;
                                        $WTE_Fixed_Starting_Dates_setting = get_post_meta( $post->ID, 'WTE_Fixed_Starting_Dates_setting', true);
                                        $wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true);
                                        $sortable_settings = get_post_meta( $post->ID, 'list_serialized', true);
                                        $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );

                                        if(!is_array($sortable_settings))
                                        {
                                          $sortable_settings = json_decode($sortable_settings);
                                        }
                                        $today = strtotime(date("Y-m-d"))*1000;
                                        $i = 0;
                                        foreach( $sortable_settings as $content )
                                        {
                                            $new_date = substr( $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id], 0, 7 );
                                            if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['edate'][$content->id])*1000 )
                                            {
                                                
                                                $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:3;
                                                if($i < $num)
                                                {
                                                    if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                    {
                                                        $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'wp-travel-engine' ) : __( '0 space left', 'wp-travel-engine' );
                                                        echo '<li><span class="left"><i class="fa fa-clock-o"></i>'. date_i18n( get_option( 'date_format' ), strtotime( $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id] ) ).'</span><span class="right">'. esc_html( $remaining) .'</span></li>';
                                                    }
                                                
                                                }
                                            $i++;
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php 
                            } 
                        }
                        ?>
                        <div class="btn-holder">
                            <a href="<?php echo esc_url( get_the_permalink() );?>" class="btn-more"><?php _e('View Details','wp-travel-engine');?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		endwhile; 
		endif; 
		wp_reset_postdata();
		$data = ob_get_clean();
		wp_send_json_success( $data );
	}

	function wte_paypal_add_option($options)
	{
		$options[] = 'PayPal';
		return $options;
	}

	function wte_test_add_option($options)
	{
		$options[] = 'Test Payment';
		return $options;
	}

	function do_output_buffer() {
	        ob_start();
	}

	function wte_payment_gateway()
	{
		if( $_POST['val'] == 'Test Payment' )
		{
			ob_start();
			$obj = new Wp_Travel_Engine_Functions();
			$billing_options  = $obj->order_form_billing_options();
			$personal_options = $obj->order_form_personal_options();
			$relation_options = $obj->order_form_relation_options();
			foreach ($billing_options as $key => $value) { ?>
			<div class='wp-travel-engine-billing-details-field-wrap'>
					<?php
					switch ($key) {
						case 'fname':?> 
						<label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'lname':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'email':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'passport':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'address':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'city':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'country':?>
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<select required id="<?php echo esc_attr( $key );?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
								<option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>
								<?php
								$obj = new Wp_Travel_Engine_Functions();
								$options = $obj->wp_travel_engine_country_list();
								foreach ( $options as $key => $val ) {
									echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '">' . esc_html( $val ) . '</option>';
								}
								?>
						</select>
						<?php
						break;	
					}
				 ?>
			</div>
			<?php }
			wp_reset_postdata();
			$data = ob_get_clean();
			wp_send_json_success( $data );
		}

		if( $_POST['val'] == 'PayPal')
		{
			ob_start();
			$obj = new Wp_Travel_Engine_Functions();
			$billing_options  = $obj->order_form_billing_options();
			$personal_options = $obj->order_form_personal_options();
			$relation_options = $obj->order_form_relation_options();
			foreach ($billing_options as $key => $value) { ?>
			<div class='wp-travel-engine-billing-details-field-wrap'>
				<?php
					switch ($key) {
						case 'fname':?> 
						<label for="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'lname':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'email':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'passport':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'address':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'city':?> 
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<input type="<?php echo $value['type'];?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" id="<?php echo esc_attr( $key );?>" <?php if( $value['required'] == '1' ) { echo 'required';   } ?>>	
						<?php
						break;

						case 'country':?>
						<label for="<?php echo esc_attr( $key );?>"><?php _e($value['label'],'wp-travel-engine');?><span class="required">*</span></label>
						<select required id="<?php echo esc_attr( $key );?>" name="wp_travel_engine_booking_setting[place_order][booking][<?php echo esc_attr( $key );?>]" data-placeholder="<?php esc_attr_e( 'Choose a field type&hellip;', 'wp-travel-engine' ); ?>" class="wc-enhanced-select" >
								<option value=" "><?php _e( 'Choose country&hellip;', 'wp-travel-engine' ); ?></option>
								<?php
								$obj = new Wp_Travel_Engine_Functions();
								$options = $obj->wp_travel_engine_country_list();
								foreach ( $options as $key => $val ) {
									echo '<option value="' .( !empty($val)?esc_attr( $val ):"Please select")  . '">' . esc_html( $val ) . '</option>';
								}
								?>
						</select>
						<?php
						break;	
					}
				 ?>
			</div>
			<?php } $wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true ); ?>
			<div id="paypal-form-wrap">
				<div id="paypal-form-inner-wrap">
					<input type="hidden" name="business" value="<?php echo isset($wp_travel_engine_settings['paypal_id']) ? esc_attr($wp_travel_engine_settings['paypal_id']):'';?>">
			        <!-- Specify a Buy Now button. -->
			        <input type="hidden" name="cmd" value="_xclick">
			        <!-- <input type="hidden" name="cmd" value="_notify-validate"> -->
					<input type="hidden" name="rm" value="2">
			        <!-- Specify details about the item that buyers will purchase. -->
			        <input type="hidden" name="item_name" value="<?php $tname = get_the_title( esc_attr( $_SESSION['trip-id'] ) ); echo esc_attr($tname);?>">
			        <input type="hidden" name="item_number" value="<?php echo $_SESSION['trip-id'];?>">
					<?php
					$cost = $_SESSION['trip-cost'];
			        $cost = str_replace(',', '', $cost);
					?>
			        <input type="hidden" id="amount" name="amount" value="<?php echo number_format( sprintf( "%.2f", $cost ), 2, '.', '' );?>">
			        <?php 
		    		$currency_code = isset( $wp_travel_engine_settings['currency_code']) ? esc_attr( $wp_travel_engine_settings['currency_code'] ): 'USD';
			        ?>
			        <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
			        <!-- Specify URLs -->
			        <input type='hidden' name='cancel_return' value='<?php echo site_url(); ?>'>
			        <?php
			        $wp_travel_engine_confirm = isset($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) ? esc_attr($wp_travel_engine_settings['pages']['wp_travel_engine_confirmation_page']) : '';
					$wp_travel_engine_confirm = get_permalink( $wp_travel_engine_confirm );
			        ?>
		        	<input type='hidden' name='return' value='<?php echo esc_url( $wp_travel_engine_confirm )."?ID=".$_SESSION["travelers"]?>'>
		        	<input type='hidden' name='notify_url' value='<?php echo esc_url( $wp_travel_engine_confirm )."?ID=".$_SESSION["travelers"]?>'>
		        </div>
		    </div>
		    <?php
			wp_reset_postdata();
			$data = ob_get_clean();
			wp_send_json_success( $data );
		}
	}

	function wpte_calendar_custom_code()
	{
		global $post;
		if(is_object($post)){
	    	$sortable_settings = get_post_meta( $post->ID, 'list_serialized', true);
			$WTE_Fixed_Starting_Dates_setting = get_post_meta( $post->ID, 'WTE_Fixed_Starting_Dates_setting', true );
			if( isset( $sortable_settings ) )
			{
				if(!is_array($sortable_settings))
				{
			  		$sortable_settings = json_decode($sortable_settings);
				}
			}
			if ( is_singular( 'trip' ) ) {
				if( class_exists( 'WTE_Fixed_Starting_Dates' ) && isset( $WTE_Fixed_Starting_Dates_setting['departure_dates'] ) && isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'] ) )
				{
					$data = '';
		    		$today = strtotime(date("Y-m-d"))*1000;
		    		$i = 0;
					foreach( $sortable_settings as $content )
					{
						if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
						{
							if($i==0)
							{
								$data .= '"'.$WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id].'"';
							}
							else{
								$data .= ',"'.$WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id].'"';
							}
							$i++;
						}
					}
					echo '<script type="text/javascript">
						jQuery(document).ready(function($){
							function addCommas(nStr) {
						        nStr += "";
						        var x = nStr.split(".");
						        var x1 = x[0];
						        var x2 = x.length > 1 ? "." + x[1] : "";
						        var rgx = /(\d+)(\d{3})/;
						        while (rgx.test(x1)) {
						            x1 = x1.replace(rgx, "$1" + "," + "$2");
						        }
						        return x1 + x2;
						    }
							var availableDates = ['.$data.'];
						    $(function()
							{
							    $(".wp-travel-engine-price-datetime").datepicker({ dateFormat: "yy-mm-dd",
								minDate: 0,
						        onSelect: function(){
						        	val = $(this).val();
						            $(".check-availability").hide();
						            $(".book-submit").fadeIn("slow");
						        	$.each(wte_fix_date.cost, function(key, value){
									    $.each(value, function(key, value){
									        if( key == val )
									        {
									        	pno = $(".travelers-no").val();
									        	value = value*pno;
									        	$(".hidden-price").text(addCommas(value));
									        	$(".total-amt .total").text(addCommas(value));
									        	$("#trip-cost").val(value);
									        }
									    });
									});
						        },
							    beforeShowDay:
							      function(dt)
							      { 
							        return [available(dt), ""];
							      }
							   , changeMonth: true, changeYear: false});
							});
							function available(date) {
								if( (date.getMonth()+1) < 10 )
								{
									month = "0"+ (date.getMonth()+1);
								}
								else{
									month = date.getMonth()+1;
								}
								if( date.getDate() < 10 )
								{
									day = "0"+ date.getDate();
								}
								else{
									day = date.getDate();
								}
								dmy = date.getFullYear() + "-" + month + "-" + day ;
								if ($.inArray(dmy, availableDates) != -1) {
								   return true;
								} else {
								   return false;
								}
							}
						});
					</script>';
					
			    }
				else{
					echo 
					'<script type="text/javascript">
						jQuery(document).ready(function($){
							$(".wp-travel-engine-price-datetime").datepicker({
						        dateFormat: "yy-mm-dd",
						        minDate: 0,
						        changeMonth: true,
    							changeYear: false,
						        onSelect: function(){
						            $(".check-availability").hide();
						            $(".book-submit").fadeIn("slow");
						        }
				    		});
				    	});
			    	</script>';
			    }
			}
		}
	}
}

<?php

/**

* Class for trip custom shortcodes.

*/

class WP_Travel_Engine_Custom_Shortcodes
{
	public function __construct() {

		add_shortcode( 'wte_trip', array( $this, 'wte_trip_shortcodes_callback' ) );
		add_shortcode( 'wte_trip_tax', array( $this, 'wte_trip_tax_shortcodes_callback' ) );
		add_action( 'wte_trip_content_action', array( $this, 'wte_trip_content' ) );

	}

	//function to generate shortcode
	function wte_trip_shortcodes_callback( $attr )
	{ 
		$attr = shortcode_atts( array(
          'ids' => '',
          ), $attr, 'wte_trip' );

		if ( ! empty( $attr['ids'] ) ) {
			$ids = array();
			$ids = explode(",", $attr['ids']);
			$attr['ids'] = $ids;
		}

        ob_start();

	    do_action( 'wte_trip_content_action', $attr );

        $output = ob_get_contents();
	    ob_end_clean();

	    if ( $output != '' ) {
			return $output;
		}
	}

	//function to generate shortcode
	function wte_trip_tax_shortcodes_callback( $attr )
	{ 
		$attr = shortcode_atts( array(
			'activities'  => '',
			'destination' => '',
			'trip_types'  => '',
          ), $attr, 'wte_trip_tax' );

		if ( ! empty( $attr['activities'] ) ) {
			$activities         = array();
			$activities         = explode(",", $attr['activities']);
			$attr['activities'] = $activities;
		}

		if ( ! empty( $attr['destination'] ) ) {
			$destination         = array();
			$destination         = explode(",", $attr['destination']);
			$attr['destination'] = $destination;
		}

		if ( ! empty( $attr['trip_types'] ) ) {
			$trip_types         = array();
			$trip_types         = explode(",", $attr['trip_types']);
			$attr['trip_types'] = $trip_types;
		}

        ob_start();

	    do_action( 'wte_trip_content_action', $attr );

        $output = ob_get_contents();
	    ob_end_clean();

	    if ( $output != '' ) {
			return $output;
		}
	}

	function wte_trip_content($atts)
	{
		if ( ! empty( $atts['ids'] ) ) {
			$args = array( 'post__in' => $atts['ids'], 'post_type' => 'trip' );
			$query = new WP_Query( $args );
		}

		if(! empty( $atts['activities'] ) || ! empty( $atts['destination'] ) || ! empty( $atts['trip_types'] ))
		{
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	        $default_posts_per_page = get_option( 'posts_per_page' );
			// Query arguments.
			$args = array(
				'post_type'      				=> 'trip',
				'posts_per_page' 				=> $default_posts_per_page,
				'wpse_search_or_tax_query'      => true,
				'paged' 						=> $paged
		    );

			$taxquery = array('relation' => 'OR');
			if ( ! empty( $atts['activities'] ) ) {
				array_push($taxquery,array(
						'taxonomy'         => 'activities',
						'field'            => 'term_id',
						'terms'            => $atts['activities'],
						'include_children' => false,
					));
			}
			if ( ! empty( $atts['destination'] ) ) {
				array_push($taxquery,array(
						'taxonomy'         => 'destination',
						'field'            => 'term_id',
						'terms'            => $atts['destination'],
						'include_children' => false,
					));
			}
			if ( ! empty( $atts['trip_types'] ) ) {
				array_push($taxquery,array(
						'taxonomy'         => 'trip_types',
						'field'            => 'term_id',
						'terms'            => $atts['trip_types'],
						'include_children' => false,
					));
			}

			if(!empty($taxquery))
			{
	   			$args['tax_query'] = $taxquery;
			}
			$query = new WP_Query( $args );
		}

		if( $query->have_posts() ) :
			?>
			<div class="grid">
				<?php
			   	global $post;
			 	while ( $query->have_posts() ) 
			 	{
					$query->the_post(); 
					$wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
					$wp_travel_engine_setting_option_setting = get_option( 'wp_travel_engine_settings', true ); ?>					
            		<div class="col">
                        <div class="holder">
    	                    <div class="img-holder">
    	                        <a href="<?php echo esc_url( get_the_permalink() );?>"><?php
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
                                        <span class="group-discount"><span class="tooltip"><?php _e( 'You have group discount in this trip.', 'travel-agency-companion' ) ?></span><?php _e( 'Group Discount', 'travel-agency-companion' ) ?></span>
                                        <?php
                                    }
                                ?>
                            </div>                          
                            <div class="text-holder">
                                <?php if( class_exists('Wte_Trip_Review_Init' ) ){ ?>
                                    <div class="star-holder">
                                        <?php
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
                                                <span class="rating-star" itemprop="ratingValue">'.$aggregate.'</span><span itemprop="reviewCount">'.$i.'</span> '. esc_html( _nx( 'review', 'reviews', $i, 'reviews count', 'travel-agency-companion' ) ) .'</div>';
                                                echo '</div></div><!-- .review-wrap -->';
                                            }
                                        ?>  
                                    </div>
                                <?php } ?>       
                                <h3 class="title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
                                <div class="meta-info">                                 
                                    <?php 
                                        if( ( isset( $wp_travel_engine_setting['trip_duration'] ) && '' != $wp_travel_engine_setting['trip_duration'] ) || ( isset( $wp_travel_engine_setting['trip_duration_nights'] ) ) && '' != $wp_travel_engine_setting['trip_duration_nights'] ){
                                            echo '<span class="time"><i class="fa fa-clock-o"></i>'; 
                                            if( $wp_travel_engine_setting['trip_duration'] ) printf( esc_html__( '%s Days', 'travel-agency-companion' ), absint( $wp_travel_engine_setting['trip_duration'] ) ); 
                                            if( $wp_travel_engine_setting['trip_duration_nights'] ) printf( esc_html__( ' - %s Nights', 'travel-agency-companion' ), absint( $wp_travel_engine_setting['trip_duration_nights'] ) ); ;
                                            echo '</span>';                                       
                                        } 
                                    ?>                        
                                </div>

                                <?php
                                    if( class_exists('WTE_Fixed_Starting_Dates') ){
                                        $starting_dates = get_post_meta( get_the_ID(), 'WTE_Fixed_Starting_Dates_setting',true );
                                        if( isset( $starting_dates['departure_dates'] ) && ! empty( $starting_dates['departure_dates'] ) && isset($starting_dates['departure_dates']['sdate']) ){ ?>
                                            <div class="next-trip-info">
                                                <h3><?php esc_html_e( 'Next Departure', 'travel-agency-companion' ); ?></h3>
                                                <ul class="next-departure-list">
                                                    <?php
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
                                                            if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
                                                            {
                                                                
                                                                $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:5;
                                                                if($i < $num)
                                                                {
                                                                    if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                                    {
                                                                        $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'travel-agency-companion' ) : __( '0 space left', 'travel-agency-companion' );
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
				}
				?>
			</div>
			<?php 
			wp_reset_postdata();
		endif;
	}

}
new WP_Travel_Engine_Custom_Shortcodes;

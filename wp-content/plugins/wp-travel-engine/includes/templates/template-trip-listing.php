<?php
   /**
    * The template for displaying trips trip listing page
    *
    * @package Wp_Travel_Engine
    * @subpackage Wp_Travel_Engine/includes/templates
    * @since 1.0.0
    */
   	get_header(); ?>
    <div id="wte-crumbs">
        <?php
        do_action('wp_travel_engine_breadcrumb_holder');
        ?>
    </div>
    <?php
    $wte_trip_tax_post_args = array(
        'post_type' => 'trip',
        'posts_per_page' => -1,
    );
    $wte_trip_tax_post_qry = new WP_Query($wte_trip_tax_post_args);
    global $post;
    if($wte_trip_tax_post_qry->have_posts()) : ?>
    <div class="archive">
        <div id="wp-travel-trip-wrapper" class="trip-content-area" itemscope itemtype="http://schema.org/LocalBusiness">
            <div class="wp-travel-inner-wrapper">
                <div class="wp-travel-engine-archive-outer-wrap">
                    <div class="grid">
                        <?php
                        while($wte_trip_tax_post_qry->have_posts()) :
                            $wte_trip_tax_post_qry->the_post(); 
                            // Start the Loop.
                            // while ( have_posts() ) : the_post();
                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                        
                            $wp_travel_engine_setting = get_post_meta( $post->ID,'wp_travel_engine_setting',true );
                            $wp_travel_engine_setting_option_setting = get_option( 'wp_travel_engine_settings', true ); ?>
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
                                                        $starting_dates = get_post_meta( get_the_ID(), 'WTE_Fixed_Starting_Dates_setting' );
                                                        if( ! empty( $starting_dates ) && $starting_dates[0] != '' && is_array($starting_dates) ){ ?>
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
                                                                        if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
                                                                        {
                                                                            
                                                                            if($i < 2)
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
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
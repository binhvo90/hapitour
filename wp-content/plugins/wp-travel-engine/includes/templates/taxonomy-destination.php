<?php
    /**
    * The template for displaying trips archive page
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
    <div id="wp-travel-trip-wrapper" class="trip-content-area" itemscope itemtype="http://schema.org/LocalBusiness">
        <div class="wp-travel-inner-wrapper">
            <div class="wp-travel-engine-archive-outer-wrap">
                <div class="details">
                    <?php
                    $wp_travel_engine_setting_option_setting = get_option( 'wp_travel_engine_settings', true );                
                    $termID = get_queried_object()->term_id; // Parent A ID
                    $term = get_term( $termID );
                    $taxonomyName = $term->taxonomy;
                    $terms = get_terms('activities');

                    $a = '';
                    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                        foreach ( $terms as $term ) {
                            $act_terms[] = $term->term_id;
                            if( $term->count > 0 )
                            {
                                $a = 1;
                            }
                        }
                    } 

                    $terms = get_terms('activities', array('orderby' => 'date', 'order' => 'ASC'));
                    $wte_trip_cat_slug = get_queried_object()->slug;
                    $wte_trip_cat_name = get_queried_object()->name;
                    ?>
                        <div class="page-header">
                            <div id="wte-crumbs">
                                <?php
                            do_action('wp_travel_engine_beadcrumb_holder');
                            ?>
                            </div>
                            <h2 class="page-title">
                                <?php echo esc_attr( $wte_trip_cat_name ); ?>
                            </h2>
                        </div>
                        <?php 
                        $term_description = term_description( $termID, 'destination' ); ?>
                        <div class="parent-desc">
                            <p>
                                <?php echo isset( $term_description ) ?  $term_description:'';?>
                            </p>
                        </div>
                        <?php
                    $default_posts_per_page = get_option( 'posts_per_page' );
                    $wte_trip_cat_slug = get_queried_object()->slug;
                    foreach( $terms as $term ) {
                        $args = array(
                            'post_type'           => 'trip',
                            'orderby'             => 'date',
                            'order'               => 'ASC',
                            'post_status'         => 'publish',
                            'posts_per_page'      => -1,
                            'tax_query'           => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy'    =>  $taxonomyName,
                                    'field'       => 'slug',
                                    'terms'       => $wte_trip_cat_slug
                                ),
                                array(
                                    'taxonomy'    => 'activities',
                                    'field'       => 'slug',
                                    'terms'       => array( $term->slug )
                                )
                            )
                        );
                        $your_query = new WP_Query($args);
                        $count = $your_query->post_count;
                        $args = array(
                            'post_type'           => 'trip',
                            'orderby'             => 'date',
                            'order'               => 'ASC',
                            'post_status'         => 'publish',
                            'posts_per_page'      => $default_posts_per_page,
                            'tax_query'           => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy'    =>  $taxonomyName,
                                    'field'       => 'slug',
                                    'terms'       => $wte_trip_cat_slug
                                ),
                                array(
                                    'taxonomy'    => 'activities',
                                    'field'       => 'slug',
                                    'terms'       => array( $term->slug )
                                )
                            )
                        );
                        $my_query = new WP_Query($args);
                        if ($my_query->have_posts()) { ?>
                            <h3 class="activity-title"><span><?php echo esc_attr($term->name);?></span></h3>
                            <div class="wrap">
                                <div class="child-desc">
                                    <p>
                                        <?php echo html_entity_decode(term_description( $term->term_id, 'activities' ));?>
                                    </p>
                                </div>
                                <div class="grid <?php echo esc_attr($term->slug);?>" data-id="<?php echo $my_query->max_num_pages; ?>">
                                    <?php
                                        while ($my_query->have_posts()) : $my_query->the_post(); 
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
                                                                        if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
                                                                        {
                                                                            
                                                                            $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:5;
                                                                            if($i < $num)
                                                                            {
                                                                                if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                                                {
                                                                                    $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'wp-travel-engine' ) : __( 'sold out', 'wp-travel-engine' );
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
                                        wp_reset_postdata();wp_reset_query();
                                        if( $count > $default_posts_per_page )
                                        {
                                            echo '<div class="load-destination"><span>'.__('Load More Trips','wp-travel-engine').'</span></div>';
                                        }
                                        ?>
                                </div>
                            </div>

                            <?php
                        } // END if have_posts loop
                        ?>

                                <?php
                //end
            }
                    if($a == '')
                    { 
                        $wte_trip_cat_slug = get_queried_object()->slug;
                        $default_posts_per_page = get_option( 'posts_per_page' );
                        $termID = get_queried_object()->term_id; // Parent A ID
                        $term = get_term_by( 'slug', $wte_trip_cat_slug, 'destination' );
                        $wte_trip_tax_post_args = array(
                            'post_type' => 'trip', // Your Post type Name that You Registered
                            'posts_per_page' => $default_posts_per_page,
                            'order' => 'ASC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'destination',
                                    'field' => 'slug',
                                    'terms' => $wte_trip_cat_slug,
                                    'include_children' => false
                                )
                            )
                        );
                        $wte_trip_tax_post_qry = new WP_Query($wte_trip_tax_post_args);
                        ?>
                        <div class="grid <?php echo $wte_trip_cat_slug; ?>" id="<?php echo $wte_trip_cat_slug; ?>" data-id="<?php echo $wte_trip_tax_post_qry->max_num_pages; ?>">
                            <?php
                                if($wte_trip_tax_post_qry->have_posts()) :
                                    while ($wte_trip_tax_post_qry->have_posts()) : $wte_trip_tax_post_qry->the_post(); 
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
                                                                        if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
                                                                        {
                                                                            
                                                                            $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:5;
                                                                            if($i < $num)
                                                                            {
                                                                                if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                                                {
                                                                                    $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'wp-travel-engine' ) : __( 'sold out', 'wp-travel-engine' );
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
                                if( $term->count > $default_posts_per_page )
                                {
                                    echo '<div class="load-destination"><span>'.__('Load More Trips','wp-travel-engine').'</span></div>';
                                }
                                wp_reset_postdata();
                                ?>
                        </div>
                    <?php    
                    }

                    $args = array(
                        'post_type'           => 'trip',
                        'orderby'             => 'date',
                        'order'               => 'ASC',
                        'post_status'         => 'publish',
                        'posts_per_page'      => $default_posts_per_page,
                        'tax_query'           => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy'    =>  $taxonomyName,
                                'field'       => 'slug',
                                'terms'       => $wte_trip_cat_slug
                            ),
                            array(
                                'taxonomy'    => 'activities',
                                'field'       => 'term_id',
                                'terms'       => $act_terms,
                                'operator'    => 'NOT IN'
                            )
                        )
                    );
                    $my_query = new WP_Query($args);
                    if ($my_query->have_posts()) { ?>
                        <h3 class="activity-title"><span><?php 
                        $other_trips = apply_filters('wp_travel_engine_other_trips_title', __('Other Trips','wp-travel-engine') ); 
                        echo esc_html($other_trips);
                        ?></span></h3>
                        <div class="wrap">
                            <div class="child-desc">
                                <p>
                                    <?php $other_trips_desc = apply_filters('wp_travel_engine_other_trips_desc',__('These are other trips.','wp-travel-engine') ); 
                                    echo esc_html($other_trips_desc);
                                    ?>
                                </p>
                            </div>
                            <div class="grid other" data-id="<?php echo $my_query->max_num_pages; ?>">
                                <?php
                                    while ($my_query->have_posts()) : $my_query->the_post(); 
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
                                                                        if( $today <= strtotime($WTE_Fixed_Starting_Dates_setting['departure_dates']['sdate'][$content->id])*1000 )
                                                                        {
                                                                            
                                                                            $num = isset($wp_travel_engine_setting_option_setting['trip_dates']['number']) ? $wp_travel_engine_setting_option_setting['trip_dates']['number']:5;
                                                                            if($i < $num)
                                                                            {
                                                                                if( isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) )
                                                                                {
                                                                                    $remaining = isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) && ! empty( $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] ) ?  $WTE_Fixed_Starting_Dates_setting['departure_dates']['seats_available'][$content->id] . ' ' . __( 'spaces left', 'wp-travel-engine' ) : __( 'sold out', 'wp-travel-engine' );
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
                                    wp_reset_postdata();wp_reset_query();
                                    if( $count > $default_posts_per_page )
                                    {
                                        echo '<div class="load-destination"><span>'.__('Load More Trips','wp-travel-engine').'</span></div>';
                                    }
                                    ?>
                            </div>
                        </div>
                        <?php
                    } // END if have_posts loop
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php   get_footer();
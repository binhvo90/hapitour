<?php
/**
    * The template for displaying trips according to trip_types .
    *
    * @package Wp_Travel_Engine
    * @subpackage Wp_Travel_Engine/includes/templates
    * @since 1.0.0
    */
    get_header(); ?>
        <div id="wte-crumbs">
           <?php
            $obj = new Wp_Travel_Engine_Functions();
            do_action('wp_travel_engine_breadcrumb_holder');
            ?>
        </div>
        <div id="wp-travel-trip-wrapper" class="trip-content-area" itemscope itemtype="http://schema.org/LocalBusiness">
            <div class="wp-travel-inner-wrapper">
                <div class="wp-travel-engine-archive-outer-wrap">
                    <?php
                    $termID = get_queried_object()->term_id; // Parent A ID
                    $taxonomyName = 'trip_types';
                    $termchildren = get_terms( $taxonomyName );
                    if($termchildren) {
                        ?>
                        <div class="page-header">
                            <h2 class="page-title" data-id="<?php echo $taxonomyName;?>"><?php the_title(); ?></h2>
                            <div class="page-feat-image">
                                <?php
                                $image_id = get_post_thumbnail_id( $post->ID );
                                $activities_banner_size = apply_filters('wp_travel_engine_template_banner_size', 'full');
                                echo wp_get_attachment_image ( $image_id, $activities_banner_size );
                                ?> 
                              </div>
                            <div class="page-content">
                                <p>
                                    <?php global $post; 
                                    $post = get_post($post->ID); 
                                    $content = apply_filters('the_content', $post->post_content); 
                                    echo $content;?>
                                </p>
                            </div>
                        </div>
                        <div class="trip_types-holder">
                            <?php 
                            foreach ($termchildren as $child) {
                                $term = get_term_by( 'id', $child->term_id, 'trip_types' ); 
                                $term_link = get_term_link( $term );
                                $child_term_description = term_description( $term, 'trip_types' );
                                ?> 
                                    <div class="item">
                                        <address itemprop="address" style="display: none;"><?php the_title(); ?></address>
                                        <div itemprop="priceRange" style="display: none;"><?php echo $obj->trip_price($post->ID); ?></div>
                                        <div class="img-holder">
                                                <?php 
                                                $image_id = get_term_meta ( $child->term_id, 'category-image-id', true );
                                                if(isset($image_id) && $image_id!='' )
                                                {
                                                    $activities_thumb_size = apply_filters('wp_travel_engine_activities_img_size', 'activities-thumb-size');
                                                    echo wp_get_attachment_image ( $image_id, $activities_thumb_size );
                                                }
                                                else{
                                                    echo '<img itemprop="image" src="'.esc_url(  WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/activity-trip-type.jpg' ).'">';
                                                }
                                                ?>
                                            <div class="title-holder"><?php echo esc_attr( $term->name );?></div>
                                            <div class="text-holder">
                                                <div class="text">
                                                <h3 class="title" itemprop="name"><?php echo esc_attr( $term->name );?></h3>
                                                <p><?php echo term_description( $child->term_id, 'trip_types' ); ?></p>
                                                </div>
                                                <a class="btn-more" href="<?php echo esc_url( $term_link );?>">&rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php     
                    }
                    else{
                        ?>
                        <div class="page-header">
                            <h2 class="page-title" data-id="<?php echo $taxonomyName;?>"><?php the_title(); ?></h2>
                            <div class="page-feat-image">
                              <?php
                              the_post_thumbnail();
                              ?> 
                            </div>
                            <div class="page-content">
                              <?php
                              global $post; 
                              $post = get_post($post->ID); 
                              $content = apply_filters('the_content', $post->post_content); 
                              echo $content; ?>
                            </div>
                        </div>
                        <?php
                      } 
                    ?>
                </div>
            </div>
        </div>
<?php get_footer();
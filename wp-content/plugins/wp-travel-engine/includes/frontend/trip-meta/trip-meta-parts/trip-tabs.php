<main class="site-main">
<?php
global $post;

while (have_posts()):
    the_post();
    $wp_travel_engine_postmeta_settings = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
    $WTE_Fixed_Starting_Dates_setting = get_post_meta( $post->ID, 'WTE_Fixed_Starting_Dates_setting', true );  
    $wp_travel_engine_settings = get_option('wp_travel_engine_settings', true);
    $obj = new Wp_Travel_Engine_Functions();
    ?>
    <article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> trip-post type-trip status-publish">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name">
                <?php
                the_title(); ?>
                            <?php
                if ( isset($wp_travel_engine_postmeta_settings['trip_duration']) && $wp_travel_engine_postmeta_settings['trip_duration'] != '' )
                {
                    echo ' - ' . $wp_travel_engine_postmeta_settings['trip_duration'];
                    if ($wp_travel_engine_postmeta_settings['trip_duration'] > 1)
                    {
                        _e(' Days', 'wp-travel-engine');
                    }
                    else
                    {
                        _e(' Day', 'wp-travel-engine');
                    }
                } ?>
            </h1>
            <?php do_action('wp_travel_engine_header_hook'); ?>
        </header>
        <!-- .entry-header -->
        <div class="post-thumbnail">
            <?php
	    if (has_action('wp_travel_engine_feat_img_trip_galleries'))
	    {
	        do_action('wp_travel_engine_feat_img_trip_galleries');
	    }
	    else
	    {
	        $trip_feat_img_size = apply_filters('wp_travel_engine_single_trip_feat_img_size', 'trip-single-size');
	        $feat_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID) , $trip_feat_img_size); ?>
	            <img itemprop="image" src="<?php
	        echo esc_url($feat_image_url[0]); ?>" alt="">
	            <?php
	    } ?>
        </div>
        <?php
    /** * wp_travel_engine_trip_category hook. * * @hooked wp_travel_engine_trip_category - 10 (shows trip category) */
    do_action('wp_travel_engine_single_trip_category'); ?>
        <div class="entry-content">
            <?php
            if ( isset( $wp_travel_engine_settings['departure']['section'] ) )
            {
                if( !isset( $WTE_Fixed_Starting_Dates_setting['departure_dates']['section'] ) ){
                    do_action('Wte_Fixed_Starting_Dates_Action');
                }
            } 
            ?>
            <div class="trip-post-content">
                <address itemprop="address" style="display: none;"><?php the_title(); ?></address>
                <div itemprop="priceRange" style="display: none;"><?php echo $obj->trip_price($post->ID); ?></div>
                <?php
                the_content(); 
                ?>
            </div>
            <?php
    ob_start(); $data=''; ?>
            <?php
    do_action('wp_travel_engine_before_trip_tabs');
    global $post;
    if (isset($wp_travel_engine_postmeta_settings) && $wp_travel_engine_postmeta_settings != '')
    {
        $wp_travel_engine_tab_settings = get_option('wp_travel_engine_settings', true);
        if ( isset( $wp_travel_engine_tab_settings['trip_tabs'] ) )
        {
            $tabs = $wp_travel_engine_tab_settings['trip_tabs']['id'];
            if (isset($tabs))
            { ?>
            <div id="tabs-container" class="clearfix">
        <?php
                if (isset($wp_travel_engine_postmeta_settings['tab_content']))
                { ?>
                <div class="nav-tab-wrapper">
                    <div class="tab-inner-wrapper">
                        <?php
                        $arr = array_keys($wp_travel_engine_tab_settings['trip_tabs']['id']);
                        $count = 0;
                        foreach ($arr as $tab => $value)
                        {
                            $tab_id = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
                            $tab_label = explode("_", $tab_id, 2);
                            $first = $tab_label[0];
                            $first = str_replace(' ', '-', $first);
                            $first = strtolower($first);
                            $first = $obj->wpte_clean($first);
                            if (array_key_exists($value, $tabs))
                            {
                                $val = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
                                $tab_tag = preg_replace('/-/', ' ', $val);
                                $val = $obj->wpte_clean($val);
                                $tab_name = $wp_travel_engine_tab_settings['trip_tabs']['name'][$value]; 
                               
                                        if (isset($wp_travel_engine_tab_settings['trip_tabs']['id'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['id'][$value] != '')
                                        { 

                                            switch ($wp_travel_engine_tab_settings['trip_tabs']['field'][$value])
                                            {
                                                case 'wp_editor':
                                                if (isset($wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor']) && $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor'] != '')
                                                {
                                                ?>
                                                    <div class="tab-anchor-wrapper">
                                                        <a href="javascript:void(0);" class="nav-tab nb-tab-trigger<?php
                                                            if ($count == 0)
                                                            { ?> nav-tab-active<?php
                                                            } ?>" data-configuration="<?php
                                                            echo esc_attr($val); ?>">
                                                            <?php
                                                                if (isset($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['icon'][$value] != '')
                                                                {
                                                                    echo '<span class="tab-icon"><i class="' . esc_attr($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) . '"></i></span>';
                                                                } ?>
                                                            <?php
                                                            echo esc_attr($tab_name); ?>
                                                        </a>
                                                    </div>
                                                <?php
                                                $count++;
                                                }
                                                break;
                                                case 'itinerary':
                                                $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                                if (isset($wp_travel_engine_tabs['itinerary']['itinerary_title']) && !empty($wp_travel_engine_tabs['itinerary']['itinerary_title']))
                                                { ?>
                                                    <div class="tab-anchor-wrapper">
                                                        <a href="javascript:void(0);" class="nav-tab nb-tab-trigger<?php
                                                            if ($count == 0)
                                                            { ?> nav-tab-active<?php
                                                            } ?>" data-configuration="<?php
                                                            echo esc_attr($val); ?>">
                                                            <?php
                                                                if (isset($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['icon'][$value] != '')
                                                                {
                                                                    echo '<span class="tab-icon"><i class="' . esc_attr($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) . '"></i></span>';
                                                                } ?>
                                                            <?php
                                                            echo esc_attr($tab_name); ?>
                                                        </a>
                                                    </div>
                                                <?php
                                                $count++;
                                                }
                                                break;
                                                case 'cost':
                                                $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                                if(isset($wp_travel_engine_tabs['cost']['includes_title']) && $wp_travel_engine_tabs['cost']['includes_title'] !='' || isset( $wp_travel_engine_tabs['cost']['excludes_title'] ) && $wp_travel_engine_tabs['cost']['excludes_title'] !='' )
                                                { ?>
                                                    <div class="tab-anchor-wrapper">
                                                        <a href="javascript:void(0);" class="nav-tab nb-tab-trigger<?php
                                                            if ($count == 0)
                                                            { ?> nav-tab-active<?php
                                                            } ?>" data-configuration="<?php
                                                            echo esc_attr($val); ?>">
                                                            <?php
                                                                if (isset($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['icon'][$value] != '')
                                                                {
                                                                    echo '<span class="tab-icon"><i class="' . esc_attr($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) . '"></i></span>';
                                                                } ?>
                                                            <?php
                                                            echo esc_attr($tab_name); ?>
                                                        </a>
                                                    </div>
                                                <?php
                                                $count++;
                                                }
                                                break;
                                                case 'faqs':
                                                    if (isset($wp_travel_engine_tabs['faq']['faq_title']) && !empty($wp_travel_engine_tabs['faq']['faq_title']))
                                                    { ?>
                                                        <div class="tab-anchor-wrapper">
                                                            <a href="javascript:void(0);" class="nav-tab nb-tab-trigger<?php
                                                                if ($count == 0)
                                                                { ?> nav-tab-active<?php
                                                                } ?>" data-configuration="<?php
                                                                echo esc_attr($val); ?>">
                                                                <?php
                                                                    if (isset($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['icon'][$value] != '')
                                                                    {
                                                                        echo '<span class="tab-icon"><i class="' . esc_attr($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) . '"></i></span>';
                                                                    } ?>
                                                                <?php
                                                                echo esc_attr($tab_name); ?>
                                                            </a>
                                                        </div>                                                    
                                                    <?php
                                                    $count++;
                                                    }
                                                break;

                                                case 'review':

                                                    if( class_exists('Wte_Trip_Review_Init') && !isset($wp_travel_engine_settings['trip_reviews']['hide']) )
                                                    {  
                                                        // echo '<h3>' . esc_attr($wp_travel_engine_tabs['faq']['title']) . '</h3>';
                                                        // $obj = new Wte_Trip_Review_Init;
                                                        //     $obj->show_trip_rating($post->ID);
                                                        
                                                        // if( class_exists( 'Wte_Trip_Review_Init' ) )
                                                        // {
                                                        //     $obj = new Wte_Trip_Review_Init;
                                                        //     $obj->show_trip_rating_form();
                                                        // }
                                                        ?>
                                                        <div class="tab-anchor-wrapper">
                                                            <a href="javascript:void(0);" class="nav-tab nb-tab-trigger<?php
                                                                if ($count == 0)
                                                                { ?> nav-tab-active<?php
                                                                } ?>" data-configuration="<?php
                                                                echo esc_attr($val); ?>">
                                                                <?php
                                                                if (isset($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['icon'][$value] != '')
                                                                {
                                                                    echo '<span class="tab-icon"><i class="' . esc_attr($wp_travel_engine_tab_settings['trip_tabs']['icon'][$value]) . '"></i></span>';
                                                                }
                                                                echo esc_attr($tab_name); ?>
                                                            </a>
                                                        </div>
                                                        <?php
                                                        $count++;
                                                    }
                                                break;
                                            }
                                        }
                                    }
                        } ?>
                    </div>
                </div>
                <?php
                }
                if ( isset( $wp_travel_engine_postmeta_settings['tab_content'] ) && $wp_travel_engine_postmeta_settings['tab_content']!='' )
                { ?>
                <div class="tab-content">
                    <?php
                        $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                        $obj = new Wp_Travel_Engine_Functions();
                        $counter = 1;
                        $i = 1;
                        global $post;
                        foreach ($arr as $key => $value)
                        {
                            $tab_id = $wp_travel_engine_tab_settings['trip_tabs']['id'][$value];
                            $tab_label = explode("_", $tab_id, 2);
                            $first = $tab_label[0];
                            $first = str_replace(' ', '-', $first);
                            $first = strtolower($first);
                            $obj = new Wp_Travel_Engine_Functions();
                            $first = $obj->wpte_clean($first);
                            switch ($wp_travel_engine_tab_settings['trip_tabs']['field'][$value])
                            {
                                case 'wp_editor':
                                    if (isset($wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor']) && $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor'] != '')
                                    {
                                        if (isset($wp_travel_engine_tab_settings['trip_tabs']['id'][$value]) && $wp_travel_engine_tab_settings['trip_tabs']['id'][$value] != '')
                                        { ?>
                                            <div class="nb-<?php
                                                                    echo $first; ?>-configurations nb-configurations" <?php
                                                                    if ($i != 1)
                                                                    { ?> style=" display:none;"
                                                <?php
                                                                    } ?>>
                                                <div class="post-data overview">
                                                    <p>
                                                    <?php
                                                        if (isset($wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor']) && $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor'] != '')
                                                        {
                                                            $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor'] = apply_filters('wp_travel_engine_setting', $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor']);
                                                            echo wpautop( html_entity_decode( $wp_travel_engine_postmeta_settings['tab_content'][$first . '_wpeditor'],3,'UTF-8' ) );
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    $i++;
                                    }

                                    break;

                                case 'itinerary': ?>
                    <div class="nb-<?php
                                    echo $first; ?>-configurations nb-configurations" <?php
                                    if ($i != 1)
                                    { ?> style=" display:none;"
                        <?php
                                    } ?>>
                        <div class="post-data itinerary">
                            <?php
                                    $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                    if (isset($wp_travel_engine_tabs['itinerary']['itinerary_title']) && !empty($wp_travel_engine_tabs['itinerary']['itinerary_title']))
                                    {
                                        $maxlen = max(array_keys($wp_travel_engine_tabs['itinerary']['itinerary_title']));
                                        $arr_keys = array_keys($wp_travel_engine_tabs['itinerary']['itinerary_title']);
                                        foreach ($arr_keys as $key => $value)
                                        {
                                            if (array_key_exists($value, $wp_travel_engine_tabs['itinerary']['itinerary_title']))
                                            { ?>
                                            <div class="itinerary-row">
                                                <div class="title">
                                                    <?php
                                                        _e('Day ', 'wp-travel-engine');
                                                                    echo esc_attr($value); ?>
                                                </div>
                                                <div class="itinerary-content">
                                                    <div class="title">
                                                        <?php
                                                            echo (isset($wp_travel_engine_tabs['itinerary']['itinerary_title'][$value]) ? esc_attr($wp_travel_engine_tabs['itinerary']['itinerary_title'][$value]) : ''); 
                                                        ?>
                                                    </div>
                                                    <div class="content">
                                                        <p>
                                                            <?php
                                                            if( isset( $wp_travel_engine_tabs['itinerary']['itinerary_content_inner'][$value] ) && $wp_travel_engine_tabs['itinerary']['itinerary_content_inner'][$value]!='' )
                                                            {
                                                                $content_itinerary = $wp_travel_engine_tabs['itinerary']['itinerary_content_inner'][$value];
                                                            }
                                                            else{
                                                                $content_itinerary = $wp_travel_engine_tabs['itinerary']['itinerary_content'][$value];
                                                            }
                                                            echo html_entity_decode( $content_itinerary ); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                            }
                                        }
                                    $i++;
                                    } ?>
                        </div>
                    </div>
                    <?php
                                    break;

                                case 'cost': if( isset($wp_travel_engine_tabs['cost']['cost_includes_val']) && $wp_travel_engine_tabs['cost']['cost_includes_val']!='' ){?>
                    <div class="nb-<?php
                                    echo $first; ?>-configurations nb-configurations" <?php
                                    if ($i != 1)
                                    { ?> style=" display:none;"
                        <?php
                                    } ?>>
                        <div class="post-data cost">
                            <div class="content">
                                    <?php
                                    $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                    if (isset($wp_travel_engine_tabs['cost']['includes_title']) && $wp_travel_engine_tabs['cost']['includes_title'] != '')
                                    {
                                        echo '<h3>' . esc_attr($wp_travel_engine_tabs['cost']['includes_title']) . '</h3>';
                                    }
                                    ?>
                                <ul id="include-result">
                                    <?php
                                    echo html_entity_decode($wp_travel_engine_tabs['cost']['cost_includes_val']); ?>
                                </ul>
                            </div>
                            <div class="content">
                                    <?php
                                    $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                    if (isset($wp_travel_engine_tabs['cost']['excludes_title']) && $wp_travel_engine_tabs['cost']['excludes_title'] != '')
                                    {
                                        echo '<h3>' . esc_attr($wp_travel_engine_tabs['cost']['excludes_title']) . '</h3>';
                                    }
                                    ?>
                                <ul id="exclude-result">
                                    <?php
                                    echo html_entity_decode($wp_travel_engine_tabs['cost']['cost_excludes_val']); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php $i++; }
                                    break;

                                case 'faqs': if (isset($wp_travel_engine_tabs['faq']['faq_title']) && !empty($wp_travel_engine_tabs['faq']['faq_title']))
                                    {?>
                    <div class="nb-<?php
                                    echo $first; ?>-configurations nb-configurations" <?php
                                    if ($i != 1)
                                    { ?> style=" display:none;"
                        <?php
                                    } ?>>
                        <div class="post-data faq">
                            <a href="#" class="expand-all-faq">
                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                <?php
                                    _e('Expand/Close', 'wp-travel-engine'); ?>
                            </a>
                            <?php
                                    $wp_travel_engine_tabs = get_post_meta($post->ID, 'wp_travel_engine_setting', true);
                                    if (isset($wp_travel_engine_tabs['faq']['title']) && $wp_travel_engine_tabs['faq']['title'] != '')
                                    {
                                        echo '<h3>' . esc_attr($wp_travel_engine_tabs['faq']['title']) . '</h3>';
                                    }

                                    if (isset($wp_travel_engine_tabs['faq']['faq_title']) && !empty($wp_travel_engine_tabs['faq']['faq_title']))
                                    {
                                        $maxlen = max(array_keys($wp_travel_engine_tabs['faq']['faq_title']));
                                        $arr_keys = array_keys($wp_travel_engine_tabs['faq']['faq_title']);
                                        foreach ($arr_keys as $key => $value)
                                        {
                                            if (array_key_exists($value, $wp_travel_engine_tabs['faq']['faq_title']))
                                            { ?>
                            <div id="faq-tabs<?php
                                                echo esc_attr($value); ?>" data-id="<?php
                                                echo esc_attr($value); ?>" class="faq-row">
                                <a class="accordion-tabs-toggle" href="javascript:void(0);">
                                    <span class="dashicons dashicons-arrow-down custom-toggle-tabs rotator"></span>
                                    <div class="faq-title">
                                        <?php
                                                echo (isset($wp_travel_engine_tabs['faq']['faq_title'][$value]) ? esc_attr($wp_travel_engine_tabs['faq']['faq_title'][$value]) : ''); ?>
                                    </div>
                                </a>
                                <div class="faq-content">
                                    <p>
                                        <?php
                                                echo (isset($wp_travel_engine_tabs['faq']['faq_content'][$value]) ? esc_attr($wp_travel_engine_tabs['faq']['faq_content'][$value]) : ''); ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                                            }
                                        }
                                    } ?>
                        </div>
                    </div>
                    <?php
                                $i++;
                                }
                                    break;

                                case 'review':
                                        if( class_exists('Wte_Trip_Review_Init') && !isset($wp_travel_engine_settings['trip_reviews']['hide']) )
                                        {  ?>
                                            <div class="nb-<?php
                                                echo $first; ?>-configurations nb-configurations" <?php
                                                if ($i != 1)
                                                { ?> style=" display:none;"
                                            <?php
                                                } ?>>
                                        <div class="post-data">
                                            <div class="content">
                                            <?php
                                            if(isset($wp_travel_engine_tabs['review']['review_title']) && $wp_travel_engine_tabs['review']['review_title']!='')echo '<h3>' . esc_attr($wp_travel_engine_tabs['review']['review_title']) . '</h3>';
                                            $obj = new Wte_Trip_Review_Init;
                                            $obj->show_trip_rating($post->ID);
                                            
                                            $obj->show_trip_rating_form();
                                            $i++;
                                        ?>
                                        </div>
                                        </div>
                                        </div>
                                        <?php
                                        }
                                break;
                                }

                            } // } // }
                            
?>
                </div>
                <?php
                        //}
                    }

                    if (isset($wp_travel_engine_postmeta_settings['tab_content']))
                    {
                        //if (array_filter($wp_travel_engine_postmeta_settings['tab_content']))
                        //{ ?>
                <?php
//                            }
                        }
                    }
                }
            } ?>
                <!-- .entry-content -->
                <footer class="entry-footer">
                    <?php
            edit_post_link(sprintf( /* translators: %s: id of current post */
            __('Edit
                    <span class="screen-reader-text"> "%s"</span>', 'wp-travel-engine') , get_the_title()) , '
                    <span class="edit-link">', '</span>'); ?>
                </footer>
                <!-- .entry-footer -->
            <?php
            do_action('wp_travel_engine_after_trip_tabs');
            $data .= ob_get_contents();
            ob_end_clean();
            echo $data;
            do_action('display_wte_rich_snippet'); ?>
            </div>
        <!-- </div> -->
    </article>
    <?php
        endwhile; // End of the loop.
?>
</main>
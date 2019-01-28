<?php
	global $post;
	$wpte_trip_images = get_post_meta($post->ID, 'wpte_gallery_id', true);
	if( isset($wpte_trip_images['enable']) && $wpte_trip_images['enable']=='1' ){
		if( isset($wpte_trip_images) && $wpte_trip_images!='' ){ unset($wpte_trip_images['enable']); ?>
		 	<div class='wpte-trip-feat-img-gallery owl-carousel'>
			  	<!-- <div class='feat-img-gallery-holder'> -->
				   		<?php
				    		foreach ($wpte_trip_images as $image) { 
				     			$link = wp_get_attachment_image_src($image, 'large');
				     			$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true);
				     			if( !isset( $image_alt ) || $image_alt=='' ){ $image_alt = get_the_title($image); }
				     			?>
				     			<div class="item" data-thumb="<?php echo $link[0];?>"><img alt="<?php echo esc_attr($image_alt); ?>" itemprop="image" src="<?php echo $link[0];?>"></div>
						    <?php
						    }
				   		?>
			  	<!-- </div> -->
		 	</div>
		<?php 	
		}
	}else{
    	$wp_travel_engine_setting_option_setting = get_option('wp_travel_engine_settings', true);
		$feat_img = isset( $wp_travel_engine_setting_option_setting['feat_img'] ) ? esc_attr( $wp_travel_engine_setting_option_setting['feat_img'] ):'';
	    if( isset($feat_img) && $feat_img!='1' )
	    {
			if( has_post_thumbnail( $post->ID ) )
			{
				$trip_feat_img_size = apply_filters('wp_travel_engine_single_trip_feat_img_size','trip-single-size');
	        	$feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $trip_feat_img_size ); 
	        	$image_alt = get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
				if( !isset( $image_alt ) || $image_alt=='' ){ 
					$image_alt = get_the_title(get_post_thumbnail_id($post->ID)); }
	        	?>
	        	<img alt="<?php echo esc_attr($image_alt); ?>"  itemprop="image" src="<?php echo esc_url( $feat_image_url[0] );?>" alt="">
		<?php
			}
			else{ ?>
				<img alt="<?php the_title(); ?>"  itemprop="image" src="<?php echo WP_TRAVEL_ENGINE_IMG_URL.'/public/css/images/single-trip-featured-img.jpg';?>" alt="">
			<?php
			}
		}
	}
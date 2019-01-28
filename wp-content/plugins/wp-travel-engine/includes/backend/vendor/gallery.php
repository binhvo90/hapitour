<?php
/*
 * @author    Daan Vos de Wael
 * @copyright Copyright (c) 2013, Daan Vos de Wael, http://www.daanvosdewael.com
 * @license   http://en.wikipedia.org/wiki/MIT_License The MIT License
*/
  function wpte_add_gallery_metabox($post_type) {
    $types = array('trip');

    if (in_array($post_type, $types)) {
      add_meta_box(
        'feat-img-gallery-metabox',
        'Featured Image Gallery',
        'wpte_gallery_meta_callback',
        $post_type,
        'normal',
        'high'
      );
    }
  }
  add_action('add_meta_boxes', 'wpte_add_gallery_metabox');

  function wpte_gallery_meta_callback($post) {
    wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
    $ids = get_post_meta($post->ID, 'wpte_gallery_id', true);
    ?>
    <table class='form-table'>
      <tr><td>
        <label for='wpte_gallery_id[enable]'><?php _e('Enable Gallery','wp-travel-engine'); ?></label>
        <input type='checkbox' name='wpte_gallery_id[enable]' id='wpte_gallery_id[enable]' <?php $j = isset( $ids['enable'] ) ? esc_attr( $ids['enable'] ): '0';?> value='1' <?php checked( $j, true ); ?>/>
        <div class="settings-note"><?php _e('Check this to enable gallery instead of featured image in single trip.','wp-travel-engine');?></div>
      </td></tr>
      <tr><td>
        <a class='feat-img-gallery-add button' href='#' data-uploader-title='Add image(s) to gallery' data-uploader-button-text='Add image(s)'><?php _e('Add image(s)','wp-travel-engine');?></a>
        <ul id='feat-img-gallery-metabox-list'>
        <?php if ($ids) : unset($ids['enable']); foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
          <li>
            <input type='hidden' name='wpte_gallery_id[<?php echo $key; ?>]' value='<?php echo $value; ?>'>
            <img class='image-preview' src='<?php echo $image[0]; ?>'>
            <a class='change-image button button-small' href='#' data-uploader-title='Change image' data-uploader-button-text='Change image'>Change image</a><br>
            <small><a class='remove-image' href='#'><?php _e('Remove image','wp-travel-engine');?></a></small>
          </li>
        <?php endforeach; endif; ?>
        </ul>
      </td></tr>
    </table>
  <?php }

  function wpte_gallery_meta_save($post_id) {
    if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;

    if (!current_user_can('edit_post', $post_id)) return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if(isset($_POST['wpte_gallery_id'])) {
      update_post_meta($post_id, 'wpte_gallery_id', $_POST['wpte_gallery_id']);
    } else {
      delete_post_meta($post_id, 'wpte_gallery_id');
    }
  }
  add_action('save_post', 'wpte_gallery_meta_save');

?>
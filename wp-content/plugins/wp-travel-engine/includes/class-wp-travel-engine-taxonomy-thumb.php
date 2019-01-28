<?php

/**
 * Plugin class
 **/
if ( ! class_exists( 'Wp_Travel_Engine_Taxonomy_Thumb' ) ) {

class Wp_Travel_Engine_Taxonomy_Thumb {

  public function __construct() {
    //
  }
 
 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
   add_action( 'destination_add_form_fields', array ( $this, 'wpte_add_category_image' ), 10, 2 );
   add_action( 'created_destination', array ( $this, 'wpte_save_category_image' ), 10, 2 );
   add_action( 'destination_edit_form_fields', array ( $this, 'wpte_update_category_image' ), 10, 2 );
   add_action( 'edited_destination', array ( $this, 'wpte_updated_category_image' ), 10, 2 );

   add_action( 'activities_add_form_fields', array ( $this, 'wpte_add_category_image' ), 10, 2 );
   add_action( 'created_activities', array ( $this, 'wpte_save_category_image' ), 10, 2 );
   add_action( 'activities_edit_form_fields', array ( $this, 'wpte_update_category_image' ), 10, 2 );
   add_action( 'edited_activities', array ( $this, 'wpte_updated_category_image' ), 10, 2 );

   add_action( 'trip_types_add_form_fields', array ( $this, 'wpte_add_category_image' ), 10, 2 );
   add_action( 'created_trip_types', array ( $this, 'wpte_save_category_image' ), 10, 2 );
   add_action( 'trip_types_edit_form_fields', array ( $this, 'wpte_update_category_image' ), 10, 2 );
   add_action( 'edited_trip_types', array ( $this, 'wpte_updated_category_image' ), 10, 2 );
   
   add_action( 'admin_enqueue_scripts', array( $this, 'wpte_load_media' ) );
   add_action( 'admin_footer', array ( $this, 'wpte_add_script' ) );
 }

public function wpte_load_media() {
 wp_enqueue_media();
}
 
 /*
  * Add a form field in the new category page
  * @since 1.0.0
 */
 public function wpte_add_category_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="category-image-id"><?php _e('Image', 'wp-travel-engine'); ?></label>
     <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
     <div id="category-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'wp-travel-engine' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'wp-travel-engine' ); ?>" />
    </p>
   </div>
 <?php
 }
 
 /*
  * Save the form field
  * @since 1.0.0
 */
 public function wpte_save_category_image ( $term_id, $tt_id ) {
    if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
      $image = $_POST['category-image-id'];
      add_term_meta( $term_id, 'category-image-id', $image, true );
    }
 }
 
 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function wpte_update_category_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="category-image-id"><?php _e( 'Image', 'wp-travel-engine' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
       <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
       <div id="category-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'wp-travel-engine' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'wp-travel-engine' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
 public function wpte_updated_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
     $image = $_POST['category-image-id'];
     update_term_meta ( $term_id, 'category-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'category-image-id', '' );
   }
 }

/*
 * Add script
 * @since 1.0.0
 */
 public function wpte_add_script() { ?>
    <script>
     jQuery(document).ready( function($) { 
      var mediaUploader;    
        $('.ct_tax_media_button.button').click(function(e) {
          e.preventDefault();
          if (mediaUploader) {
            mediaUploader.open();
            return;
          }
          mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
            text: 'Choose Image'
          }, multiple: false });


          mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#image-url').val(attachment.url);
            $('#category-image-id').val(attachment.id);
            $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
            var selection = mediaUploader.state().get('selection');
            var selected = '';// the id of the image
            // if (selected) {
            selection.add(wp.media.attachment(selected));
            if (typeof uploadSuccess !== 'undefined') {
            // First backup the function into a new variable.
                var uploadSuccess_original = uploadSuccess;
                // The original uploadSuccess function with has two arguments: fileObj, serverData
                // So we globally declare and override the function with two arguments (argument names shouldn't matter)
                uploadSuccess = function(fileObj, serverData) 
                {
                    // Fire the original procedure with the same arguments
                    uploadSuccess_original(fileObj, serverData);
                    // Execute whatever you want here:
                    alert('Upload Complete!');
                }
            }

            // Hack for "Insert Media" Dialog (new plupload uploader)

            // Hooking on the uploader queue (on reset):
            if (typeof wp.Uploader !== 'undefined' && typeof wp.Uploader.queue !== 'undefined') {
                wp.Uploader.queue.on('reset', function() { 
                    alert('Upload Complete!');
                });
            }
              });
                // Open the uploader dialog
                mediaUploader.open();
            });

        $('body').on('click','.ct_tax_media_remove',function(){
          $('#category-image-id').val('');
          $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
        });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#category-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

  }
$Wp_Travel_Engine_Taxonomy_Thumb = new Wp_Travel_Engine_Taxonomy_Thumb();
$Wp_Travel_Engine_Taxonomy_Thumb -> init();
 
}
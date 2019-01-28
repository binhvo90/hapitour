  jQuery(document).ready(function($){
    $('.tab-inner-wrapper .tab-anchor-wrapper:first-child').addClass('nav-tab-active');
      $('.nb-tab-trigger').click(function(){
         $('.nb-tab-trigger').removeClass('nav-tab-active');
         $('.nb-tab-trigger').parent().removeClass('nav-tab-active');
         $(this).addClass('nav-tab-active');
         $(this).parent().addClass('nav-tab-active');
         var configuration = $(this).data('configuration');
         $('.nb-configurations').hide();
         $('.nb-'+configuration+'-configurations').show();
      });

      function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      }  
    // http://www.entheosweb.com/tutorials/css/tabs.asp
    $(".tab_content").hide();
    $(".tab_content:first").show();

    /* if in tab mode */
    $("ul.tabs li").click(function() {
      $(".tab_content").hide();
      var activeTab = $(this).attr("rel"); 
      $("#"+activeTab).fadeIn();        
        
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");

      $(".tab_drawer_heading").removeClass("d_active");
      $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
    });
    /* if in drawer mode */
    $(".tab_drawer_heading").click(function() {
      $(".tab_content").hide();
      var d_activeTab = $(this).attr("rel"); 
      $("#"+d_activeTab).fadeIn();
      
      $(".tab_drawer_heading").removeClass("d_active");
      $(this).addClass("d_active");
      
      $("ul.tabs li").removeClass("active");
      $("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });
    
    
    /* Extra class "tab_last" 
       to add border to right side
       of last tab */
    $('ul.tabs li').last().addClass("tab_last");
    $(function() {
        var $radios = $('.payment-check');
        if($radios.is(':checked') === false && $radios.is(':visible')) {
            $radios.filter('[value=paypal]').prop('checked', true);
            $('.stripe-button').removeClass('active');
            $('.stripe-button-el').hide();
            $('#wp-travel-engine-order-form').attr( 'action', WP_OBJ.link.paypal_link );
        }
    });

    $('body').on('click', '.paypal-form', function (e){ 
      
      var url = $('.stripe_checkout_app').attr('src');

      //Then assign the src to null, this then stops the video been playing
      $('.stripe_checkout_app').attr('src', '');

      // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
      $('.stripe_checkout_app').attr('src', url);

      $('#wp-travel-engine-order-form').submit();
    });

    $('body').on('click', '.payment-check', function (e){ 
      if($(this).is(':checked')) { 
        if( $(this).attr('value') == 'stripe' )
        {
          $('#wp-travel-engine-order-form').attr( 'action', WP_OBJ.link.form_link );
          $('.paypal-form').hide();
          $('.stripe-form').fadeIn('slow');
          $('.stripe-button').addClass('active');
          $('.stripe-button-el').show();
        } 
        if( $(this).attr('value') == 'paypal' )
        {
          $('#wp-travel-engine-order-form').attr( 'action', WP_OBJ.link.paypal_link );
          $('.stripe-button').removeClass('active');
          $('.stripe-button-el').hide();
          $('.paypal-form').fadeIn('slow');
        } 
      }
    });

    // $('body').on('click', '.check-availability', function (e){ 
    //   if( $('#nestable1').is(':visible') )  {
    //       $('html, body').animate({
    //               scrollTop: $("#nestable1").offset().top
    //            }, 2000);
    //   }
    //   if( $('#nestable1').is(':hidden') )
    //   {
    //       $class = $("#nestable1").parent().parent().parent().attr('class').match(/\d+/);
    //       $('.nb-tab-trigger').removeClass('nav-tab-active');
    //       $('.tab-anchor-wrapper').removeClass('nav-tab-active');
    //       $('.nb-configurations').css('display','none');
    //       $('.nb-' + $class + '-configurations').css('display','block');

    //       $('.nb-tab-trigger[data-configuration=' + $class + ']').addClass('nav-tab-active');
    //       $('.nb-tab-trigger[data-configuration=' + $class + ']').parent().addClass('nav-tab-active');
    //       $('html, body').animate({
    //           scrollTop: $("#nestable1").offset().top
    //        }, 2000);
    //   }
    //   if( $('#nestable1').length < 1 ){
    //       $('.date-time-wrapper').fadeIn('slow');
    //   }
    // });

    // if( $('#nestable1').length < 1 ){
    // }

    $('body').on('click', '.check-availability', function (e){ 
        e.preventDefault();
        $('.date-time-wrapper').fadeIn('slow');
        $('.wp-travel-engine-price-datetime').focus();
    });

    $('body').on('click', '.wp-travel-engine-cart', function (e){ 
      e.preventDefault();
      trip_id = $(this).attr('data-id');
      nonce = $(this).attr('data-nonce');
        jQuery.ajax({
          type : 'post',
          dataType : 'json',
          url : WTEAjaxData.ajaxurl,
          data : {action: 'wp_add_trip_cart', trip_id : trip_id, nonce: nonce},
          success: function(response) {
            if(response.type === 'already') {
              $('.wp-cart-message-'+trip_id).css('color','orange');
              $('.wp-cart-message-'+trip_id).html(response.message).fadeIn('slow').delay(3000).fadeOut('slow');
            }
            else if(response.type === 'success') {
              $('.wp-cart-message-'+trip_id).css('color','green');
              $('.wp-cart-message-'+trip_id).html(response.message).fadeIn('slow').delay(3000).fadeOut('slow');
            }
            else {
              $('.wp-cart-message-'+trip_id).css('color','red');
              $('.wp-cart-message-'+trip_id).html(response.message).fadeIn('slow').delay(3000).fadeOut('slow');
            }
            if($('.wte-update-cart-button-wrapper:visible').length < 1 )
            {
              $('.wte-update-cart-button-wrapper').css('display','block');
            }
          }
        });   
    });

    $('#price-loading').fadeOut(2000);
    $('.price-holder').fadeIn(2000);

    $('body').on('change', '.travelers-number', function (e){ 
      $val = $(this).val();
      $new_val = $(this).parent().parent().siblings('.trip-price-holder').children('.cart-price-holder').text().replace(/,/g, '');
      $total = $val*$new_val;
      $total = addCommas( $total );
      $(this).parent().parent().siblings('.cart-trip-total-price').children('.cart-trip-total-price-holder').text($total);
      $sum = 0;
      $( '.cart-trip-total-price-holder' ).each(function( index ) {
          $tcost = $(this).text().replace(/,/g, '');
          $sum = parseInt($sum) + parseInt($tcost);
      });
      $sum = addCommas($sum);
      $('.total-trip-price').text($sum);
      $value = 0;
      $val1 = parseInt($('span.travelers-number').text());
      $( 'input.travelers-number' ).each(function( index ) {
        if( $(this).val() !=='' )
        {
          $value = parseInt($value) + parseInt($(this).val());
        }
      });
      $travelers = parseInt($value)+parseInt($val1);
      $('.total-trip-travelers').text($travelers);
    });

    $('#wp-travel-engine-cart-form').on('submit', function (e) {
      e.preventDefault();
      var data2 = $('#wp-travel-engine-cart-form').serialize();
      var nonce = $('#update_cart_action_nonce').val();
      jQuery.ajax({
        type: 'post',
        url: WTEAjaxData.ajaxurl,
        data : {action: 'wte_update_cart', nonce: nonce, data2 : data2},
        success: function () {
          $('.wte-update-cart-msg').text(WPMSG_OBJ.ajax.success);
          $('.wte-update-cart-msg').css('color','green').fadeIn('slow').delay(3000).fadeOut('slow');
        }
      });
    });

      $("#wte_payment_options").on('change', function(e){
          var val = $('#wte_payment_options :selected').val();
          e.preventDefault();
          if(val == '')
          {
            return;
          }
        $('#price-loader').fadeIn("slow").delay("3000").fadeOut("3000");
      });
      $('.accordion-tabs-toggle').next().hasClass('show');
      $('.accordion-tabs-toggle').next().removeClass('show');
      $('.accordion-tabs-toggle').next().slideUp(350);
      $(document).on('click','.faq-row .accordion-tabs-toggle', function(){
        var $this = $(this);
        $this.siblings('.faq-content').toggleClass('show');
        $this.toggleClass('active');
        $this.siblings('.faq-content').slideToggle(350);
        $this.find('.dashicons.dashicons-arrow-down.custom-toggle-tabs').toggleClass('open');
      });
      $(document).on('click','.expand-all-faq', function(e){
        e.preventDefault();
        $(this).children('i').toggleClass('fa-toggle-on');
        $('.faq-row .accordion-tabs-toggle').toggleClass('active');
        $('.faq-row').children('.faq-content').toggleClass('show');
        $('.faq-row').children('.faq-content').slideToggle(350);
        $('.faq-row').find('.dashicons.dashicons-arrow-down.custom-toggle-tabs').toggleClass('open');
      });

      $('form[name="wte_enquiry_contact_form"]').submit(function(e){
        e.preventDefault();
        $('#enquiry_submit_button').prop('disabled',true);
        var name = jQuery('#enquiry_name').val();
        var email = jQuery('#enquiry_email').val();
        var contact = jQuery('#enquiry_contact').val();
        var pname = jQuery('#package_name').val();
        var pid = jQuery('#package_id').val();
        var msg = jQuery('#enquiry_message').val();
        var country = jQuery('#enquiry_country').val();
        var adult = jQuery('#enquiry_adult').val();
        var children = jQuery('#enquiry_children').val();
        var confirmation = jQuery('#enquiry_confirmation').val();
        var redirect = jQuery('#redirect-url').val();
        $.ajax({
          dataType : 'json',   
          type: 'post',
          url: WTEAjaxData.ajaxurl,
          data: {action: 'wte_enquiry_send_mail', enquiry_name:name, enquiry_email:email, enquiry_message:msg, enquiry_confirmation:confirmation, enquiry_contact:contact, enquiry_adult:adult, enquiry_children:children, enquiry_country:country, enquiry_pid:pid, enquiry_redirect:redirect,  },
          success: function(response){
            if(response.type === 'success') {
              jQuery(".success-msg").html( response.message ).fadeIn('slow').delay('3000').fadeOut('3000', function()
              {
                jQuery('#enquiry_name').val('');
                jQuery('#enquiry_email').val('');
                jQuery('#enquiry_contact').val('');
                jQuery('#enquiry_message').val('');
                jQuery('#enquiry_adult').val('');
                jQuery('#enquiry_children').val('');
                jQuery('#enquiry_country').prop('selectedIndex',0);
                jQuery('#enquiry_confirmation').prop('checked',false);
                jQuery('#enquiry_submit_button').prop('disabled',false);
                window.location.href = redirect;
              });
            }
            else if(response.type === 'error'){
              jQuery('#enquiry_email').css('border', '1px solid red'); 
              jQuery(".failed-msg").html( response.message ).fadeIn('slow').delay('3000').fadeOut('slow', function()
                  {
                  jQuery('#enquiry_email').css('border', '1px solid #d1d1d1'); 
                  jQuery('#enquiry_submit_button').prop('disabled',false);
                });
            }
            else {
                  jQuery(".failed-msg").html( response.message ).fadeIn('slow').delay('3000').fadeOut('slow', function()
                  {
                  $('#enquiry_submit_button').prop('disabled',false);
                });
              }
          }
        });
      });

      $('#wp-travel-engine-order-form').submit(function(e){
        var form_obj = $(this);
        var other_amt = form_obj.find('input[name=amount]').val();
        if (!isNaN(other_amt) && other_amt.length > 0){
            options_val = other_amt;
            //insert the amount field in the form with the custom amount
            $('<input>').attr({
                type: 'hidden',
                id: 'amount',
                name: 'amount',
                value: options_val
            }).appendTo(form_obj);
        }   
        return;
      });
      $("#wte_payment_options").on('change', function(e){
        var val = $('#wte_payment_options :selected').val();
        e.preventDefault();
        if( val == '' )
        {
          return;
        }
        if( val == 'PayPal' || val == 'Test Payment' )
        {
          jQuery.ajax({
            type: 'post',
            url: WTEAjaxData.ajaxurl,
            data : {action: 'wte_payment_gateway', val : val},
            success: function (response) {
              if(val == 'PayPal')
              {
                $('#wp-travel-engine-order-form').attr('action',Url.paypalurl);
                $( '.wp-travel-engine-billing-details-wrapper' ).html( response.data );
                $( '.stripe-button:visible' ).remove();  
                $( '.stripe-button-el' ).remove();
                $('.wp-travel-engine-submit').show();
                $('.wte-authorize-net-wrap').remove();
              }
              if(val == 'Test Payment')
              {
                $('#wp-travel-engine-order-form').attr('action',Url.normalurl);
                $( '.wp-travel-engine-billing-details-wrapper' ).html( response.data );
                $( '.stripe-button:visible' ).remove();  
                $( '.stripe-button-el' ).remove();
                $('.wp-travel-engine-submit').show();
                $('.wte-authorize-net-wrap').remove();
              }
            }
          });
        }
      });
      $('#wp-travel-engine-order-form').submit(function(e){
        var form_obj = $(this);
        var other_amt = form_obj.find('input[name=amount]').val();
        if (!isNaN(other_amt) && other_amt.length > 0){
            options_val = other_amt;
            //insert the amount field in the form with the custom amount
            $('<input>').attr({
                type: 'hidden',
                id: 'amount',
                name: 'amount',
                value: options_val
            }).appendTo(form_obj);
        }   
        return;
      });
    });

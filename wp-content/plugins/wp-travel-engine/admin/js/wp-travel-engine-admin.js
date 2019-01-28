jQuery(document).ready(function($) {

    $('textarea').removeAttr('required');

    if ($('.trip-row:visible').length < 1) {
        $('.tabs-note').show();
    }

    function toggle_types() {
        $('body').on('change', '.field-type', function(e) {
            if ($(this).find('select option:selected').val() == 'select') {
                $(this).siblings('.select-options').fadeIn('slow');
            } else {
                $(this).siblings('.select-options').hide();
            }

            if ($(this).find('select option:selected').val() == 'text' || $(this).find('select option:selected').val() == 'number' || $(this).find('select option:selected').val() == 'textarea') {
                $(this).siblings('.input-placeholder').fadeIn('slow');
            } else {
                $(this).siblings('.input-placeholder').hide();
            }
        });
    }

    if ($('.trip_facts:visible').length < 1) {
        $('.fields-note').show();
    }

    $('.trip_facts').each(function() {
        if ($(this).is(':visible')) {
            if ($(this).find('select option:selected').val() == 'select') {
                $(this).find('.select-options').show();
                $(this).find('.input-placeholder').hide();
            } else {
                $(this).find('.select-options').hide();
                $(this).find('.input-placeholder').show();
            }
        }
    });

    $('body').on('click', '.del-li', function(e) {
        e.preventDefault();
        var confirmation = confirm(WPTE_OBJ.lang.are_you_sure_fact);
        if (!confirmation) {
            return false;
        }
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
            if ($('.trip_facts:visible').length < 1) {
                $('.fields-note').fadeIn('slow');
            } else {
                $('.fields-note').fadeOut('slow');
            }
        });
    });
    $('body').on('click', '#add_remove_field', function(e) {
        e.preventDefault();
        $('.fields-note').hide('slow');
        var len = 0;
        $('.trip_facts').each(function() {
            var value = $(this).attr('data-id');
            if (!isNaN(value)) {
                value = parseInt(value);
                len = (value > len) ? value : len;
            }
        });
        len++;
        var newinput = $('#trip_facts_outer_template #trip_facts_inner_template').clone();
        newinput.html(function(i, oldHTML) {
            return oldHTML.replace(/{{tripfactsindex}}/g, len);
        });
        $('#writefacts').before(newinput.html());
        $('.fields-note').fadeOut('slow');
    });

    $('.trip-info-list').sortable({
        handle: '.handle'
    });
    $(document).on('click', function(event) {
        var e = event || window.event;
        if ($(event.target).attr('class') == 'trip-tabs-icon' || $(event.target).attr('class') == 'wp-travel-engine-font-awesome-list') {
            return;
        }
        $('.wp-travel-engine-font-awesome-list:visible').fadeOut('slow', function() {
            $(this).remove();
        });
    });

    $('.tabs-custom, .email-custom').tabs();

    $('.nb-tab-trigger').click(function() {
        $('.nb-tab-trigger').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        var configuration = $(this).data('configuration');
        $('.nb-configurations').hide();
        $('.nb-' + configuration + '-configurations').show();
    });

    $('.tabs-menu a').click(function(event) {
        event.preventDefault();
        $(this).parent().addClass('current');
        $(this).parent().siblings().removeClass('current');
        var tab = $(this).attr('href');
        $('.tab-content').not(tab).css('display', 'none');
        $('#' + tab).show();
    });

    $('body').on('click', '#add_remove_tab', function(e) {
        e.preventDefault();
        var maximum = 0;
        $('.trip-row').each(function() {
            var value = $(this).attr('data-id');
            if (!isNaN(value)) {
                value = parseInt(value);
                maximum = (value > maximum) ? value : maximum;
            }
        });
        maximum++;
        var newField = $('#trip-template').clone();
        newField.html(function(i, oldHTML) {
            return oldHTML.replace(/{{index}}/g, maximum);
        });
        newField.find('.tabs-order input').attr('value', maximum);
        newField.find('.tabs-content').addClass('show');
        newField.find('.tabs-content').slideDown('slow');
        newField.find('.tabs-content').css('height', 'auto');

        $('#writetrip').before(newField.html());

        toggle_types();
        $('.tabs-note').fadeOut('slow');
    });



    $('body').on('click', '.delete-tab', function(e) {
        e.preventDefault();
        var confirmation = confirm(WPTE_OBJ.lang.are_you_sure_tab);
        if (!confirmation) {
            return false;
        }
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
        if ($('.trip-row:visible').length < 2) {
            $('.tabs-note').fadeIn('slow');
        } else {
            $('.tabs-note').fadeOut('slow');
        }
    });

    $('body').on('click', '.delete-faq', function(e) {
        e.preventDefault();
        var confirmation = confirm(WPTE_OBJ.lang.are_you_sure_faq);
        if (!confirmation) {
            return false;
        }
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
        if ($('.trip-row:visible').length < 2) {
            $('.tabs-note').fadeIn('slow');
        } else {
            $('.tabs-note').fadeOut('slow');
        }
    });


    $('.tabs-accordion').sortable({
        handle: '.tabs-handle'
    });
    $('.itinerary-accordion').sortable({
        handle: '.itinerary-row'
    });
    $('#2').sortable({
        handle: '.custom-toggle-tabs'
    });
    toggle_types();


    $('.accordion-tabs-toggle').next().hasClass('show');
    $('.accordion-tabs-toggle').next().removeClass('show');
    $('.accordion-tabs-toggle').next().slideUp(350);
    $(document).on('click', '.accordion-tabs-toggle', function() {
        var $this = $(this);
        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
            $this.find('.dashicons.dashicons-arrow-down.custom-toggle-tabs').toggleClass('open');
        } else {
            $this.parent().parent().find('li .inner').removeClass('show');
            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
            $this.find('.dashicons.dashicons-arrow-down.custom-toggle-tabs').toggleClass('open');
        }
    });

    $('body').on('click', '.disable-notif input', function(e) {
        if ($('.disable-notif input').is(':checked')) {
            $('.disable-notif input').attr('value', '1');
        } else {
            $('.disable-notif input').attr('value', '0');
        }
    });
    $('body').on('click', '.disable-payment input', function(e) {
        if ($('.disable-payment input').is(':checked')) {
            $('.disable-payment input').attr('value', '1');
        } else {
            $('.disable-payment input').attr('value', '0');
        }
    });

    if ($('.payment-gateway-options').val() == 'stripe') {
        $('#pay_id').hide();
    }

    if ($('.payment-gateway-options').val() == 'paypal') {
        $('#stripepay_id').hide();
    }

    $('body').on('click', '.wp-travel-engine-setting-sale', function(e) {
        if ($('.wp-travel-engine-setting-sale').is(':checked')) {
            $('.trip-price').fadeIn('slow');
        } else {
            $('.trip-price').fadeOut('slow');
        }
    });

    if ($('.hide-enquiry').is(':checked')) {
        $('.enquiry-subject, .thankyou-page').fadeOut('slow');
    } else {
        $('.enquiry-subject, .thankyou-page').fadeIn('slow');
    }

    $('body').on('click', '.hide-enquiry', function(e) {
        if ($(this).is(':checked')) {
            $('.enquiry-subject, .thankyou-page').fadeOut('slow');
        } else {
            $('.enquiry-subject, .thankyou-page').fadeIn('slow');
        }
    });

    $('.wp-travel-engine-setting-sale').each(function() {
        if ($(this).is(':checked')) {
            $('.trip-price').show();
        } else {
            $('.trip-price').hide();
        }
    });

    $(document).on('click', '.trip-tabs-icon', function() {
        if ($(this).siblings('.wp-travel-engine-font-awesome-list').length < 1) {
            var $iconlist = $('.wp-travel-engine-font-awesome-list-template').clone();
            $(this).after($iconlist.html());
            $(this).siblings('.wp-travel-engine-font-awesome-list').fadeIn('slow');
        }
    });

    $(document).on('keyup', '.trip-tabs-icon', function() {
        var value = $(this).val();
        var matcher = new RegExp(value, 'gi');
        $(this).siblings('.wp-travel-engine-font-awesome-list').find('li').show().not(function() {
            return matcher.test($(this).find('svg').attr('data-icon'));
        }).hide();
    });

    $(document).on('click', '.wp-travel-engine-font-awesome-list li', function(event) {
        var prefix = $(this).children('svg').attr('data-prefix');
        var icon = $(this).children('svg').attr('data-icon');
        var val = prefix + ' fa-' + icon;
        // var val = $(this).children().attr('class');
        $(this).parent().parent().siblings('.trip-tabs-icon').attr('value', val);
        $(this).parent().parent().fadeOut('slow', function() {
            $(this).remove();
        });
        event.preventDefault();
    });

    $(document).on('click', function(e) {
        if ($(event.target).attr('class') == 'trip-tabs-icon') {
            return;
        }
        $('.wp-travel-engine-font-awesome-list:visible').fadeOut('slow', function() {
            $(this).remove();
        });
    });

    $('body').on('click', '.add-info', function(e) {
        e.preventDefault();
        var val = $('#trip_facts').find(':selected').val();
        if (val == '') {
            $('#trip_facts').css('-webkit-box-shadow', 'inset 0px 0px 1px 1px red');
            $('#trip_facts').css('-moz-box-shadow', 'inset 0px 0px 1px 1px red');
            $('#trip_facts').css('box-shadow', 'inset 0px 0px 1px 1px red');
            return;
        } else {
            $('#trip_facts').css('-webkit-box-shadow', 'inset 0px 0px 0px 0px red');
            $('#trip_facts').css('-moz-box-shadow', 'inset 0px 0px 0px 0px red');
            $('#trip_facts').css('box-shadow', 'inset 0px 0px 0px 0px red');
        }
        nonce = $('#trip_facts').attr('data-nonce');
        jQuery.ajax({
            type: 'post',
            url: WTEAjaxData.ajaxurl,
            data: { action: 'wp_add_trip_info', val: val, nonce: nonce },
            beforeSend: function() {
                $("#loader").fadeIn(500);
            },
            success: function(response) {
                $(".trip-info-list").append(response);
            },
            complete: function() {
                $("#loader").fadeOut(500);
            }
        });
    });
    $('.tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');

    $('body').on('click', '.add-itinerary', function(e) {
        e.preventDefault();
        var maximum = 0;
        $('.itinerary-row').each(function() {
            var value = $(this).attr('data-id');
            if (!isNaN(value)) {
                value = parseInt(value);
                maximum = (value > maximum) ? value : maximum;
            }
        });
        maximum++;
        var newField = $('#itinerary-template').clone();
        newField.html(function(i, oldHTML) {
            return oldHTML.replace(/{{index}}/g, maximum);
        });
        newField.find('.itinerary-content').addClass('show');
        newField.find('.itinerary-content').slideDown('slow');
        newField.find('.itinerary-content').css('height', 'auto');
        $('#itinerary-holder').before(newField.html());
        toggle_types();
        
    });

    $('body').on('click', '.add-faq', function(e) {
        e.preventDefault();
        var maximum = 0;
        $('.faq-row').each(function() {
            var value = $(this).attr('data-id');
            if (!isNaN(value)) {
                value = parseInt(value);
                maximum = (value > maximum) ? value : maximum;
            }
        });
        maximum++;
        var newField = $('#faq-template').clone();
        newField.html(function(i, oldHTML) {
            return oldHTML.replace(/{{index}}/g, maximum);
        });
        newField.find('.faq-content').addClass('show');
        newField.find('.faq-content').slideDown('slow');
        newField.find('.faq-content').css('height', 'auto');
        $('#faq-holder').before(newField.html());
        toggle_types();
    });

    $("body").on("keyup", "#cost_includes", function(e) {
        $('#include-result').val($('#cost_includes').val());
        $('#include-result').val('<li>' + $('#include-result').val().replace(/\n/g, '</li><li>') + '</li>');
    });

    $("body").on("keyup", "#cost_excludes", function(e) {
        $('#exclude-result').val($('#cost_excludes').val());
        $('#exclude-result').val('<li>' + $('#exclude-result').val().replace(/\n/g, '</li><li>') + '</li>');
    });

    $("body").on("keyup", ".itinerary-content", function(e) {
        $(this).siblings('.itinerary-content-inner').val($(this).val());
        $(this).siblings('.itinerary-content-inner').val('<p>' + $(this).val().replace(/\n/g, '</p><p>') + '</p>');
    });

    $(document).on('click', '.expand-all-itinerary', function(e) {
        e.preventDefault();
        $(this).children('i').toggleClass('fa-toggle-on');
        $('.itinerary-row').children('.itinerary-content').toggleClass('show');
        $('.itinerary-row').children('.itinerary-content').slideToggle(350);
        $('.itinerary-row').find('.dashicons.dashicons-arrow-down.custom-toggle-tabs').toggleClass('rotator');
    });

    if ($('.paypal-payment').is(':checked')) {
        $('.wte-paypal-gateway-form').fadeIn('slow');
    } else {
        $('.wte-paypal-gateway-form').fadeOut('slow');
    }
    $('body').on('click', '.paypal-payment', function(e) {
        if ($('.paypal-payment').is(':checked')) {
            $('.wte-paypal-gateway-form').fadeIn('slow');
        } else {
            $('.wte-paypal-gateway-form').fadeOut('slow');
        }
    });
    $('table.posts #the-list').sortable({
        'items': 'tr',
        'axis': 'y',
        'helper': fixHelper,
        'update' : function(e, ui) {
            $.post( ajaxurl, {
                action: 'update-menu-order',
                order: $('#the-list').sortable('serialize'),
            });
        }
    });  
    var fixHelper = function(e, ui) {
        ui.children().children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
});
jQuery(document).ready(function($){
    var rtlenable = false;
    if(rtl.enable == '1')
    {
        rtlenable = true;
    }
    $(".wpte-trip-feat-img-gallery").owlCarousel({
        nav     : true,
        navigationText: ['&lsaquo;','&rsaquo;'],
        items   : 1,
        autoplay: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        center  : true,
        loop    : true,
        rtl     : rtlenable,
    });
});
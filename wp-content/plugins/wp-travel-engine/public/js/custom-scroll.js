jQuery(document).ready(function($){
        // // $.fn.isOnScreen = function(){
        // //     var win = $(window);
            
        // //     var viewport = {
        // //         top : win.scrollTop(),
        // //         left : win.scrollLeft()
        // //     };
        // //     viewport.right = viewport.left + win.width();
        // //     viewport.bottom = viewport.top + win.height();
            
        // //     var bounds = this.offset();
        // //     bounds.right = bounds.left + this.outerWidth();
        // //     bounds.bottom = bounds.top + this.outerHeight();
            
        // //     return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
            
        // // };

        // $.fn.isVisible = function() {
        //     // Am I visible?
        //     // Height and Width are not explicitly necessary in visibility detection, the bottom, right, top and left are the
        //     // essential checks. If an image is 0x0, it is technically not visible, so it should not be marked as such.
        //     // That is why either width or height have to be > 0.
        //     var rect = this[0].getBoundingClientRect();
        //     return (
        //         (rect.height > 0 || rect.width > 0) &&
        //         rect.bottom >= 0 &&
        //         rect.right >= 0 &&
        //         rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
        //         rect.left <= (window.innerWidth || document.documentElement.clientWidth)
        //     );
        // };
        // $(window).scroll(function() {
        //    // if ( $('.wp-travel-engine-sidebar').isOnScreen() == false ) {
        //   if ($('.wp-travel-engine-sidebar').isVisible()) {
        //     $('.trip-price').prependTo('#trip-secondary').removeClass('price-fixed');  
        //    }
        //   else
        //   {
        //     $('.trip-price').appendTo('#trip-secondary').addClass('price-fixed');
        //   }
        // });
        $(".trip-price").stick_in_parent();
    });
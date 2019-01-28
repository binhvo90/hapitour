jQuery(document).ready(function($){
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
     
    $('body').on('change', '.travelers-no', function (e){
        $("#price-loading").fadeIn(500);
        $val = $(this).val();
        $new_val = $('.hidden-price').text().replace(/,/g, '');
        $total = $val*$new_val;
        $total = addCommas( $total );
        $('.total').text(addCommas($total));
        $('#trip-cost').val($total);
        $("#price-loading").fadeOut(500);
    });
});
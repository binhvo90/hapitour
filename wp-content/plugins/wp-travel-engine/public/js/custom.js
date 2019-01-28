jQuery(document).ready(function($){
   $('.wp-travel-engine-datetime').datepicker({ maxDate: 0, changeMonth: true,
		changeYear: true, dateFormat: 'yy-mm-dd', yearRange: "-100:+0" });

   // $('.wp-travel-engine-price-datetime').datepicker({
   //      dateFormat: 'yy-mm-dd',
   //      minDate: 0,
   //      onSelect: function(){
   //          $('.check-availability').hide();
   //          $('.book-submit').fadeIn('slow');
   //      }
   //  });
   
	$('body').on('click', '#wp-travel-engine-terms input', function (e){ 
        if ($('#wp-travel-engine-terms input').is( ':checked' )) {
            $('#wp-travel-engine-terms input').attr( 'value','1' );
        }
        else{
            $('#wp-travel-engine-terms input').attr('value','0');
        }
    });
});

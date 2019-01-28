jQuery(document).ready(function($){
	var loading = false;
  	var second_array = [];
  	var count = 1;
  	$('body').on('click', '.btn-loadmore', function (e){ 
  		var tax = $('.page-title').attr('data-id');
	    var button = $(this);
	    var second_class = $(this).parent().attr('class').split(' ')[1];
	    var postoffset = $(this).siblings('.col').length;
	    loading = true;
	    var pages = 1;
	    var found = false;
	    if (second_class in second_array) {
	        second_array[second_class] = second_array[second_class]+1;
	        found = true;
	    }

	    if (!found)
	    {
	      second_array[second_class] = count;
	    }
	    var maxpage = $(this).parent().attr('data-id');
	    var data = {
	      action: 'wpte_ajax_load_more',
	      nonce: beloadmore.nonce,
	      page: second_array[second_class],
	      query: tax,
	      second_class : second_class,
	      postoffset : postoffset
	    };
	    $.post(beloadmore.url, data, function(res) {
	      	if( res.success) {
	      		if(res.data)
	      		{
			        if($('.'+data.second_class+' .btn-loadmore').length)
	          		{
				        $('.'+data.second_class+' .btn-loadmore').before( res.data );
				        if( second_array[second_class] == maxpage-1  )
				        {
				          $('.'+data.second_class+' .btn-loadmore').remove();
				        }
				    }
				    else{
				    	$('#'+second_class+' .btn-loadmore').before( res.data );
			          	if( second_array[second_class] == maxpage-1  )
			          	{
			            	$('#'+second_class+' .btn-loadmore').remove();
			          	}
				    }
			    }
		      	else {
		          	$('.'+data.second_class+' .btn-loadmore').remove();
		      	}
		    }
	    }).fail(function(xhr, textStatus, e) {
	      return false;
	    });
  	});

  	var first_array = [];
  	var count1 = 1;
  	$('body').on('click', '.load-destination', function (e){
  		if($(this).parent().attr('class').split(' ')[1].length)
  		{
	    	var first_class = $(this).parent().attr('class').split(' ')[1];
  		} 
  		else{
  			var first_class = $(this).parent().attr('id');
  		}
	    var postoffset = $(this).siblings('.col').length;
	    loading = true;
	    var pages = 1;
	    var found = false;
	    if (first_class in first_array) {
	        first_array[first_class] = first_array[first_class]+1;
	        found = true;
	    }
	    if (!found)
	    {
	      first_array[first_class] = count1;
	    }
	    if( first_class != $(this).parent().attr('id') )
	    {
		    var data = {
		      action: 'wpte_ajax_load_more_destination',
		      nonce: beloadmore.nonce,
		      page: first_array[first_class],
		      query: beloadmore.query,
		      first_class : first_class,
		      postoffset : postoffset
		    };
		}
		else{
			var data = {
		      action: 'wpte_ajax_load_more_destination',
		      nonce: beloadmore.nonce,
		      page: first_array[first_class],
		      query: beloadmore.query,
		      postoffset : postoffset
		    };
		}
	    var maxpage = $(this).parent().attr('data-id');

	    $.post(beloadmore.url, data, function(res) {
	      if( res.success) {
	        if(res.data)
	        {
	          	if($('.'+data.first_class+' .load-destination').length)
	          	{
		        	$('.'+data.first_class+' .load-destination').before( res.data );
		          	if( first_array[first_class] == maxpage-1  )
		          	{
		            	$('.'+data.first_class+' .load-destination').remove();
		          	}
		      	}
		      	else{
		      		$('#'+first_class+' .load-destination').before( res.data );
		          	if( first_array[first_class] == maxpage-1  )
		          	{
		            	$('#'+first_class+' .load-destination').remove();
		          	}
		      	}
	        }
	        else {
	          $('.'+data.first_class+' .load-destination').remove();
	        }
	      } 
	    }).fail(function(xhr, textStatus, e) {
	      // console.log(xhr.responseText);
	    });
	});	
});
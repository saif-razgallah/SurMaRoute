
$(document).ready(function(){

	//Stickey NavBar
	$(window).scroll(function(){

		var sc=$(this).scrollTop();
		if (sc>50){
			//console.log("100 pixel atteint");
			$('header').addClass('sticky');
		}else{
			$('header').removeClass('sticky');
		}
	});
});

/* Home Timeline*/

jQuery(document).ready(function($){
	var $timeline_block = $('.cd-timeline-block');

	//hide timeline blocks which are outside the viewport
	$timeline_block.each(function(){
		if($(this).offset().top > $(window).scrollTop()+$(window).height()*0.75) {
			$(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
		}
	});

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		$timeline_block.each(function(){
			if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
				$(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});
});


/* fragment */

$(document).ready(function(){
  refreshFragments();
       
       $('a.fragment-link').click(function(e){
    	    e.preventDefault();
    	    $('a.fragment-link.active').removeClass('active');
	        $(this).addClass('active');
	        refreshFragments();
	    });
       
       function refreshFragments(){
    	   $('.page-fragment').hide();
    	   var fragmentToShow = $( 'a.fragment-link.active' ).attr( 'fragment-id' );
    	   $('#'+fragmentToShow).show();
       }

       });

(function($){
	$(document).ready(function(){
		$("#slideshow > div:gt(0)").hide();

		var startLoop = dslideInterval(); 	

		function dslideInterval(){
			setTimeout(dslide,$('#slideshow > div:first').data('duration')*1000);
		}

		function dslide() { 
		  $('#slideshow > div:first')
		    .fadeOut(1000)
		    .next()
		    .fadeIn(1000)
		    .end()
		    .appendTo('#slideshow');
		    dslideInterval();
		}

	});
})(jQuery);
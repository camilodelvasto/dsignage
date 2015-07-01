(function($){
	$(document).ready(function(){
		$("#slideshow").css('height', $(window).height()-220);
		$("#slideshow > div:gt(0)").hide();

		var startLoop = dslideInterval(); 	

		function dslideInterval(){
			setTimeout(dslide,$('#slideshow > div:first').data('duration')*1000);
		}

		function dslide() { 
		  //if identifier==1 increment counter on slideshow and reload page after 10 loops have passed
		  if($('#slideshow > div:first').data('identifier') == 1) {
		  	var loopcounter = $('#slideshow').data('loopcounter')+1;
		  	$( "#slideshow" ).data( "loopcounter", loopcounter );
		  	if(loopcounter==10) {
		  		location.reload();
			  	return;
			  }
		  }
		  //run slideshow and call this function again using the duration as interval of time
		  $('#slideshow > div:first')
		    .fadeOut(1000)
		    .next()
		    .fadeIn(10)
		    .end()
		    .appendTo('#slideshow');
		    dslideInterval();
		}

		//trigger this metod each time the browser window changes
		$(window).on("resize", methodToFixLayout);

		function methodToFixLayout(){
			$("#slideshow").css('height', $(window).height()-220);
			console.log("New height:"+$(window).height());
		}

	});
})(jQuery);
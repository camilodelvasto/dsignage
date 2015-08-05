(function($){
	$(document).ready(function(){
		$("body").fadeIn(500);
		$("#slideshow").css('height', $(window).height());
		$("#slideshow > div:gt(0)").hide();

		if(!$(".tax-displaycategories").length == 0) var startLoop = dslideInterval(); 	

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
				$('#slideshow > div:first').fadeOut(100).delay(3000);
			  	return;
			  }
		  }
		  //run slideshow and call this function again using the duration as interval of time
		  $('#slideshow > div:first')
		    .fadeOut(100)
		    .next()
		    .fadeIn(500)
		    .end()
		    .appendTo('#slideshow');
		    dslideInterval();
		}

		//trigger this metod each time the browser window changes
		$(window).on("resize", methodToFixLayout);

		function methodToFixLayout(){
			$("#slideshow").css('height', $(window).height()-220);
		}

		function displayMap() {
                    document.getElementById('map_canvas').style.display="block";
                    initialize();
                }
	     function initialize() {
	              // create the map

	            var myOptions = {
	                zoom: 14,
	                center: new google.maps.LatLng(0.0, 0.0),
	                mapTypeId: google.maps.MapTypeId.ROADMAP
	              }
	                map = new google.maps.Map(document.getElementById("map_canvas"),
	                                            myOptions);

	             }

	});
})(jQuery);
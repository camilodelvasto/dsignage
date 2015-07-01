(function($){
	$(document).ready(function(){
		$("body").fadeIn(500);
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
		  	if(loopcounter==1) {
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

		$("reload-page").click( function(){
			location.reload();
		});
	});
})(jQuery);

    var viewFullScreen = document.getElementById("view-fullscreen");
    if (viewFullScreen) {
        viewFullScreen.addEventListener("click", function () {
            var docElm = document.documentElement;
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen();
				$("body").css("overflow", "hidden");
            }
            else if (docElm.mozRequestFullScreen) {
                docElm.mozRequestFullScreen();
				$("body").css("overflow", "hidden");
            }
            else if (docElm.webkitRequestFullScreen) {
                docElm.webkitRequestFullScreen();
				$("body").css("overflow", "hidden");
            }
        }, false);
    }

    var cancelFullScreen = document.getElementById("cancel-fullscreen");
    if (cancelFullScreen) {
        cancelFullScreen.addEventListener("click", function () {
            if (document.exitFullscreen) {
                document.exitFullscreen();
				$("body").css("overflow", "scroll");
            }
            else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
				$("body").css("overflow", "scroll");
            }
            else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
				$("body").css("overflow", "scroll");
            }
        }, false);
    }


    var fullscreenState = document.getElementById("fullscreen-state");
    if (fullscreenState) {
        document.addEventListener("fullscreenchange", function () {
            fullscreenState.innerHTML = (document.fullscreenElement)? "" : "not ";
        }, false);
        
        document.addEventListener("mozfullscreenchange", function () {
            fullscreenState.innerHTML = (document.mozFullScreen)? "" : "not ";
        }, false);
        
        document.addEventListener("webkitfullscreenchange", function () {
            fullscreenState.innerHTML = (document.webkitIsFullScreen)? "" : "not ";
        }, false);
    }
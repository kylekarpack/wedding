$(window).load(function() {

	// Even out column heights
	$(".one-third").css("min-height", $(".two-third").outerHeight());
	

	// Highlight the currently active menu item
	var loc = (window.location.href).split("/")[window.location.href.split("/").length - 1].replace(".php", "");
	$("nav a").each(function() {
		if($(this).attr("href").replace("/","").replace(".php", "") == loc) {
			$(this).addClass("active");
		}
	});
	
	
	// Countdown using countdown JS library
	$(".countdown").countdown("2014/01/04 13:00", function(event) {
		var $this = $(this);
		switch(event.type) {
			case "seconds":
			case "minutes":
			case "hours":
			case "days":
			case "weeks":
			case "daysLeft":
				$this.find('span#'+event.type).html(event.value);
			break;
			case "finished":
				$this.hide();
			break;
		}
	});
  
	// sticky navigation
	var aboveHeight = $('header').outerHeight();
	var pad = $('nav').outerHeight();
 
	$(window).scroll(function(){
		//if scrolled down more than the header's height
		if ($(window).scrollTop() > aboveHeight){
                $('nav').addClass('fixed');
				$("body").css("padding-top",pad);
		} else {
	    // when scroll up or less than aboveHeight,
                $('nav').removeClass('fixed');
				$("body").css("padding-top",0);
		}
	});
	
	
	// Even up the heights of those boxes
	function re() {
		$(".us .info").eq(0).css("height", $(".us .info").eq(2).height());
	}
	
	re()
	$(window).on("resize", re);
	
	// Fittext for the date
	$("header .date, .callout").fitText(1.3, { minFontSize: "20px", maxFontSize: "60px"});
	
	
	// Lightbox
	$("#photos img").click(function() {
		var ind = $(this).index();
		var src = $(this).attr("src").replace("thumb", "full");
		$("body").append($("<div class='lightbox'>").html("<div><span class='prev'>&lt;</span><img class='color' src='" + src + "'><span class='next'>&gt;</span><span class='close'>&times;</span></div>").hide().fadeIn());
		$(".lightbox .close").click(function() {
			$(".lightbox").remove();
		});
		$(".next").click(next);
		$(".prev").click(prev);
		$(document).keydown(function(e) {
			if (e.keyCode == 39) {
				next();
			} else if (e.keyCode == 37) {
				prev();
			}
		});
		
		function next() {
			ind++;
			ind > $("#photos img").length ? ind = 0 : "";
			src = $("#photos img").eq(ind).attr("src").replace("thumb", "full");
			$(".lightbox img").attr("src", src);
		}
		
		function prev() {
			ind--;
			ind < 0 ? ind = $("#photos img").length : "";
			src = $("#photos img").eq(ind).attr("src").replace("thumb", "full");
			$(".lightbox img").attr("src", src);
		}
	});
	
	// Hover effects for the gallery
	$("#photos img").mouseenter(function() {
		$(this).addClass("color");
	}).mouseleave(function() {
		$(this).removeClass("color");
	});


	// Registry handling
	$(".reg").click(function(e) {
		e.preventDefault();
		var id = $(this).attr("data-show");
		var top = $("." + id).offset().top - (2* $("nav").outerHeight());
		$("body").animate({scrollTop: top}, 600);
	});

	$(".purchased button").click(function() {
		var $this = $(this);
		$this.siblings().show();
		$.ajax({
			url:"reg_modify.php?index=" + $this.attr("data-id"),
			method:"get",
			success:function(data) {
				data = $.parseJSON(data);

				$this.siblings().hide();

				$this.parent().parent().find(".desired").text(data.remaining);
				if (parseInt(data.remaining) < 1) {
					$this.html("Aww, thanks!").parent().parent().show().delay(1500).slideUp();
				} else {
					$this.html("Bought another?");
				}
			}
		});
	});
	
	

	
	
	
  
	// var navigation = responsiveNav("#nav", { // Selector: The ID of the wrapper
		// animate: true, // Boolean: Use CSS3 transitions, true or false
		// transition: 400, // Integer: Speed of the transition, in milliseconds
		// label: "Menu", // String: Label for the navigation toggle
		// insert: "after", // String: Insert the toggle before or after the navigation
		// customToggle: "", // Selector: Specify the ID of a custom toggle
		// tabIndex: 1, // Integer: Specify the default toggle's tabindex
		// openPos: "relative", // String: Position of the opened nav, relative or static
		// jsClass: "js", // String: 'JS enabled' class which is added to <html> el
		// init: function(){}, // Function: Init callback
		// open: function(){}, // Function: Open callback
		// close: function(){} // Function: Close callback
	// });
  
});


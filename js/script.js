$(document).ready(function() {
	
	// sidebar popovers on click
	$('#notifications a').click(function(){
		$(this).popover({
             'trigger'   : 'manual',
             'animate'   : false,
             'placement' : 'left'
         });
         $(this).popover('toggle');
         return false;
	});
	
	// popovers on hover
	$('.pop').popover({
		'animation' : true,
		'placement' : 'right'
	});
	
	// small tooltip
	$('.tip').tooltip({
		'animation' : true
	});
	
	// button dropdowns
	$('.dropdown-toggle').dropdown();
	
	// modal window
	$('.modal-trigger').click(function(){
		modal();
	});
	
	function modal(){
		$('#mymodal').modal('toggle');
	}
	
	// hide help container
	$('.help-container').hide();
	$('#notifications').css({'height': $(document).height()});
	
	$('.help-container').css({'right': $('#notifications').width() + 21});
	
	// slide help container
	$('.help-trigger, .closer').click(function(){
		$('.help-container').toggle("slide", { direction: "right" }, 500);
	});
	
	// show search box in help slider
	$('.show-search').click(function(){
		$('#search-box').slideToggle(250);
	});
			
	// show hide well divs
	$('.well .inner').hide();
	//$('.show').click(function(){
	//	$(this).next('.inner').slideToggle();
	//	return false;
	//});
	
	// accordion
	$('.sub-nav ul').hide();
	$('.toggle').click(function(){
		$(this).next('ul').slideToggle(300);
		$(this).toggleClass('open');
		return false;
	});
	
	// table sorter
	$(".table").tablesorter({sortList: [[0,0], [1,0]]});
	
});

$(window).resize(function() {
	$('.help-container').css({'right': $('#notifications').width() + 21});
});
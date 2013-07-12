$(document).ready(function(){
	
	$('.box-header').click(function(){
		$(this).next('.box-container-toggle').slideToggle(300);
	}).children().click(function(e){
		window.location.href($(this).attr('href'));
	});
	
	$('.menu-left-accordion .nav-header').click(function(){
		$id = $(this).attr('data-goto');
		$('#'+$id).slideToggle(150);
		$('.nav-list .accordion-item').not('#'+$id).slideToggle(150);
	});
	
	$('.show-actions').hover(function(){
		$(this).find('.actions').stop().fadeToggle(40);
	});

});
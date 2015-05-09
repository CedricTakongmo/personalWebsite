jQuery(function($){
	$(window).on('scroll', function(){
		if( $(window).scrollTop()>205 ){
			$('#sp-menu-wrapper').addClass('menu-fixed');
		} else {
			$('#sp-menu-wrapper').removeClass('menu-fixed');
		}
	});

	$('.sp-main-menu-toggler').on('click', function(e){
		e.preventDefault();
	});

	$('.sp-main-menu-toggler').appendTo('#sp-menu');
	$('.sp-mobile-menu').appendTo('#menu');
});
jQuery(function($){
	$(window).on('scroll', function(){
		if( $(window).scrollTop()>205 ){
			$('#sp-header-wrapper').addClass('header-fixed');
		} else {
			$('#sp-header-wrapper').removeClass('header-fixed');
		}
	});
});
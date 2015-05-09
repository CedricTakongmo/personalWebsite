
//top search
jQuery(function($){
	$("#radon-search-icon").on('click', function(){
		$("#sp-search-wrapper").fadeIn(400);
	});

	$("#search_close").on('click', function(){
		$("#sp-search-wrapper").fadeOut(400);
	});
});
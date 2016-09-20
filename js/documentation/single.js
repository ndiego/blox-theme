jQuery(document).ready(function($){
	
	// Fine for personal use but need error checking for public release
	$( '.single-documentation .content h2' ).each(function() {

		title = $(this).text();
	  	slug  = 'doc_' + title.toLowerCase().replace(/ /g,"_")
	  
	  	$(this).attr( 'id', slug );
	  	
	  	link = '<li><a href="#' + slug + '">' + title + '</a></li>';
	  	
	  	$( '.single-documentation .documentation-toc ol' ).append(link);

	});

});
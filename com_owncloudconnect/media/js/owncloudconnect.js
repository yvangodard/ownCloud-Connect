$(function(){
	/**
	* Chargement de l'iframe
	*/
		
	$('#owncloud-connect-iframe').load(function(){
		$('#ajax-loader').hide();
	    $('#owncloud-connect-iframe').show();
		$('#owncloud-connect-iframe').height($(window).height() - 200);
	});

	/**
	* Iframe Auto-resize
	*/
	$(window).on('resize', function(){
		$('#owncloud-connect-iframe').height($(window).height() - 200);
	});
});
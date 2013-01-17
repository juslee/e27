$(document).ready(function() {

	// Initialize Cufon Custom Fonts
	Cufon.replace('h1', { fontFamily: 'helvthin' });
	Cufon.replace('h2', { fontFamily: 'myriadreg' });
	Cufon.replace('h3', { fontFamily: 'myriadreg' });
	Cufon.replace('h4', { fontFamily: 'myriadreg' });
	Cufon.replace('h5', { fontFamily: 'myriadreg' });
	Cufon.replace('h6', { fontFamily: 'myriadreg' });
	Cufon.replace('h7', { fontFamily: 'myriadreg' });
	Cufon.replace('.button_large', { fontFamily: 'myriadreg' });
	
	// Initialize data tables
	if ($('.datatable').length > 0)
		$('.datatable').dataTable( {
        	"sPaginationType": "full_numbers"
    	} );
    
    // Fade out any message/information boxes
    if ($('.msgbox').length > 0)
    	$('.msgbox').delay(4000).fadeOut(400)
    
    // Initialize WYSIWYG:
    if ($('.wysiwyg').length > 0)
		$('.wysiwyg').redactor(); 
	if ($('.wysiwyg_compact').length > 0)
		$('.wysiwyg_compact').redactor();
	if ($('.wysiwyg_mini').length > 0)
		$('.wysiwyg_mini').redactor({toolbar: 'mini' });
		
	// Initialize Date Picker
	if ($('.date_picker').length > 0)
		$('.date_picker').datepicker({
			defaultDate: "+0",
			changeMonth: true,
			dateFormat: "dd-mm-yy"});
	
	// Initialize Facebox
	if ($('a[rel*=facebox]').length > 0)
		$('a[rel*=facebox]').facebox() ;
    
});
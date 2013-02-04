/* Create a closure to maintain scope of the '$' and remain compatible with other frameworks.  */

(function ($) {

    /* @group same as $(document).ready(); event fires when the DOM is ready */
    $(function () {    

      // Carousel

			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
      });

       
       
       
        
	

  



    });
    /* @end $(document).ready(); */


    /* @group bind window load. events doesn't fire until the document is fully loaded (images and all) */
    $(window).bind("load", function () {

    });
    /* @end: bind window load */

})(jQuery);

/* =End closure */
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	
	
	 <!-- Le styles -->
    <link href="<?php echo get_template_directory_uri(); ?>/themes/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/themes/css/component.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/themes/css/carousel-pagination.css" rel="stylesheet">

    <script src="<?php echo get_template_directory_uri(); ?>/js/plugins/jquery-1.5.1.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/plugins/slides.min.jquery.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	
	<script>
		jQuery(function () {    
		  // Carousel
				jQuery('#slides').slides({
					preload: true,
					preloadImage: '<?php echo get_template_directory_uri(); ?>/img/ajax-loader.gif',
					play: 5000,
					pause: 2500,
					hoverPause: true
		  });
		});

	</script>
	
	<?php wp_head(); ?>
	</head>

  </head>
  <body>
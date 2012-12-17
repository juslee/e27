<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(''); ?></title>
		<style>
		.post.full .post_share, .listing .post_share {
			background: none repeat scroll 0 0 white;
		}
		.post.full .post_share, .listing .post_share {
			background: none repeat scroll 0 0 white;
			margin-right: 15px;
			position: absolute;
			top: 0;
		}
		
		.post.full .post_share.rail, .listing .post_share.rail {
			background: none repeat scroll 0 0 white;
			padding: 4px 8px 0;
			z-index: 11500;
		}
		
		#sharebar {
			background: none repeat scroll 0 0 white;
			border-radius: 3px 3px 3px 3px;
			box-shadow: 0 0 5px #CCCCCC;
			padding: 15px 5px;
		}
		
		div#sharebar.post_share.rail {
			display: block !important;
			float: left !important;
			left:-100px;
			position: absolute !important;
			width: 70px !important;
			z-index: 99 !important;
		}
		</style>
		<?php wp_head(); ?>
	<?php do_action('premise_immediately_after_head'); ?>
		<style>
		#wrap{
			overflow:inherit;
		}
		</style>
	</head>
	<body <?php body_class('full-width-content'); ?>>
		<div id="wrap">
			<?php if(premise_should_have_header_image() && premise_get_header_image()) { ?>
			<div id="header">
				<div class="wrap">
					<?php premise_do_header(); ?>
				</div>
			</div>
			<?php } ?>
			<div id="inner">
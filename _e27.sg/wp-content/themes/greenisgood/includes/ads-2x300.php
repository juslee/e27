<?php if (get_option('eg_ad_center_banner_enable', false) !== false && get_option('eg_ad_center_banner_enable', false) == '1') { ?>
<div id="ads-between-posts" class="clearfix">
	<h4>Sponsored Ads</h4>
	<ul>
		<?php if (get_option('eg_ad_center_ad1_image_location', false) !== false && get_option('eg_ad_center_ad1_image_location', false) != '' && get_option('eg_ad_center_ad1_dest_url', false) !== false && get_option('eg_ad_center_ad1_dest_url', false) != '') { ?>
		<li class="adspace">
			<a href="<?php echo get_option('eg_ad_center_ad1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_center_ad1_image_location', false); ?>" /></a>
		</li>
		<?php } ?>
		<?php if (get_option('eg_ad_center_ad2_image_location', false) !== false && get_option('eg_ad_center_ad2_image_location', false) != '' && get_option('eg_ad_center_ad2_dest_url', false) !== false && get_option('eg_ad_center_ad2_dest_url', false) != '') { ?>
		<li class="adspace">
			<a href="<?php echo get_option('eg_ad_center_ad2_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_center_ad2_image_location', false); ?>" /></a>
		</li>
		<?php } ?>
		<?php if (get_option('eg_ad_center_ad3_image_location', false) !== false && get_option('eg_ad_center_ad3_image_location', false) != '' && get_option('eg_ad_center_ad3_dest_url', false) !== false && get_option('eg_ad_center_ad3_dest_url', false) != '') { ?>
		<li class="adspace">
			<a href="<?php echo get_option('eg_ad_center_ad3_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_center_ad3_image_location', false); ?>" /></a>
		</li>
		<?php } ?>
		<?php if (get_option('eg_ad_center_ad4_image_location', false) !== false && get_option('eg_ad_center_ad4_image_location', false) != '' && get_option('eg_ad_center_ad4_dest_url', false) !== false && get_option('eg_ad_center_ad4_dest_url', false) != '') { ?>
		<li class="adspace">
			<a href="<?php echo get_option('eg_ad_center_ad4_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_center_ad4_image_location', false); ?>" /></a>
		</li>
		<?php } ?>
	</ul>
</div>
<?php } ?>
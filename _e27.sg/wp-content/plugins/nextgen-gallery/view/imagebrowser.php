<?php 
/**
Template Page for the image browser

Follow variables are useable :

	$image : Contain all about the image 
	$meta  : Contain the raw Meta data from the image 
	$exif  : Contain the clean up Exif data 
	$iptc  : Contain the clean up IPTC data 
	$xmp   : Contain the clean up XMP data 

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($image)) : ?>
<style>	
.post.full .ngg-imagebrowser img {
	border: 1px solid #F0F0F0;
	margin:0px !important;
	width: inherit;
}
</style>
<div class="ngg-imagebrowser" id="<?php echo $image->anchor ?>">
	<?php
	/*
	?>
	<!--<h3><?php echo $image->alttext ?></h3>-->
	
	<!--
	<div class="ngg-imagebrowser-nav"> 
		
	</div>	
	-->
	<?php
	*/
	?>
	
	<div class="pic">
	<a style='font-size:5px;'>&nbsp;</a>
	<table style='width:100%'>
		<tr>
			<td valign="top" style='width:75%; vertical-align:top; padding:10px;'>
				<b><?php echo $image->description ?></b>
			</td>
			<td valign="top" style='width:25%; text-align:center; vertical-align:top;'>
				<center>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td width='34px' style='vertical-align:top;'>
							<a href="<?php echo $image->previous_image_link ?>"><img style='margin:0px !important; padding:0px; width:34px; height:34px;  border:0px; vertical-align:top;' src='/wp-content/plugins/nextgen-gallery/images/prev.jpg' /></a>&nbsp;
						</td>
						<td width='50px' style='vertical-align:top; padding-top:10px; text-align:center; color:#21913E'>
							<?php echo $image->number ?> / <?php echo $image->total ?>
						</td>
						<td  width='34px' style='vertical-align:top;'>
							<a href="<?php echo $image->next_image_link ?>"><img style='margin:0px !important; padding:0px;  width:34px; height:34px; border:0px; vertical-align:top; ' src='/wp-content/plugins/nextgen-gallery/images/next.jpg' /></a>
						</td>
					</tr>
				</table>
				</center>
			</td>
		</tr>
		<tr>
			<td valign="top" style='vertical-align:top; padding:10px; text-align:center' colspan='2'>
			<center>
			 <?php 
			 //echo "<pre>";
			 //print_r($image);
			 $link = str_replace(".jpg", ".jpg?_".time(),$image->href_link);
			 $link = str_replace(".JPG", ".JPG?_".time(),$link);
			 echo $link;
			 
			 ?>
			</center>
			</td>
		</tr>
	</table>

		
	</div>
	

</div>	

<?php endif; ?>
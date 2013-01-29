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
	<script>
		ngindex = 0;
		ngpids = [];
		<?php
		foreach($images as $image){
			?>ngpids.push(<?php echo $image->pid; ?>);
			<?php
		}
		?>
		function ngHideAll(){
			for(i=0; i<ngpids.length; i++){
				jQuery("#ng"+ngpids[i]).hide();
			}
		}
		function ngPrev(){
			if(ngindex==0){
				return 0;
			}
			ngHideAll();
			ngindex--;
			self.location = "#image_"+(ngindex+1);
			jQuery("#ng"+ngpids[ngindex]).show();
			jQuery("#ngdescription").html(jQuery("#ng"+ngpids[ngindex]+" a").attr("title"));
			jQuery("#ngcounter").html((ngindex+1)+" / "+ngpids.length);
		}
		function ngNext(){
			if(ngindex+1==ngpids.length){
				return 0;
			}
			ngHideAll();
			ngindex++;
			self.location = "#image_"+(ngindex+1);
			jQuery("#ng"+ngpids[ngindex]).show();
			jQuery("#ngdescription").html(jQuery("#ng"+ngpids[ngindex]+" a").attr("title"));
			jQuery("#ngcounter").html((ngindex+1)+" / "+ngpids.length);
		}
		function showNgGallery(n){
			if(n){
				ngindex = n;
			}
			else{
				ngindex = 0;
			}
			self.location = "#image_"+(ngindex+1);
			jQuery(".description p").each(function(){
				jQuery(this).hide();
			});
			jQuery(".description h3").each(function(){
				jQuery(this).hide();
			});
			jQuery("#nggallery").show();
			ngHideAll();
			jQuery("#ng"+ngpids[ngindex]).show();
			jQuery("#ngdescription").html(jQuery("#ng"+ngpids[ngindex]+" a").attr("title"));
			jQuery("#ngcounter").html((ngindex+1)+" / "+ngpids.length);
		}
		function hideNgGallery(){
			window.location.hash = "";
			jQuery(".description p").each(function(){
				jQuery(this).show();
			});
			jQuery(".description h3").each(function(){
				jQuery(this).show();
			});
			jQuery("#nggallery").hide();
		}
	</script>
	
	<div>
	<a onclick='showNgGallery()' style='cursor:pointer'>
	<?php
	foreach($images as $image){
		echo stripslashes($image->galdesc)." &raquo;";
		break;
	}
	
	?></a>
	</div>
	<div class="pic" id='nggallery' style='display:none'>
	<a style='font-size:5px;'>&nbsp;</a>
	<table style='width:100%'>
		<tr>
			<td valign="top" style='width:75%; vertical-align:top; padding:10px;'>
				<table cellpadding="0" cellspacing="0" style='width:100%;' name='image_1'>
				<tr>
					<td> 
						<div style='font-weight:bold' id='ngdescription'></div>
					</td>
					<td style='vertical-align:top; text-align:right; width:120px; font-size:14px;'>
							<a onclick='hideNgGallery()' style='cursor:pointer'>&laquo; Back to Article</a>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" style='width:25%; text-align:center; vertical-align:top;'>
				<center>
				<table cellpadding="0" cellspacing="0">
					<tr>
						
						<td width='34px' style='vertical-align:top;'>
							<a style='cursor:pointer' onclick='ngPrev()'><img style='margin:0px !important; padding:0px; width:34px; height:34px;  border:0px; vertical-align:top;' src='/wp-content/plugins/nextgen-gallery/images/prev.jpg' /></a>&nbsp;
						</td>
						<td width='50px' style='vertical-align:top; padding-top:10px; text-align:center; color:#21913E' id='ngcounter'>
							
						</td>
						<td  width='34px' style='vertical-align:top;'>
							<a style='cursor:pointer' onclick='ngNext()'><img style='margin:0px !important; padding:0px;  width:34px; height:34px; border:0px; vertical-align:top; ' src='/wp-content/plugins/nextgen-gallery/images/next.jpg' /></a>
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
			 
			 $i = 0;
			 foreach($images as $image){
				$link = str_replace(".jpg", ".jpg?_".time(),$image->imageHTML);
				$link = str_replace(".JPG", ".JPG?_".time(),$link);
				if($i==0){
					echo "<div id='ng".$image->pid."'>";
					echo $link;
					echo "</div>";
				}
				else{
					echo "<div id='ng".$image->pid."' style='display:none'>";
					echo $link;
					echo "</div>";
				}
				$i++;
			 }
			 ?>
			</center>
			</td>
		</tr>
	</table>
	<script>
		if(window.location.hash){
			ngindex = window.location.hash;
			ngindex = ngindex.replace("#image_", "");
			ngindex = ngindex*1;
			ngindex -= 1;
			if(ngindex+1==ngpids.length){
				ngindex = ngpids.length-1;
			}
			if(ngindex<=0){
				ngindex = 0;
			}
			
			showNgGallery(ngindex);
		}
	</script>
		
	</div>
</div>	
<br />
<br />
<br />
<?php endif; ?>
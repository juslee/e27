<script>
var start = <?php
$t = count($companies);
echo $t;
?>;
var total = <?php echo $cnt; ?>;
function loadMore(){
	jQuery("#loadmorebutton").hide();
	jQuery("#loadmoreloader").show();
	jQuery.ajax({
		url: "<?php echo site_url(); ?>startuplist/ajax_loadmore/"+start,
		type: "POST",
		data: "",
		dataType: "script",
		success: function(){
			
		}
	});

}
</script>
<table cellpadding="0" cellspacing="0" class="p100 contentshead">
	<tr>
		<td class="contentsheadleft">
			<img src="<?php echo site_url(); ?>media/startuplist/newlyaddedstartups.png">
		</td>
		<td class="contentsheadright right">
				<ul style="padding:0px">
					<li class="outer"><a href="#" style="padding-right:0px;">FILTERS<img style="margin-left:8px;" src="<?php echo site_url(); ?>media/startuplist/filterdown.png"></a>
						<ul>
							<li class="inner"><a href="#">NEWLY ADDED</a></li>
							<li class="inner"><a href="#">NEWLY UPDATED</a></li>
						</ul>
					</li>
				</ul>
		</td>
	</tr>
</table>
<?php
if($cnt){
	?>
	<table cellpadding="0" cellspacing="0" class="p100" id="companies">
		<?php
		
		for($i=0; $i<$t; $i++){
			?>
			<tr>
			<?php 
			for($n=0; $n<4; $n++){
				
				$class = "";
				if($n==0){
					$class = "first";
				}
				else if($n==3){
					$class = "last";
				}
				if($companies[$i]['id']){
					?>
					<td width="25%">
						<table cellpadding="0" cellspacing="0" class='contentblock <?php echo $class;?>'>
							<tr>
								<td class="head"><a href="<?php echo site_url(); ?>startuplist/company/<?php echo $companies[$i]['id']; ?>"><?php echo htmlentities($companies[$i]['name']) ?></a></td>
							</tr>
							<tr>
								<td class="logo">
								<a href="<?php echo site_url(); ?>startuplist/company/<?php echo $companies[$i]['id']; ?>" title="<?php echo sanitizeX($companies[$i]['name'])?>" alt="<?php echo sanitizeX($companies[$i]['name'])?>">
								<?php
								if(trim($companies[$i]['logo'])){
									?>
									<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $companies[$i]['logo'] ?>&mx=168' />
									<?php
								}
								else{
									?>
									<img src='<?php echo site_url(); ?>media/startuplist/noimage.jpg' />
									<?php	
								}
								?>
								</a>
								</td>
							</tr>
							<tr>
								<td class="content">
								
								</td>
							</tr>
						</table>
					</td>
					<?php
				}
				else{
					?>
					<td width="25%">
						
					</td>
					<?php
				}
				if($n<3){
					$i+=1;
				}
			}
			?>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
	if($cnt>$t){
		?>
		<div class="loadmore">
		<img src="<?php echo site_url(); ?>media/startuplist/load_more.png" onclick="loadMore()" class="pointer" id="loadmorebutton">
		<div id="loadmoreloader" style="display:none"><img src="<?php echo site_url(); ?>media/ajax-loader.gif" /></div>
		</div>
		<?php
	}
}
?>
<script>
var start = <?php
$t = count($companies);
echo $t;
?>;
var type = "<?php echo $type; ?>";
var total = <?php echo $cnt; ?>;
function loadMore(){
	jQuery("#loadmorebutton").hide();
	jQuery("#loadmoreloader").show();
	jQuery.ajax({
		url: "<?php echo site_url(); ?>startuplist/ajax_loadmore/"+start+"/"+type,
		type: "POST",
		data: "",
		dataType: "script",
		success: function(){
			
		}
	});

}
</script>
<table cellpadding="0" cellspacing="0" class="contentshead">
	<tr>
		<td class="contentsheadleft">
			<!--<img src="<?php echo site_url(); ?>media/startuplist/newlyaddedstartups.png">-->
			<?php
			
			if($type=="newlyadded"){
				?>Newly Added Startups<?php
			}
			else if($type=="newlyupdated"){
				?>Newly Updated Startups<?php
			}
			
			?>
		</td>
		<td class="contentsheadright" id="filter">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="100%" style='text-align:right; vertical-align:middle; padding-right:40px;'>
						<table class='right' >
						<tr>
							<td style='vertical-align:middle; padding:10px'>Country: </td>
							<td class='f32'><div class='flag' id='theflag'></div></td>
							<td style='vertical-align:middle; padding:3px' id='thecountry' class='selectcountry pointer'>Singapore</td>
							<td style='vertical-align:middle; padding:10px' class='selectcountry pointer'><img src='<?php echo site_url();?>media/startuplist/filterdown_gray.png' /></td>
						</tr>
						</table>
						<div style='position:relative'>
							
							<div id='flags' class='hidden' style='position:absolute; top:40px; left:110px; width: 120px; padding:10px; background:white;  border:1px solid #21913F'>
								<div style='position:absolute;  height:20px; width:150px; top:-20px;' ></div>
								<table cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td class='f32'>
											<div class='flag sg' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/singapore'>Singapore</a>
										</td>
									</tr>
									<tr>
										<td class='f32'>
											<div class='flag id' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/indonesia'>Indonesia</a>
										</td>
									</tr>
									<tr>
										<td class='f32'>
											<div class='flag jp' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/japan'>Japan</a>
										</td>
									</tr>
									<tr>
										<td class='f32'>
											<div class='flag my' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/malaysia'>Malaysia</a>
										</td>
									</tr>
									<tr>
										<td class='f32'>
											<div class='flag ph' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/philippines'>Philippines</a>
										</td>
									</tr>
									<tr>
										<td class='f32'>
											<div class='flag th' ></div></td><td style='vertical-align:middle;  padding:6px; text-align:left' >
											<a href='<?php echo site_url()?>country/thailand'>Thailand</a>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:middle; text-align:center; padding:6px' colspan="2" >
											<a href='<?php echo site_url()?>country/all'>Any Country</a>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<script>
							jQuery(".selectcountry").each(function(){
								jQuery(this).hover(function(){
									jQuery("#flags").show();
								});
							});
							

							
							jQuery("#flags *").each(function(){
									jQuery(this).hover(
										function(){
											jQuery("#flags").show();
										}
									);
							});
							
							
							jQuery("#flags").hover(
								function(){
									jQuery("#flags").show();
								},
								function(){
									jQuery("#flags").hide();
								}
							);
							
							<?php
							if($_SESSION['country']!=""){
								?>
								jQuery("#theflag").show();
								jQuery("#theflag").removeClass();
								jQuery("#theflag").addClass("flag");
								jQuery("#theflag").addClass("<?php echo $_SESSION['countryshort']; ?>");
								jQuery("#thecountry").html("<?php echo ucfirst($_SESSION['country']); ?>");
								<?php
							}
							else{
								?>
								jQuery("#theflag").hide();
								jQuery("#thecountry").html("Any");
								<?php
							}
							?>
							
						</script>
					</td>
					<td class='right'>
					<ul style="padding:0px">
						<li class="outer"><a class='pointer' style="padding-right:0px;">FILTERS<img style="margin-left:8px;" src="<?php echo site_url(); ?>media/startuplist/filterdown.png"></a>
							<ul>
								<li class="inner"><a href="<?php echo site_url(); ?>newlyadded">NEWLY ADDED</a></li>
								<li class="inner"><a href="<?php echo site_url(); ?>newlyupdated">NEWLY UPDATED</a></li>
							</ul>
						</li>
					</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
if($cnt){
	?>
	<table cellpadding="0" cellspacing="0" class="" id="companies">
		<?php
		
		for($i=0; $i<$t; $i++){
			?>
			<tr>
			<?php 
			for($n=0; $n<4; $n++){
				$class="";
				if($n==0){
					$class = "first";
				}
				else if($n==3){
					$class = "last";
				}
				
				if($companies[$i]['id']){
					?>
					<td class="companyblockcontainer <?php echo $class; ?>">
						<?php 
						$data = array();
						$data['company'] = $companies[$i];
						$data['n'] = $n;
						$this->load->view("startuplist/company_block", $data);
						?>
					</td>
					<?php
				}
				else{
					?>
					<td class="emptycontentblock companyblockcontainer <?php echo $class; ?>">
						
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
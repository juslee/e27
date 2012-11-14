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
<table cellpadding="0" cellspacing="0" class="p100 contentshead">
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
		<td class="contentsheadright right">
				<ul style="padding:0px">
					<li class="outer"><a class='pointer' style="padding-right:0px;">FILTERS<img style="margin-left:8px;" src="<?php echo site_url(); ?>media/startuplist/filterdown.png"></a>
						<ul>
							<li class="inner"><a href="<?php echo site_url(); ?>startuplist/index/newlyadded">NEWLY ADDED</a></li>
							<li class="inner"><a href="<?php echo site_url(); ?>startuplist/index/newlyupdated">NEWLY UPDATED</a></li>
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
				
				
				if($companies[$i]['id']){
					?>
					<td width="25%">
						<?php 
						$data = array();
						$data['company'] = $companies[$i];
						$this->load->view("startuplist/company_block", $data);
						?>
					</td>
					<?php
				}
				else{
					?>
					<td width="25%" class="emptycontentblock">
						
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
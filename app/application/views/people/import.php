<?php
$table = "people";
$filename = microtime_float().".csv";
?>
<script>
function refreshFiles(){
	formdata = "";
	jQuery("#csvfiles").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />Loading Uploaded Files...");
	jQuery.ajax({
		url: "<?php echo site_url().$table; ?>/import/getfiles",
		type: "POST",
		data: formdata,
		dataType: "html",
		success: function(html){
			jQuery("#csvfiles").html(html);
		}
	});
}
function processFile(filepath){
	formdata = "filepath="+escape(filepath);
	if(jQuery("#skiph").attr("checked")){
		formdata += "&skipheaders=1";
	}
	jQuery("#processfile").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />Processing...");
	jQuery.ajax({
		url: "<?php echo site_url().$table; ?>/import/processfile",
		type: "POST",
		data: formdata,
		dataType: "html",
		success: function(html){
			jQuery("#processfile").html(html);
		}
	});
}
jQuery(function(){
	jQuery('#csvfile').uploadify({
			'uploader'  : '<?php echo site_url(); ?>media/js/uploadify/uploadify.swf',
			'script'    : '<?php echo site_url(); ?>media/js/uploadify/uploadify.php?filename=<?php echo $filename;?>',
			'cancelImg' : '<?php echo site_url(); ?>media/js/uploadify/cancel.png',
			'folder'    : '<?php
				$folder = dirname(__FILE__)."/../../../media/uploads/";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/csv";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/csv/".$table;
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = str_replace(dirname(__FILE__)."/../../..", "", $folder);
				echo $folder;
			?>',
			'auto'      : true,
			'multi'       : false,
			'onComplete'  : function(event, ID, fileObj, response, data) {
			  //alert('There are ' + data.fileCount + ' files remaining in the queue.');
			  str = "";
			  for(x in fileObj){
				str += x+"\n";
			  }
			  //alert(str);
			  //alert(fileObj.filePath);
			  //refreshFiles("<?php echo $table; ?>");
			  processFile("<?php echo $folder."/".$filename; ?>");
			  
			}	
		});
});
</script>

<div class='pad10' style='width:400px; margin:auto' >
	Upload CSV File<br><input type='checkbox' id='skiph' checked="checked" >Skip Headers <br><input type='text' id="csvfile" />
	<div id='processfile'></div>
</div>
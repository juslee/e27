
<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
	<tr>
		<td class="head">RELATED E27 ARTICLES</td>
	</tr>
	<tr>
		<td class="content">
		<?php
		
		$items = $feed['items'];
		if(count($items)){
			foreach ($items as $item) {
				$pub_ts = strtotime($item['pubdate']);
				if(!$pub_ts){
					$pub_ts = strtotime($item['published']);
				}
				$published = "";
				if($pub_ts){
					$published = "".date("M d, Y", $pub_ts)."";
				}
				
				
				$href = $item['link'];
				$title = $item['title'];	
				if($time-$pub_ts<=(5*24*60*60)){ //within 4 days
					echo "<div style='padding-bottom:5px;'><a href=$href class='rss_title'>$title</a><br>$published</div>";
				}
			}
		}
		
		?>

		</td>
	</tr>
</table>
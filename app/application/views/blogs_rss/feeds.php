<?php
if(count($items)){
	echo "<div class='rss_channel'>Channel: <a href='$url'>".$rss->channel['title']."</a></div>";
	echo "<ul class='items'>";
	foreach ($items as $item) {
		$pub_ts = strtotime($item['pubdate']);
		if(!$pub_ts){
			$pub_ts = strtotime($item['published']);
		}
		$published = date("M d, Y", $pub_ts);
		$href = $item['link'];
		$title = $item['title'];	
		if($time-$pub_ts<=(5*24*60*60)){ //within 4 days
			echo "<li class='new'><a class='rss_date'>[ $published ]</a> <a href=$href class='rss_title'>$title</a><img alt='This entry was published within the past 5 days.' title='This entry was published within the past 5 days.' src='".site_url()."media/new.png'></li>";
		}
		else{
			echo "<li class='old'><a class='rss_date'>[ $published ]</a> <a href=$href class='rss_title'>$title</a></li>";
		}
	}
	echo "</ul>";
}
?>
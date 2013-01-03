<div class='linkfarm'>
<?php
$t = count($list);
for($i=0; $i<$t; $i++){
	echo "<a href='".site_url().$type."/".$list[$i]['slug']."'>".$list[$i]['name']."</a><br>";
}
?>
</div>
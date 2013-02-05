<?php
while ( have_posts() ){
	the_post();
	$p = get_post( get_the_ID(), OBJECT );
}
$url = "/speakers/?speakerid=".$p->ID."&_=".time();
header ('HTTP/1.1 301 Moved Permanently');
header("Location: ".$url);
exit();

?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
function createThumb($src, $dest, $thumbWidth, $thumbHeight) 
{
	$info = pathinfo($src);

	// load image and get image size
	$img = @imagecreatefromjpeg( $src );
	if(!$img){
		$img = @imagecreatefrompng ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgif ( $src );
	}
	if(!$img){
		$img = @imagecreatefromwbmp ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd2 ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd2part ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd ( $src );
	}
	if(!$img){
		$img = @imagecreatefromstring ( $src );
	}
	if(!$img){
		$img = @imagecreatefromxbm ( $src );
	}
	if(!$img){
		$img = @imagecreatefromxpm ( $src );
	}

	if(!$img){
		return false;
	}
	$width = imagesx( $img );
	$height = imagesy( $img );
	$new_width = $width;
	$new_height = $height;
	// calculate thumbnail size
	if($width>$height)
	{
		if($thumbWidth<$width)
		{
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );
		}
	}
	else
	{
		if($thumbHeight<$height)
		{
			$new_height = $thumbHeight;
			$new_width = floor( $width * ( $thumbHeight / $height ) );
		}
	}
	// create a new temporary image
	$tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
	// copy and resize old image into new image 
	imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
	// save thumbnail into a file
	imagejpeg( $tmp_img, $dest, 100 );
}

function showThumb($src, $thumbWidth, $thumbHeight) 
{
	$info = pathinfo($src);

	// load image and get image size
	//$src = str_replace("%20", "", $src);
	//$src  = "http://google.com";
	//echo file_get_contents($src);
	//exit();
	$img = imagecreatefromjpeg( $src );
	if(!$img){
		$img = @imagecreatefrompng ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgif ( $src );
	}
	if(!$img){
		$img = @imagecreatefromwbmp ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd2 ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd2part ( $src );
	}
	if(!$img){
		$img = @imagecreatefromgd ( $src );
	}
	if(!$img){
		$img = @imagecreatefromstring ( $src );
	}
	if(!$img){
		$img = @imagecreatefromxbm ( $src );
	}
	if(!$img){
		$img = @imagecreatefromxpm ( $src );
	}
	
	if(!$img){
		
		return false;
	}	
	$width = imagesx( $img );
	$height = imagesy( $img );
	$new_width = $width;
	$new_height = $height;
	// calculate thumbnail size
	if($width>$height)
	{
		if($thumbWidth<$width)
		{
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );
		}
	}
	else
	{
		if($thumbHeight<$height)
		{
			$new_height = $thumbHeight;
			$new_width = floor( $width * ( $thumbHeight / $height ) );
		}
	}
	// create a new temporary image
	$tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
	// copy and resize old image into new image 
	imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
	// save thumbnail into a file
	imagejpeg( $tmp_img , null, 100);
}
$mx = $_GET['mx']*1;
if($_GET['b'])
{
	$p = base64_decode($_GET['p']);
	$md5file = dirname(__FILE__)."/user_files/cache/".md5($p).".jpg";
	if(file_exists($md5file)){
		showThumb($md5file, $mx, $mx);
		exit();
	}
	else{
		createThumb($p, $md5file, 600, 600);
	}

}
else
{
	$p = urldecode($_GET['p']);
	$p = dirname($p)."/".rawurlencode(basename($p));
	//$p = str_replace("//", "/", $p);
	//$p = str_replace("http:/", "http://", $p);
	//echo $p;
	//exit();
}

if($mx){
	header('Content-Type: image/jpeg');
	showThumb($p, $mx, $mx);	
}
else
{
	header('Content-Type: image/jpeg');
	showThumb($p, 1000, 1000);
}

?>
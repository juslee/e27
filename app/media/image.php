<?php
error_reporting(E_ALL ^ E_NOTICE);
function showThumb($src, $thumbWidth, $thumbHeight, $dest="") 
{
	$info = pathinfo($src);

	// load image and get image size
	//$src = str_replace("%20", "", $src);
	//$src  = "http://google.com";
	//echo file_get_contents($src);
	//exit();
	if(strpos($src, "http://".$_SERVER['HTTP_HOST']."/media/") === 0 ){
		$src = str_replace("http://".$_SERVER['HTTP_HOST']."/media/", dirname(__FILE__)."/", $src);
	}
	if($_GET['showsrc']){
		echo $src;
		exit();	
	}
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
	
	if(!trim($dest)){
		imagejpeg( $tmp_img , null, 100);
	}
	else{
		@imagejpeg( $tmp_img , $dest, 100);
		imagejpeg( $tmp_img , null, 100);
	}
	// save thumbnail into a file
	
}
$mx = $_GET['mx']*1;
$mxh = $_GET['mxh']*1;
$mxw = $_GET['mxw']*1;

@mkdir(dirname(__FILE__)."/imgcache", 0777);
$p = urldecode($_GET['p']);
$p = dirname($p)."/".rawurlencode(basename($p));

if($_GET['b']){
	$p = base64_decode($_GET['p']);
}

$md5file = dirname(__FILE__)."/imgcache/".md5($p)."_mx".$mx."_mxh".$mxh."_mxw".$mxw.".jpg";

if(file_exists($md5file)&&!$_GET['nocache']){
	if($mx){
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		//echo $md5file;
		echo file_get_contents($md5file);
	}
	else if($mxw&&$mxh){
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		echo file_get_contents($md5file);
	}
	else
	{
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		echo file_get_contents($md5file);
	}
}
else{
	if($mx){
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		showThumb($p, $mx, $mx, $md5file);	
	}
	else if($mxw&&$mxh){
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		showThumb($p, $mxw, $mxh, $md5file);	
	}
	else
	{
		if(!$_GET['nohead']){
			header('Content-Type: image/jpeg');
		}
		showThumb($p, 1000, 1000, $md5file);
	}
}
?>
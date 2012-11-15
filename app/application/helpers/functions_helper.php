<?php
define('MAGPIE_CACHE_ON', true);
include_once(dirname(__FILE__)."/magpie_0.72/rss_fetch.inc");

function amountIze($amount){
	if($amount>=1000000){
		$amount = $amount / 1000000;
		$amount = number_format($amount, 1)."M";	
	}
	else if($amount>=1000){
		$amount = $amount / 1000;
		$amount = number_format($amount, 1)."K";	
	}
	else{
		$amount = number_format($amount, 2);
	}
	return $amount;
}

function seoIze($str){
	return preg_replace("/[^a-zA-Z0-9]/iUs", "_", $str);
}
function site_url(){
	$host = $_SERVER['HTTP_HOST'];
	return "http://".$host."/_e27/app/";
}
function redirect_to($url){
	ob_end_clean();
	?>
	<script>
		self.location = "<?php echo htmlentities($url); ?>";
	</script>
	<?php
	exit();
}
function sanitizeX($str){
	$str = addslashes($str);
	$str = str_replace("\n", "\\n", $str);
	$str = str_replace("\r", "\\r", $str);
	return $str;
}

function checkEmail($email) {
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $email))
    {
        list($username,$domain)=explode('@',$email);
        if(!getmxrr ($domain,$mxhosts)) {
            return false;
        }
        return true;
    }
    return false;
}

function SureRemoveDir($dir, $DeleteMe=false) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh))) {
        if($obj=='.' || $obj=='..') continue;
        if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
    }

    closedir($dh);
    if ($DeleteMe){
        @rmdir($dir);
    }
}
?>
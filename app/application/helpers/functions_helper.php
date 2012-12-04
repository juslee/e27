<?php
define('MAGPIE_OUTPUT_ENCODING', "UTF-8");
define('MAGPIE_CACHE_ON', true);
include_once(dirname(__FILE__)."/magpie_0.72/rss_fetch.inc");
include_once(dirname(__FILE__)."/fb/facebook.php");

function fb(){
	$facebook = new Facebook(array(
	  'appId'  => '135632699922818',
	  'secret' => 'e63bc2737f673ba63dcd0ba797d3e67c',
	));
	return $facebook;
}


function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
function htmlentitiesX($str){
	return htmlentities($str, ENT_COMPAT, "UTF-8");
}
function word_limit($str, $limit)
{
    $str .= "";
    $str = trim($str);
    $l = strlen($str);
    $s = "";
    for($i=0; $i<$l; $i++)
    {
        $s .= $str[$i];
        if($limit>0&&(preg_match("/\s/", $str[$i])))
        {  
            if(!preg_match("/\s/", $str[$i+1]))
                $limit--;
            if(!$limit)
            {
                return $s."...";
                break;
            }
        }
    }
    return $s;
}

function amountIze($amount){
	if($amount>=1000000){
		if($amount%1000000){
			$amount = $amount / 1000000;
			$amount = number_format($amount, 3)."M";	
		}
		else{
			$amount = $amount / 1000000;
			$amount = number_format($amount, 0)."M";	
		}
	}
	else if($amount>=1000){
		if($amount%1000){
			$amount = $amount / 1000;
			$amount = number_format($amount, 1)."K";	
		}
		else{
			$amount = $amount / 1000;
			$amount = number_format($amount, 0)."K";	
		}
	}
	else{
		$amount = number_format($amount, 2);
	}
	return $amount;
}

function seoIze2($str){
	$str = str_replace(" ", "_", $str);
	return $str;
}
function unseoIze2($str){
	$str = str_replace("_", " ", $str);
	return $str;
}
function seoIze($str){
	//echo mb_detect_encoding ($str);
	$str = preg_replace("/[^a-zA-Z0-9]/iUs", "-", $str);
	$str = trim($str, "-");
	if(trim($str)==""){
		return substr(md5($str), 0, 4);
	}
	return $str;
}
function site_url(){
	$host = $_SERVER['HTTP_HOST'];
	if($host=='localhost'){
		return "http://".$host."/_e27/app/";
	}
	else{
		return "http://".$host."/";
	}
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

function safeExport($str){
	$str = trim($str);
	$str = str_replace(",", "", $str);
	$str = preg_replace("/[^a-zA-Z0-9]/iUs", " ", $str);
	return $str;
}
?>
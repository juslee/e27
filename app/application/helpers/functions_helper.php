<?php
define('MAGPIE_OUTPUT_ENCODING', "UTF-8");
define('MAGPIE_CACHE_ON', true);
include_once(dirname(__FILE__)."/magpie_0.72/rss_fetch.inc");
include_once(dirname(__FILE__)."/fb/facebook.php");

function captcha(){
	?><img id='captchaimg' src='<?php echo site_url(); ?>media/startuplist/cool-php-captcha-0.3.1/captcha.php' ><?php
}
function arrDiff($arr1, $arr2){
	$str1 = trim(json_encode($arr1));
	$str2 = trim(json_encode($arr2));
	//echo $str1."<br><br>";
	//echo $str2."<br>";
	//echo "<hr>";
	//echo strcmp($str1,$str2);
	if(strcmp($str1,$str2)==0){
		return false;
	}
	else{
		return true;
	}
}
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

function checkEmail($email, $mx=false) {
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $email))
    {
        list($username,$domain)=explode('@',$email);
        if($mx){
			if(!getmxrr ($domain,$mxhosts)) {
				return false;
			}
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

function getWebUser($web_user){
	if($web_user['fb_data']){
		$web_user['type'] = 'fb';
		$web_user['fb'] = json_decode($web_user['fb_data']);
		$web_user['name'] = $web_user['fb']->name;
		$web_user['img'] = "http://graph.facebook.com/".$web_user['fb']->id."/picture?type=large";
		$web_user['email'] = $web_user['fb']->email;
		$web_user['twitter'] = "";
		$web_user['linkedin'] = "";
	}
	return $web_user;
}

function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}


function bubble_sort($arr, $key, $sort="asc", $string=false) {
	$sort = strtolower($sort);
    $size = count($arr);
    for ($i=0; $i<$size; $i++) {
        for ($j=0; $j<$size-1-$i; $j++) {
			if($string){
				if($sort=="asc"){
					if (strcmp($arr[$j+1][$key], $arr[$j][$key])<=0) {
						swap($arr, $j, $j+1);
					}
				}
				else{
					if (strcmp($arr[$j+1][$key], $arr[$j][$key])>=0) {
						swap($arr, $j, $j+1);
					}
				}
			}
			else{ //integer
				if($sort=="asc"){
					if ($arr[$j+1][$key] < $arr[$j][$key]) {
						swap($arr, $j, $j+1);
					}
				}
				else{
					if ($arr[$j+1][$key] > $arr[$j][$key]) {
						swap($arr, $j, $j+1);
					}
				}

			}
        }
    }
    return $arr;
}

function swap(&$arr, $a, $b) {
    $tmp = $arr[$a];
    $arr[$a] = $arr[$b];
    $arr[$b] = $tmp;
}


?>
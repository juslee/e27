<?php

define('SY_DEBUG', 0);

define('SY_FAILED_THROW', 'throw');
define('SY_FAILED_DIE', 'die');

require_once(dirname(__FILE__).'/wp_utilities.php');

	/**

	 	f: required_parameter()

	 * @param name (string|number) key of given parameter
	 * @param arr (array) target parameter holder. ($_REQUEST by default)
	 * @param onfailed (SY_FAILED_THROW|SY_FAILED_DIE) action upon failure, default is throw.
	 */
	function required_parameter($name, $arr = null, $onfailed = SY_FAILED_THROW) {
		if ($arr == null) {
			$arr = $_REQUEST;
		}
		sy_assert(isset($arr[$name]), 'Parameter: '.$name.' is required.', $onfailed);
		return $arr[$name];
	}

	/**

		f: parameter()

	 * @param name (string|number) key of given parameter.
	 * @param arr (array) target parameter holder. ($_REQUEST by default)
	 * @param default_value given default value incase named parameter is not exist. (null by default)
	 */
	function parameter($name, $arr = null, $default_value = null) {
		if ($arr == null) {
			$arr = $_REQUEST;
		}
		return (isset($arr[$name]) ? $arr[$name] : $default_value);
	}

	/**
		
		f: assert()

	 * @param s
	 */
	function sy_assert( $r, $message, $onfailed = SY_FAILED_THROW ) {
		if (!$r) {
			if ($onfailed == SY_FAILED_THROW) {
				throw new Exception($message);
			} elseif ($onfailed == SY_FAILED_DIE) {
				sy_die($message);
			} else {
				throw new Exception('Unknown assertive onfailed handler: '.$onfailed);
			}
		}
	}

	/**

		f: to_js_date()

	 * @param obj (object) that holds date value
	 * @param key (string) attribute that hold date value
	 * @param format (string) format to supply to date() php function.
	 * @return array of val and label.
	 */
	function to_js_date($obj, $key = NULL, $format = NULL) {
		if (is_object($obj)) {
			$value = $obj->$key;
		} elseif (is_array($obj)) {
			$value = $obj[$key];
		} else {
			$value = $obj;
			/* key is unused here */
		}
		$val = strtotime($value) * 1000;
		if ($format == NULL) {
			return array('val' => $val, 'label' => $value);
		} else {
			return array('val' => $val, 'label' => date($format, strtotime($value)));
		}
	}

	/**
		
		f: sy_debug()

		display debug messages.

	 * @param m (any) - message.
	 * @return (void)
	 */
	function sy_debug( $m ) {
		if ( ! $m ) {
			$m = 'debug here';
		} elseif (is_array($m)) {
			$m = print_r( array('array .. ', $m), 1 );
		} elseif (is_object($m)) {
			$m = print_r( array('object .. ', $m), 1 );
		}
		echo '<br/><br/><pre>'.$m.'</pre><hr/>';
	}

	/**

		f: arraylize()

		convert input variable to array.

	 * @param input (any)
	 * @return (array)
	 */
	function arraylize($input) {
		return is_array($input) ? $input : array($input);
	}

	/**
		
		f: page_url()

		Retrieve current page URL.

	 * @return (URL) return current page URL.
	 */
	function page_url() {
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
		    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else 
		{
		    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	/**
		
		f: rewrite_variable()

		Modify input URL with given variables.

	 * @param (URL) input URL to modify, NULL will get page_url() instead.
	 * @param (array) list of parameter (key, and values) to be append/modify at the back of the URL.
	 * @return (URL) return modified URL.
	 */
	function rewrite_variable($url = NULL, $values) {
		if ($url == NULL) {
			$url = page_url();
		}

		$comp = parse_url($url);

		$query = array();
		if ( ! empty($comp['query'])) {
			parse_str($comp['query'], $query);
		}

		$query = http_build_query( array_merge( $query, $values) );

		$r = $comp['scheme'] . '://' . $comp['host'] . $comp['path'] ;

		if ( ! empty($query)) {
			$r .= '?' . $query;
		}

		if ($comp['fragment']) {
			$r .= '#' . $comp['fragment'];
		}
		return $r;
	}

	/**
		
		f: build_url()

		Create URL out of Array compoenents
			# scheme (string)
			# host (string)
			# path (string)
			# query (array)
			# fragment (string)

	 * @param (array) URL associated components
	 * @return (URL) return forged URL.
	 */
	function build_url( $comp ) {

		$r = $comp['scheme'] . '://' . $comp['host'] . $comp['path'];

		if ( ! empty($comp['query']) ) {
			parse_str($comp['query'], $query);
			$query = http_build_query( $query );
		} else {
			$query = array();
		}
		
		if ( ! empty($query)) {
			$r .= '?' . $query;
		}

		if ($comp['fragment']) {
			$r .= '#' . $comp['fragment'];
		}
		return $r;
	}

	/**

		f: is_crawler()

	 * @link http://wanderr.com/jay/detect-crawlers-with-php-faster/2009/04/08/
	 */
	function is_crawler($userAgent)
	{
		$crawlers = 'Google|msnbot|Rambler|Yahoo|AbachoBOT|accoona|' .
		'AcioRobot|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|' .
		'GeonaBot|Gigabot|Lycos|MSRBOT|Scooter|AltaVista|IDBot|eStyle|Scrubby';
		return (preg_match("/$crawlers/", $userAgent) > 0);
	}

	/**
	 */
	if ( ! function_exists('rip')) {
		function rip($array, $field) {
			if (empty($array)) {
				return array();
			}
			$r = array();
			if (is_object($array[0])) {
				foreach($array as $element) {
					$r[] = $element->$field;
				}
			} else {
				foreach($array as $element) {
					$r[] = $element[$field];
				}
			}
			return $r;
		}
	}

	/**
	 	
	 	f: startsWith()

	 * @param haystack (string) subject string
	 * @param needle (string) string to look for
	 * @return (boolean)
	 */
	if ( ! function_exists('startsWith')) {
		function startsWith($haystack, $needle)
		{
		    $length = strlen($needle);
		    return (substr($haystack, 0, $length) === $needle);
		}
	}

	/**
	 	
	 	f: endsWith()
	 	
	 * @param haystack (string) subject string
	 * @param needle (string) string to look for
	 * @return (boolean)
	 */
	if ( ! function_exists('endsWith')) {
		function endsWith($haystack, $needle)
		{
		    $length = strlen($needle);
		    if ($length == 0) {
		        return true;
		    }

		    $start  = $length * -1; //negative
		    return (substr($haystack, $start) === $needle);
		}
	}

	/**
	 	
	 	f: wrap()

	 	trim down subject string by word.
	 	
	 * @param content (string) subject string
	 * @param length (int) maximum size
	 * @param appendText (string) string to append after it was wrapped.
	 * @return (boolean)
	 */
	if ( ! function_exists('wrap')) {
		function wrap($content, $length, $appendText = ' ...') {
			$short_content = wordwrap($content, $length, '<br/>');
			if(strpos($short_content, '<br/>')) {
				$short_content = substr($short_content, 0, strpos($short_content, '<br/>')).$appendText;
			}
			return $short_content;
		}
	}

	/**
	 	
	 	f: cut()

	 	trim down subject string by character.
	 	
	 * @param content (string) subject string
	 * @param length (int) maximum size
	 * @param appendText (string) string to append after it was wrapped.
	 * @return (boolean)
	 */
	if ( ! function_exists('cut')) {
		function cut($content, $length, $appendText = ' ...') {
			if(strlen($content) > $length) {
				return substr($content, 0, $length).$appendText;
			} else {
				return $content;
			}
		}
	}
?>
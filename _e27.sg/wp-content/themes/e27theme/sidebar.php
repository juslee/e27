<!-- START OF RIGHTCOL -->
	<?php
	if(urlIncludePath('blog'))
	{
	  ?> <script> jQuery("a[title='Blog']").attr("class", 'activated'); </script> <?php
	}
	else if(urlIncludePath('events'))
	{
?> <script>
		function doReloadActivated(){
			jQuery("a[href='http://www.e27.sg/events/']").attr("class", 'activated'); 
			jQuery("a[title='Events']").attr("class", 'activated');
		}
		window.setInterval("doReloadActivated()", 1000);
		</script> <?php
	}
	else if(urlIncludePath('community'))
	{
	  ?> <script>jQuery("a[href='http://www.e27.sg/community/']").attr("class", 'activated'); jQuery("a[title='Community']").attr("class", 'activated'); </script> <?php
	}
	else if(urlIncludePath('about'))
	{
	  ?> <script> jQuery("a[title='About']").attr("class", 'activated'); </script> <?php
	}
	?>

            <div class="RightCol">
<?php
function __tempJSHelper($name)
{
	echo "<script>alert('". $name ."');</script>";
}

//if(is_page('home'))
if(is_page('blog'))
{
	//__tempJSHelper('blog');
	$themes = array( 
	//'new_add_next_event.php',
	'new_add_backup_sidebar.php'
	//'new_add_stay_connected.php', 
	//'new_add_walt_mossberg.php', 
	//'new_add_most_read_and_latest_comments.php', 
	//'new_add_archives_and_categories.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(is_page('blog_entry'))
{
	//__tempJSHelper('blog_entry');
	$themes = array(
	//'new_add_stay_connected.php',
	//'new_add_most_read_and_latest_comments.php', 
//	'new_add_archives_and_categories.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(is_page('blog_main'))
{
	//__tempJSHelper('blog_main');
	$themes = array(
	'new_add_next_event.php',
	'new_add_stay_connected.php', 
	//'new_add_walt_mossberg.php', 
	//'new_add_most_read_and_latest_comments.php', 
	//'new_add_archives_and_categories.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(is_page('events')) // events_main
{
	//__tempJSHelper('events');
	$themes = array(
	'new_add_leave_your_screens_get_personal.php', 
	'new_add_stay_connected.php', 
	'new_add_our_projects_and_events.php', 
	'new_add_event_calendar.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(is_page('events_main')) //events_entry ??????????
{
	//__tempJSHelper('events_main');
	$themes = array(
	'new_add_stay_connected.php', 
	'new_add_our_projects_and_events.php', 
	'new_add_event_calendar.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(urlIncludePath('community'))
{

	$themes = array( 
	'new_add_stay_connected.php',
	'new_add_twitter_feed.php', 
	'new_add_flickr.php' 
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else if(is_page('about'))
{
	//__tempJSHelper('about');
	$themes = array(
	'new_add_contact_us.php', 
	'new_add_sponsors.php', 
	'new_add_press.php', 
	'new_add_google_ad.php'
	);
	foreach($themes as $theme)
	{
		load_template( get_theme_root() . '/e27theme/' . $theme);
	}
}
else
{
	//__tempJSHelper('new_add_backup_sidebar');
	$theme = 'new_add_backup_sidebar.php';
	load_template( get_theme_root() . '/e27theme/' . $theme);
}
?>             
            <!-- END OF RIGHTCOL -->
<?php
function urlIncludePath($string)
{
	$uri = URI::getInstance();
	return (false != stripos($uri->toString(), $string));
}

function getUrlString()
{
	$uri = URI::getInstance();
	return $uri->toString();     
}


class URI
{
    protected $_uri = null;
    protected $_scheme = null;
    protected $_host = null;
    protected $_port = null;
    protected $_user = null;
    protected $_pass = null;
    protected $_path = null;
    protected $_query = null;
    protected $_fragment = null;
    protected $_vars = array ();

    private function __construct($uri = null)
    {
        if ($uri !== null)
        {
            $this->parse($uri);
        }
    }

    public static function &getInstance($uri = 'SERVER')
    {
        static $instances = array();

        if (!isset ($instances[$uri]))
        {
            if ($uri == 'SERVER')
            {
                if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off'))
                {
                    $https = 's://';
                }
                else
                {
                    $https = '://';
                }

                if (!empty ($_SERVER['PHP_SELF']) && !empty ($_SERVER['REQUEST_URI']))
                {
                    $theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                }
                else
                {
                    $theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
                    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
                    {
                        $theURI .= '?' . $_SERVER['QUERY_STRING'];
                    }
                }
                $theURI = urldecode($theURI);
                $theURI = str_replace('"', '&quot;', $theURI);
                $theURI = str_replace('<', '&lt;', $theURI);
                $theURI = str_replace('>', '&gt;', $theURI);
                $theURI = preg_replace('/eval\((.*)\)/', '', $theURI);
                $theURI = preg_replace('/[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']/', '""', $theURI);
            }
            else
            {
                $theURI = $uri;
            }
            $instances[$uri] = new URI($theURI);
        }
        return $instances[$uri];
    }

    public function base($pathonly = false)
    {
        $base['prefix'] = URI::toString(array('scheme', 'host', 'port'));

        if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI']))
        {
            $base['path'] = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        }
        else
        {
            $base['path'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        }
        return $pathonly === false ? $base['prefix'] . $base['path'] . '/' : $base['path'];
    }

    public function root($pathonly = false, $path = null)
    {
        $root['prefix'] = URI::toString(array('scheme', 'host', 'port'));
        $root['path'] = URI::base(true);
        if (isset($path))
        {
            $root['path'] = $path;
        }
        return $pathonly === false ? $root['prefix'] . $root['path'] . '/' : $root['path'];
    }

    public function current()
    {
        return URI::toString(array('scheme', 'host', 'port', 'path'));
    }

    private function parse($uri)
    {
        $retval = false;
        $this->_uri = $uri;

        if ($_parts = @parse_url($uri))
        {
            $retval = true;
        }

        $this->_scheme = isset ($_parts['scheme']) ? $_parts['scheme'] : null;
        $this->_user = isset ($_parts['user']) ? $_parts['user'] : null;
        $this->_pass = isset ($_parts['pass']) ? $_parts['pass'] : null;
        $this->_host = isset ($_parts['host']) ? $_parts['host'] : null;
        $this->_port = isset ($_parts['port']) ? $_parts['port'] : null;
        $this->_path = isset ($_parts['path']) ? $_parts['path'] : null;
        $this->_query = isset ($_parts['query'])? $_parts['query'] : null;
        $this->_fragment = isset ($_parts['fragment']) ? $_parts['fragment'] : null;
        if (isset ($_parts['query'])) parse_str($_parts['query'], $this->_vars);

        return $retval;
    }

    public function toString($parts = array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'))
    {
        $query = URI::buildQuery($this->_vars); //make sure the query is created
        $uri = '';
        $uri .= in_array('scheme', $parts) ? (!empty($this->_scheme) ? $this->_scheme . '://' : '') : '';
        $uri .= in_array('user', $parts) ? $this->_user : '';
        $uri .= in_array('pass', $parts) ? (!empty ($this->_pass) ? ':' : '') . $this->_pass . (!empty ($this->_user) ? '@' : '') : '';
        $uri .= in_array('host', $parts) ? $this->_host : '';
        $uri .= in_array('port', $parts) ? (!empty ($this->_port) ? ':' : '') . $this->_port : '';
        $uri .= in_array('path', $parts) ? $this->_path : '';
        $uri .= in_array('query', $parts) ? (!empty ($query) ? '?' . $query : '') : '';
        $uri .= in_array('fragment', $parts)? (!empty ($this->_fragment) ? '#' . $this->_fragment : '') : '';

        return $uri;
    }

    public function setVar($name, $value)
    {
        $tmp = isset($this->_vars[$name]) ? $this->_vars[$name] : null;
        $this->_vars[$name] = $value;
        $this->_query = null;
        return $tmp;
    }

    public function getVar($name = null, $default = null)
    {
        if (isset($this->_vars[$name]))
        {
            return $this->_vars[$name];
        }
        return $default;
    }

    public function delVar($name)
    {
        if (in_array($name, array_keys($this->_vars)))
        {
            unset ($this->_vars[$name]);
            $this->_query = null;
        }
    }

    public static function buildQuery ($params, $akey = null)
    {
        if (!is_array($params) || count($params) == 0)
        {
            return false;
        }

        $out = array();

        if (!isset($akey) && !count($out))
        {
            unset($out);
            $out = array();
        }

        foreach ($params as $key => $val)
        {
            if (is_array($val))
            {
                $out[] = URI::buildQuery($val, $key);
                continue;
            }

            $thekey = (!$akey) ? $key : $akey . '[]';
            $out[] = $thekey . "=" . urlencode($val);
        }

        return implode("&", $out);
    }
}
?>	
</div>

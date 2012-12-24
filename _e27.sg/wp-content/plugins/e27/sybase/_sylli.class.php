<?php
/* base object */
if ( ! class_exists('Sylli_WP_BaseObject')) {

	require_once(dirname(__FILE__).'/syutils/utilities.php');

	/* CONSTANTS */
	define('SY_ADMIN_NOTICE', 'sy_admin_notice');

	define('SY_SETTING_GROUP_PLAYGROUND', 'sylli_playground_settings');

	$my_sy_version = 1;

	class SyLog {

		var $echo = FALSE;		
		var $messages = array();

		function __construct($echo = FALSE) {
			$this->echo = $echo;
		}
		
		public function log($m) {
			$this->messages[] = $m;
			if ($this->echo) {
				echo $m;
			}
		}
	}

	class Sylli_WP_BaseObject {

		public static $version;		// version index
		public static $root;		// root instance
		private static $pgs;		// playgrounds
		private static $children;	// children instances key = _CLS_, val = instance

		private $class_name;

		public function __construct( $base_dirname = 'sybase', $playgrounds = array() ) {

			// version check
			global $my_version;
			self::$version = $my_sy_version;

			// register
			// root object registration.
			// do once
			if ( empty(self::$pgs) ) {
				if ( ! session_id()) session_start();

				self::$pgs['ROOT PLAYGROUND'] = array($this, '_pg_note');
				self::$pgs['AJAX LAUNCH PAD'] = array($this, '_pg_ajax');

				self::$root = $this;

				// add hook, create playground page
				add_action( 'admin_menu', array($this, 'add_playground_page') );
				add_action( 'admin_init', array($this, 'register_playground_settings') );

				add_action( 'admin_notices', array($this, 'admin_notices') );
			}

			$class_name = get_class($this);

			define('SY_BASE_DIRNAME', $base_dirname);

			/* register sub class if provided */
			if (is_string($class_name) && class_exists($class_name)) {
				
				// regist instance
				self::$children[$class_name] = $this;

				// sub classes registeration.
				if ( empty($playgrounds) ) {
					// default registration.
					self::$pgs[$class_name] = array($this,'playground');
				} elseif (is_array($playgrounds)) {
					// custom registration.
					foreach ($playgrounds as $caller) {
						self::$pgs[$class_name.'-'.$caller['label']] = array($this,$caller['fname']);
					}
				} else {
					throw new Exception('Bad initialize parameter: ONLY array contains "label" (string) and "fname" (string) OR plain class_name (string) are allowed.');
				}

				$this->class_name = $class_name;
			}
		}

		public function admin_notices(){
			
			if(!empty($_SESSION[ SY_ADMIN_NOTICE ])) 
				print $_SESSION[ SY_ADMIN_NOTICE ];

			unset ($_SESSION[ SY_ADMIN_NOTICE ]);
		}


		public function register_playground_settings() {
			register_setting( SY_SETTING_GROUP_PLAYGROUND, 'active_mode' );
		}

		public function add_playground_page() {
			/* enqueue js */
			wp_enqueue_script( 'jquery' );

			/* set page echo callback 
			 * @ref http://codex.wordpress.org/Function_Reference/add_menu_page
			 */
			add_menu_page(
				'Sylli studio debugger tool', 					// page title
				'Sy Tools', 									// menu title
				'administrator', 								// capability
				'sylli_pg',										// menu slug
				array($this, 'echo_playground_page'), 			// callback
				NULL,											// icon URL
				10100											// position
			);
		}

		public function echo_playground_page() {
			// resolve selected module
		?>
		<style>
		div.playground {
			-webkit-border-radius: 12px;
			-moz-border-radius: 12px;
			border-radius: 12px;
			box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.5);
			-moz-box-shadow: 1px 2px 6px rgba(0,0,0, 0.5);
			-webkit-box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.5);
			padding: 15px;
		}
		div.playground h3 {
			color: #777;
		}
		div.playground p.example,
		div.playground div.example {
			-webkit-border-radius: 12px;
			-moz-border-radius: 12px;
			border-radius: 12px;
			border: 1px dashed #444;
			padding: 12px;
			line-height: 1.7em;
		}
		div.playground code {
			padding: 2px;
			margin: 3px;
		}
		</style>
		<div class="wrap">
			<form id="dad" method="post" action="options.php">
			<?
				settings_fields( SY_SETTING_GROUP_PLAYGROUND );
				do_settings_fields( SY_SETTING_GROUP_PLAYGROUND, 'general' );

				$active_mode = get_option( 'active_mode' );
			?>
		
			<h2>Sylli Studio <code>Developer Playground</code></h2>
			<label>Select module:</label>

			<SELECT name="active_mode" onchange="jQuery('#dad').submit();">
			<?
				foreach (self::$pgs as $cn => $o) {
					if ($active_mode == $cn) {
						echo "<option selected=\"selected\" value=\"$cn\">$cn</option>";
					} else {
						echo "<option value=\"$cn\">$cn</option>";
					}
				}
			?>
			</SELECT>
			<!-- <input type="submit" class="button-primary" value="<?php _e('Apply') ?>" /> -->
			</form>
			<br/>
			<div class="playground">
			<?
				$caller = self::$pgs[$active_mode];
				call_user_func( $caller );
			?>
			</div>
		</div>
		<?
		}

		public function _pg_note() {
		?>
			<h3>Hello, this is <strong>Sylli Studio Playground</strong>.</h3>
			<p>
				If you implement your plugin core class with <code>Sylli_WP_BaseObject</code> class. You are may overwrite <code>playground</code> function. And write your testing code there.
			</p>
			<p>
				Kindly note that this playground already is a <code>jQuery</code> capable page, therefore you may write your <strong>HTML/PHP/jQuery</strong> as you please.
			</p>
		<?
		}

		public function _pg_ajax() {
		?>
			<h3>Sylli Studio AJAX launch pad</h3>
			<p>
			This page will provide an insrutuction for Sylli Studio's Plugin Developer to get call their function as AJAX.
			</p>
			<p>
			Every method those extended class: <code>Sylli_WP_BaseObject</code> are callalble in AJAX form. But before ability to invoke your function each function needs to be recognized by <code>ajax_adapter</code> to do so, simply overwrite <code>ajax_adapter</code> in your class. The goal of this function is simple: MAP parameter from request to methods signature.
			</p>
			<div class="example">
			Example:
			<blockquote><pre>
public function ajax_adapter($method_name) {
	switch ($method_name) {
	case 'set_score':
		$r = $this->$method_name($_REQUEST['object_id'], $_REQUEST['value'], $_REQUEST['user_id']);
		break;
	case 'get_score':
	case 'is_like':
		$r = $this->$method_name($_REQUEST['object_id'], $_REQUEST['user_id']);
		break;
	default:
		throw new Exception("No handler for $method_name");
	}
	return $r;
}</pre></blockquote>
			</div>

			<p>
			Lastly to make AJAX calls, get base_url, and provide your parameter in - e.g. ...
			<blockquote><code><?= $this->ajax_url('set_score', array('object_id'=>3,'user_id'=>-1,'value'=>3)) ?></code></blockquote>
			</p>

			<p><strong>Note</strong> that '<strong>func</strong>', '<strong>cls</strong>' and '<strong>callback</strong>' are reserved parameters for mapping with method name, class name, and internal callback of javascript.</p>
			
			<h4>Pragmatically get AJAX urls</h4>
			<p>
				Use your plugin class object method: <code>ajax_url()</code>
			</p>
			<p>Calling <code>ajax_url()</code> without parameter will returns AJAX base URL (no parameter at all)</p>
			<p>Calling <code>ajax_url($method_name, $parameters)</code> will generate fullly usable ajax call URL.</p>
			<p class="example">Example:<br/>
			<code>$o->ajax_url('set_score', array('object_id'=>3,'user_id'=>-1,'value'=>3));</code><br/>
			will returns <br/>
			<code><?= $this->ajax_url('set_score', array('object_id'=>3,'user_id'=>-1,'value'=>3)) ?></code>
			</p>
			<h4>Complete List of base ajax URL</h4>
			<p>
			list as module installed in your wordpress system.
			</p>
			<ol>
			<?
				foreach (self::$children as $child) {
					$burl = $child->ajax_url();
					echo "<li>Plugin: <strong>{$child->class_name}</strong> <code><a href=\"{$burl}\">{$burl}</a></code></li>";
				}
			?>
			</ol>
		<?
		}

		public function ajax_url($method_name = NULL, $parameters = array()) {
			if ($method_name) {
				$parameters['func'] = $method_name;
			}
			$parameters['cls'] = $this->class_name;
			return plugins_url( SY_BASE_DIRNAME.'/_sylli.ajax.php?'.http_build_query($parameters), dirname(__FILE__) );
		}

		public function playground() {
		?>
			<h3>Playground</h3>
			<p>
				No handler implemented. Simply overwrite your playground function and see the your here :).
			</p>
		<?
		}

		public function do_ajax() {
			$result = TRUE;
			$data = array();
			$err = '';

			try {
				$callback = required_parameter('callback');
				$cls = required_parameter('cls');
				$data = self::$children[$cls]->ajax_adapter( required_parameter('func') );
			} catch (Exception $e) {
				$result = FALSE;
				$err = $e->getMessage();
			}
			echo $callback.'('.json_encode(array(
				'result' => $result,
				'data' => $data,
				'err' => $err
			)).');';
		}

		/**
			handle argument placement and resolving from $_REQUEST
		 */
		public function ajax_adapter( $method_name ) {
			throw new Exception('No handler implemented.');
		}


		public function load_post_types( $root_path ) {
			require_once( dirname(__FILE__).'/_post_type.php');

			$start = strlen( $root_path );
			foreach(glob( $root_path.'*.php') as $filename) {
				$cls = substr($filename, $start, -4);
				if(startsWith($cls, '_')) {
					continue;
				}
				require_once($filename);
			}
		}
	}

	function sy_notice( $m, $type = 'error' ) {
		$_SESSION[ SY_ADMIN_NOTICE ] = '<div class="'.$type.'"><p>'.$m.'</p></div>';
	}

}

?>
<?

class SyCustomPostType {

	const REPLACE_VALUE = '%value%';

	protected $m = array();
	protected $fields = array();
	protected $columns = array();

	public function __construct($meta_info, $fields, $columns = array()) {

		if (!session_id()) session_start();

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style( 'custom-jquery-ui', plugins_url(SY_BASE_DIRNAME.'/css/default.jquery-ui-1.8.22.custom.css', dirname(__FILE__)) );

		$this->m = $meta_info;
		$this->fields = $fields;
		$this->columns = $columns;

		if ( ! empty($this->columns)) {
			add_action('manage_posts_columns', array($this, 'add_column_header') );
			add_action('manage_posts_custom_column', array($this, 'add_column_body'),10,2);
		}

		add_action( 'init', array( $this, 'register') );
		add_action( 'admin_init', array( $this, 'admin_register_meta_box') );
		add_action( 'save_post', array( $this, 'save_meta_details') );
	}

	/* call by hooks */

	public function add_column_header( $posts_columns ) {
		global $typenow;
		if ($typenow !== $this->m['typename']) {
			return $posts_columns;
		}
	    if (!isset($posts_columns['title'])) {
	        $new_posts_columns = $posts_columns;
	    } else {
	        $new_posts_columns = array();
	        $index = 0;
	        foreach($posts_columns as $key => $posts_column) {
	        	$new_posts_columns[$key] = $posts_column;
				if ($key=='title') {
					foreach($this->columns as $add_key => $add_column) {
						$new_posts_columns[$add_key] = $add_column['label'];
					}
				}
	        }
	    }
	    return $new_posts_columns;
	}


	public function add_column_body( $column_id, $post_id ) {
		global $typenow;
		if ($typenow !== $this->m['typename']) {
			return;
		}
		if ( ! empty($this->columns[$column_id])) {
			$column = $this->columns[$column_id];

			$value_cb = $this->_get_callback('value', $column['value_callback']);

			// print_r($value_cb);

			$r = call_user_func($value_cb, $post_id, $column['value_callback_args']);
			if ($r) {
				echo $r;
			}
		}
	}

	public function register() {

		if ( ! empty($this->m['add_taxonomies'])) {
			foreach($this->m['add_taxonomies'] as $key => $taxonomy) {
				if ( empty($taxonomy['labels']) ) {
					$label = $this->m['typename'];
					if ( ! empty($taxonomy['label']) ) {
						$label = $taxonomy['label'];
						unset($taxonomy['label']);
					}
					$taxonomy['labels'] = array(
						'name' => $label,
						'singular_name' => $label,
						'search_items' => __( 'Seach '.$label),
						'all_items' => __( 'All '.$label),
						'parent_item' => __( 'Parent '.$label),
						'parent_item_colon' => __( 'Parent : '.$label),
						'edit_item' => __( 'Edit '.$label ),
						'update_item' => __( 'Update '.$label ),
					    'add_new_item' => __( 'Add New '.$label ),
					    'new_item_name' => __( 'New '.$label.' Name' ),
					    'menu_name' => $label,
					);
				}
				
				register_taxonomy(
					$key,
					array(
						$this->m['typename']
					),
					$taxonomy
				);
			}
		}

		if ($this->m['typename'] != 'post') {
			register_post_type( $this->m['typename'],
				array(
					'labels' => array(
						'name' => __( $this->m['singular'] ),
						'singular_name' => __( $this->m['singular'] ),
						'add_new' => __( 'Create '.$this->m['singular'] ),
						'add_new_item' => __( 'Create '.$this->m['singular'] ),
						'edit_item' => __( 'Edit '.$this->m['singular'] ),
						'new_item' => __( 'Create '.$this->m['singular'] ),
						'view_item' => __( 'View '.$this->m['singular'] ),
						'search_items' => __( 'Search '.$this->m['prual'] ),
						'not_found' => __( 'No '.$this->m['prual'].' found' ),
						'not_found_in_trash' => __( 'No '.$this->m['prual'].' found in trash' )
					),
					'public' => true,
					'supports' => $this->m['supports'],
					'capability_type' => 'post',
					'rewrite' => array("slug" => $this->m['typename']), // Permalinks format
					'menu_position' => 5,
					'taxonomies' => $this->m['taxonomies']
				)
			);
		}
	}

	public function admin_register_meta_box() {
		add_meta_box(
			$this->m['typename']."_meta", 			// Id
			$this->m['singular']." Details", 		// Title
			array($this, "details_meta_cb"),		// callback
			$this->m['typename'], 					// post_type responsible for this metabox
			"normal", 								// priority
			"default"								// callback
		);
	}

	public function details_meta_cb() {
		global $_asn;
	?>
		<table class="form-table">
			<tbody>
				<?php foreach ($this->fields as $field_key => $field_value) { ?>
				<tr align="top">
					<? if ($field_value['hidden']) {
						$hidden_text = 'style="display:none;"';
					} else {
						$hidden_text = '';
					} ?>
					<th <?= $hidden_text ?> scope="row"><?= $field_value['label'] ?></th>
					<td <?= $hidden_text ?>>
						<?
							$cb = $this->_get_callback('control', $field_value['control_callback']);
							if ($cb) {
								call_user_func($cb, 
									$field_key, 
									$field_value['control_callback_args'], 
									$this->_get_field( 
										$field_key, 
										$field_value['default_value'] 
									)
								);
							}
						?>
						<div class="description"><?= $field_value['description'] ?></div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?
	}

	public function save_meta_details() {
		global $post;
 
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		// CAREFUL!
		// this is general use hooks, always apply type filter before proceed.

		if ( get_post_type($post) == $this->m['typename']) {

			if ( ! empty($this->m['onsave'])) {
				try {
					call_user_func($this->m['onsave']);
				} catch (Exception $e) {
					sy_notice( 'An Error occured: '.$e->getMessage(), 'error' );
					return FALSE;
				}
			}

			foreach ($this->fields as $field_key => $field_value) {

				// assign default value if data was not set.
				if (isset($field_value['default_value']) && empty($_POST[$field_key])) {
					$_POST[$field_key] = $field_value['default_value'];
				}

				// perform assertion.
				$cb = $this->_get_callback('assertion', $field_value['assertion_callback']);
				if ($cb) {
					// print_r($cb);
					try {
						call_user_func($cb, $_POST, $field_key);
					} catch (Exception $e) {
						sy_notice( 'An Error occured: '.$e->getMessage(), 'error' );
						return FALSE;
					}
					
				}
				$this->_save_field( $field_key );
			}
		}
	}
	
	/* protected functions */

	protected function _get_callback($type, $callback_name) {
		if (is_string($callback_name) && startsWith($callback_name, '_')) {
			$method_name = '_'.$type.$callback_name;
			if (method_exists($this, $method_name)) {
				return array($this, $method_name);
			} else {
				throw new Exception('unknown "' . $type . '" callback method: "' . $method_name . '"');
			}
		}
		return $callback_name;
	}

	/* support assertion callback */

	protected function _assertion_numeric($field_values, $field_key) {
		if ( ! is_numeric($field_values[$field_key])) {
			throw new Exception($field_key . ' must be number.');
		}
	}

	/* support control callbacks */

	protected function _control_text($field_key, $field_args, $field_value) {
		echo '<input name="'.$field_key.'" type="text" style="'.$field_args['style'].'" class="regular-text '.$field_args['class'].'" value="'.$field_value.'" placeholder="'.$field_args['placeholder'].'"/>';
	}

	protected function _control_textarea($field_key, $field_args, $field_value) {
		echo '<textarea name="'.$field_key.'" style="'.$field_args['style'].'" class="'.$field_args['class'].'">'.$field_value.'</textarea>';
	}

	protected function _control_datepicker($field_key, $field_args, $field_value) {
		?>
		<script>
			jQuery(function() {
				var selector = "input[name=\"<?= $field_key ?>\"].datepicker";
				jQuery( selector ).datepicker(  );
				jQuery( selector ).datepicker( "option", "dateFormat", "yy-mm-dd" );
				jQuery( selector ).datepicker( "setDate", '<?= $field_value ?>' );
				jQuery( selector ).datepicker( "show" ).datepicker( "hide" );
			});
		</script>
		<?
		$field_args['class'] .= " datepicker";
		$this->_control_text($field_key, $field_args, $field_value);
	}

	protected function _control_tick($field_key, $field_args, $field_value) {
		if ($field_value) {
			$checked = 'checked="checked"';
		}
		echo '<input name="'.$field_key.'" type="checkbox" style="'.$field_args['style'].'" class="regular-text '.$field_args['class'].'" '.$checked.' value="1" />';
	}

	protected function _control_combo($field_key, $field_args, $field_value) {
		if ( empty($field_args['map']) ) {
			throw new Exception('Bad usage of combo box control. Field argument required: map');
		}

		echo "<SELECT class=\"{$field_args['class']}\" style=\"{$field_args['style']}\"name=\"$field_key\">";
		foreach ($field_args['map'] as $key => $label) {
			$selected = ($field_value == $key ? 'selected="selected"' : '');
			echo "<option $selected value=\"{$key}\">$label</option>";
		}
		echo "</SELECT>";
	}

	protected function _value_meta( $post_id, $args ) {
		$value = $this->_get_field($args['meta_key']);
		if (empty($args['format'])) {
			$args['format'] = SyCustomPostType::REPLACE_VALUE;
		}

		if (is_string($args['format']) && ! startsWith($args['format'], '_')) {
			return str_replace(SyCustomPostType::REPLACE_VALUE, $value, $args['format']);	
		}
		$cb = $this->_get_callback('format', $args['format']);
		return call_user_func($cb, $value, $args['format_args']);
	}

	protected function _format_boolean( $value, $args ) {
		if ( empty($args['map'])) {
			throw new Exception('Format boolean required: argument \'map\'');
		}
		return $args['map'][intval($value)];
	}

	protected function _format_text( $value, $args) {
		$format = '%val%';
		if ( ! empty($args['format'])) {
			$format = $args['format'];
		}
		return str_replace('%val%', $value, $format);
	}

	/* wordpress flow helper */

	protected function _get_field($_field, $_default_value = NULL) {
		global $post;

		$custom = get_post_custom($post->ID);

		if (isset($custom[$_field])) {
			return $custom[$_field][0];
    	} else {
    		return $_default_value;
    	}
	}

	protected function _save_field($_field) {
		global $post;

		if(isset($_POST[$_field])) {
			update_post_meta($post->ID, $_field, $_POST[$_field]);
		} else {
			update_post_meta($post->ID, $_field, '');
		}
	}

	protected function _remove_meta_box($meta_box_slug) {
		global $wp_meta_boxes;
		unset( $wp_meta_boxes[$this->m['typename']]['normal']['core'][$meta_box_slug] );
		unset( $wp_meta_boxes[$this->m['typename']]['side']['core'][$meta_box_slug] );
		unset( $wp_meta_boxes[$this->m['typename']]['advanced']['core'][$meta_box_slug] );
	}

	protected function _echo_author_combobox($users = NULL) {

		if ($users == NULL) {
			$users = get_users();
		}

		global $post;
		?>
		<label for="post_author_override">Author: </label>
		<select id="post_author_override" name="post_author_override">
		<?
			foreach ($users as $user) {
				$s = ($post->post_author == $user->ID ? "selected=\"selected\"" : "");
				echo "<option $s value='{$user->ID}'>{$user->user_login}</option>";
			}
		?>
		</select>
		<?
	}

	public function _echo_category_combobox($parent_category_id = -1) {
		global $_asn;

		// assume that $this->m['typename'] = Module Slug
		if ($parent_category_id == -1) {
			$parent_category_id = $_asn->get_module_object($this->m['typename'])->meta('category_id');
		}

		$cats = get_the_category();
		if ( ! empty($cats)) {
			$current_cat_id = $cats[0]->term_id;
		}
		?>
		<input type="hidden" name="post_category[]" value="0">
		<label for="post_category">Category: </label>
		<select name="post_category[]">
		<?
			if ( is_array($parent_category_id) ) {
				$parent_category_ids = $parent_category_id;
			} else {
				$parent_category_ids = array($parent_category_id);
			}
			foreach ($parent_category_ids as $parent_category_id) {
				$_asn->_print_recursive_categories($parent_category_id, 0, $current_cat_id);		
			}
		?>
		</select>
		<?
	}
}

?>
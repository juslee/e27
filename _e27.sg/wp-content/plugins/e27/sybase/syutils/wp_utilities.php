<?php
	/**
		Next project NOTE
		=================

		This file should wrapped around with a class wrapper.

		So when the function is called, sy_ is not required anymore, rather
		using wpu:: prefix.
	 */

	/**
		
		f: sy_die()

		Block wordpress from further processing.

	 * @param message (string) display error message (HTML enabled).
	 * @param title (string) display error title (Default: 'Error').
	 * @param back_link (URL) display backlink (Default: FALSE - no show).
	 * @param front_link (URL) append a link to return to front page.
	 * @return (void)
	 */
	function sy_die( $_message, $_title = 'Error', $_back_link = FALSE, $_front_link = TRUE ) {
		$m = '';
		$h = '<h2>'.$_title.'</h2>';
		if ($_front_link) {
			$m .= '<br/><br/><a href="'.get_site_url().'">Return to Aseanian</a>';
		}
		wp_die($h.$_message.$m, $_title, array('back_link'=>$_back_link));
		exit();
	}

	/**
		
		f: page_id_by_slug()

		Find wordpress page_id by given slug.

	 * @param page_slug (string) - page slug to look up.
	 * @return (int) associated page_id with given slug, FALSE if not found.
	 */
	function page_id_by_slug( $page_slug ) {
		$page = get_page_by_path($page_slug);
		if ($page) {
			return $page->ID;
		} else {
			return FALSE;
		}
	}

	/**
		
		f: permalink_by_slug()

		Return wordpress permalink by given slug.

	 * @param page_slug (string) - page slug to look up.
	 * @return (url) associated URL with given slug.
	 */
	function permalink_by_slug( $page_slug ) {
		return get_permalink( page_id_by_slug($page_slug) );
	}

	/**
		
		f: user_role()

		Determine wordpress current user role.

	 * @return (string) current loggedin user role.
	 */
	function user_role() {
		global $current_user;

		if ( empty($current_user) ) {
			return NULL;
		}

		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		return $user_role;
	}

	/**
		
		f: category_walk

		Walkd down wordpress category and print out results.

	 * @param $args (int|array) - argument array of get_categories() with default value of hide_empty = 0, parent = 0. If $args is integer, assume this is parent_category_id.
	 * @param $_selected (int|string|array) - array of selected category as integer. Or single integer as selected category term_id.
	 * @param $_opts (array) - array describe how should function display result. Values are
	 *		value_field (string) - which field to become value ref WP_category object (WP_term)
	 * 		label_field (string) - which field to display ref WP_category or WP_term,
	 * 		id (string) - SELECT tag id,
	 * 		name (string) - SELECT tag name,
	 * 		select (String) - SELECT tag free text,
	 * 		style (string) - SELECT tag free text style,
	 *		class (string) - SELECT tag free text class,
	 *		indent (string) - text to use prepend before label (only use without OPTGROUP)
	 *		optgroup_levels (int|array) - apply optgroup on given level.
	 * 		custom_opts (array) - any array of label and value, states additional static options for dropdown.
	 * @param $_inner (boolean) internal use (notify function to treat this as recusive print. (do not print SELECT))
	 */
	function category_walk( $args = 0, $_selected, $_opts = array(), $_level = 0) {
		$default_args = array(
			'hide_empty' => 0,
			'parent' => 0,
		);
		$default_opts = array(
			'value_field' => 'term_id',
			'label_field' => 'name',
			'id' => '',
			'name' => '',
			'select' => '',
			'style' => '',
			'class' => '',
			'indent' => '&nbsp;&nbsp;&nbsp;',
			'optgroup_levels' => '',
			'custom_opts' => array(),
		);

		if (is_numeric($args)) {
			$args = array_merge($default_args, array('parent'=>$args));
		} elseif (is_array($args)) {
			$args = array_merge($default_args, $args);
		} else {
			$args = $default_args;
		}

		if ( ! empty($_opts)) {
			$_opts = array_merge($default_opts, $_opts);
		} else {
			$_opts = $default_opts;
		}

		extract($_opts);

		if (!is_array($_selected)) {
			$_selected = array($_selected);
		}
		if (!is_array($optgroup_levels)) {
			$optgroup_levels = array($optgroup_levels);
		}

		$ind_text = '';
		for ($i=0;$i<$_level;$i++) {
			$ind_text .= $indent;
		}

		if ($_level == 0)
			echo "<select id=\"{$id}\" name=\"{$name}\" {$select} style=\"{$style}\" style=\"{$class}\">";
		
		if ( ! empty($custom_opts) ) {
			foreach($custom_opts as $option_to_print) {
				$val = $option_to_print['val'];
				$label = $option_to_print['label'];
				$sel_text = in_array($val, $_selected) ? 'selected="selected"' : '';
				echo "<option $sel_text value=\"{$val}\">{$label}</option>";
			}
			unset($_opts['custom_opts']);
		}

		$categories = get_categories($args);
		foreach ($categories as $category) {
			
			$label = $category->$label_field;

			if (in_array($_level+1, $optgroup_levels)) {
				echo "<OPTGROUP label=\"$label\">";
				
				$args['parent'] = $category->term_id;
				category_walk( $args, $_selected, $_opts, $_level+1);

				echo "</OPTGROUP>";
			} else {
				$label = $ind_text.$label;
				$val = $category->$value_field;
				$sel_text = in_array($val, $_selected) ? 'selected="selected"' : '';
				echo "<option $sel_text value=\"{$val}\">{$label}</option>";
				
				$args['parent'] = $category->term_id;
				category_walk( $args, $_selected, $_opts, $_level+1);
			}
		}

		if ($_level == 0)
			echo "</select>";
	}

	/**
		
		f: category_data_walk

		Walkdown each wordpress category and retuns out the structure in array.

	 * @param parent_id (id) associated category parent id. 
	 * @param on_each_callback (callback) function to call on each category node. (Use to manipulate data, or insert extra field in the result set)
	 */
	function category_data_walk($parent_id, $on_each_callback = NULL, $args = array()) {
		$default_args = array(
			'hide_empty' => 0
		);

		$args = array_merge($default_args, $args);

		$args['parent'] = $parent_id;

		$categories = get_categories($args);
		foreach($categories as &$cat) {
			$cat = get_object_vars($cat);
			$cat['children'] = category_data_walk($cat['term_id'], $on_each_callback, $args);
			if ( ! empty($on_each_callback)) {
				call_user_func($on_each_callback, &$cat);
			}
		}
		return $categories;
	}
?>
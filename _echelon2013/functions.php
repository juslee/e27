<?php
include_once(dirname(__FILE__)."/../../../wp-admin/includes/plugin.php");
class Echelon{
	public function hide_editor(){
		?>
		<style>
		#postdivrich { display:none; }
		</style>
		<?php
	}
	/** Frontend methods ******************************************************/
	/**
	 * Register the custom post type
	 */
	public function init($slug, $label){
		register_post_type( $slug, array( 'public' => true, 'label' => $label, 'supports' => null ) );
	}
}




class E_Carousel extends Echelon {
	
	var $slug;
	var $label;
	var $title;
		
	public function __construct() {
		$this->slug = "e_carousel";
		$this->label = "Echelon Carousel";
		$this->title = "Name";
		
		add_action( 'init', $this->init($this->slug, $this->label) );	
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		}
	}

	
	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the carousel custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow, $post;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
			
			
			if(get_post_type($_GET['post']) == $this->slug||$_GET['post_type']==$this->slug){
				add_action( 'admin_head', array( &$this, 'hide_editor' ));
			}
			add_filter( 'manage_edit-'.$this->slug."_columns", array( &$this, 'columns' ) ) ;
			add_action( 'manage_'.$this->slug.'_posts_custom_column', array( &$this, 'manage_columns' ), 10, 2 );
			
			
			add_filter('manage_edit-'.$this->slug.'_sortable_columns',array( &$this,  'order_column_register_sortable'));



		}
	}

	/**
	* make column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['order'] = 'order';
	  return $columns;
	}

	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != $this->slug ) return;
			
		$this->process_meta( $post_id, $post );
	}
	
	
	
	
	
	/**
	 * Set a more appropriate placeholder text for the New carousel title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == $this->slug ) return __( $this->title );
		return $text;
	}
	
	
	
	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( $this->slug."-metabox", __( $this->label ), array( &$this, 'meta_box' ), $this->slug, 'normal', 'high' );
	}
	
	/**
	 * Function for processing and storing all carousel data.
	 */
	private function process_meta( $post_id, $post ) {
		update_post_meta( $post_id, $this->slug.'_image_id', $_POST['upload_image_id'] );
		update_post_meta( $post_id, $this->slug.'_alt_tag', $_POST['alt_tag'] );
		update_post_meta( $post_id, $this->slug.'_title_tag', $_POST['title_tag'] );
		update_post_meta( $post_id, $this->slug.'_order', $_POST['order'] );
	}
	
	//columns in list view
	function columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( $this->label ),
			'alt_tag' => __( 'Alt Tag' ),
			'title_tag' => __( 'Title Tag' ),
			'image' => __( 'Image' ),
			'order' => __( 'Order' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	
	function manage_columns( $column, $post_id ){
		global $post;
		
		$image_id = get_post_meta( $post_id, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$alt = get_post_meta( $post_id, $this->slug.'_alt_tag', true );
		$title = get_post_meta( $post_id, $this->slug.'_title_tag', true );
		$order = get_post_meta( $post_id, $this->slug.'_order', true );
		
		
		if($column=='title_tag'){
			echo $title;
		}
		else if($column=='alt_tag'){
			echo $alt;
		}
		else if($column=='image'){
			?><img id="carousel_image" src="<?php echo $image_src ?>" style="max-width:100px;" /><?php
		}
		else if($column=='order'){
			echo $order;
		}
		
		
	}
	
	/**
	 * Display the image meta box
	 */
	public function meta_box() {
		global $post;
		
		$image_src = '';
		
		$image_id = get_post_meta( $post->ID, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$alt = get_post_meta( $post->ID, $this->slug.'_alt_tag', true );
		$title = get_post_meta( $post->ID, $this->slug.'_title_tag', true );
		$order = get_post_meta( $post->ID, $this->slug.'_order', true );
		
		?>
		<style>
		#<?php echo $this->slug; ?> td{
			vertical-align:top;
		}
		</style>
		<table id='<?php echo $this->slug; ?>' style='width:100%'>
		<tr>
			<td>Alt Tag</td>
			<td><textarea name="alt_tag" style='width:90%; height:100px'><?php echo htmlentities($alt); ?></textarea></td>
		</tr>
		<tr>
			<td>Title Tag</td>
			<td><textarea name="title_tag" style='width:90%; height:100px'><?php echo htmlentities($title); ?></textarea></td>
		</tr>
		<tr>
			<td>Order</td>
			<td><input type='text' name='order' value="<?php echo $order*1; ?>" /> * must be an integer value</td>
		</tr>
		<tr>
			<td>Image <br /> (490px x 300px)</td>
			<td>
			<img id="carousel_image" src="<?php echo $image_src ?>" style="max-width:100%;" />
			<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php echo $image_id; ?>" />
			<p>
				<input type='button' class='button' value="<?php _e( 'Set Image' ) ?>"  id="set-image" />
				<input type='button' class='button' style="<?php echo ( ! $image_id ? 'display:none;' : '' ); ?>" value="<?php _e( 'Remove Image' ) ?>"  id="remove-image" />
			</p>
			</td>
		</tr>
		</table>

		<!--- script below -->
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;
	
			$('#set-image').click(function(){
				
				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
				
				return false;
			});
			
			$('#remove-image').click(function() {
				
				$('#upload_image_id').val('');
				$('img').attr('src', '');
				$(this).hide();
				
				return false;
			});
			
			// handler function which is invoked after the user selects an image from the gallery popup.
			// this function displays the image and sets the id so it can be persisted to the post meta
			window.attach_image = function(html) {
				
				// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
				$('body').append('<div id="temp_image">' + html + '</div>');
					
				var img = $('#temp_image').find('img');
				
				imgurl   = img.attr('src');
				imgclass = img.attr('class');
				imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
	
				$('#upload_image_id').val(imgid);
				$('#remove-image').show();
	
				$('img#carousel_image').attr('src', imgurl);
				try{tb_remove();}catch(e){};
				$('#temp_image').remove();
				
				// restore the send_to_editor handler function
				window.send_to_editor = window.send_to_editor_default;
				
			}
	
		});
		</script>
		<?php
	}
}



class E_Youtube extends Echelon {
	
	var $slug;
	var $label;
	var $title;
		
	public function __construct() {
		$this->slug = "e_youtube";
		$this->label = "Echelon Youtubes";
		$this->title = "Name";
		
		add_action( 'init', $this->init($this->slug, $this->label) );	
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		}
	}

	
	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the carousel custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow, $post;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
			
			
			if(get_post_type($_GET['post']) == $this->slug||$_GET['post_type']==$this->slug){
				add_action( 'admin_head', array( &$this, 'hide_editor' ));
			}
			add_filter( 'manage_edit-'.$this->slug."_columns", array( &$this, 'columns' ) ) ;
			add_action( 'manage_'.$this->slug.'_posts_custom_column', array( &$this, 'manage_columns' ), 10, 2 );
		}
	}


	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != $this->slug ) return;
			
		$this->process_meta( $post_id, $post );
	}
	
	
	
	
	
	/**
	 * Set a more appropriate placeholder text for the New carousel title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == $this->slug ) return __( $this->title );
		return $text;
	}
	
	
	
	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( $this->slug."-metabox", __( $this->label ), array( &$this, 'meta_box' ), $this->slug, 'normal', 'high' );
	}
	
	/**
	 * Function for processing and storing all carousel data.
	 */
	private function process_meta( $post_id, $post ) {
		update_post_meta( $post_id, $this->slug.'_youtube_link', $_POST['youtube_link'] );
	}
	
	//columns in list view
	function columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( $this->label ),
			'youtube_link' => __( 'Youtube Link' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	
	function manage_columns( $column, $post_id ){
		global $post;
		
		$youtube_link = get_post_meta( $post_id, $this->slug.'_youtube_link', true );
		
		
		if($column=='youtube_link'){
			echo $youtube_link;
		}
	}
	
	/**
	 * Display the image meta box
	 */
	public function meta_box() {
		global $post;
		
		$image_src = '';
		
		$youtube_link = get_post_meta( $post->ID, $this->slug.'_youtube_link', true );
		?>
		<style>
		#<?php echo $this->slug; ?> td{
			vertical-align:top;
		}
		</style>
		<table id='<?php echo $this->slug; ?>' style='width:100%'>
		<tr>
			<td>Youtube Link</td>
			<td><input type="text" name="youtube_link" value="<?php echo htmlentities($youtube_link); ?>" style='width:100%' /></td>
		</tr>
		</table>
		<?php
	}
}

class E_Speaker extends Echelon {
	
	var $slug;
	var $label;
	var $title;
		
	public function __construct() {
		$this->slug = "e_speaker";
		$this->label = "Echelon Speakers";
		$this->title = "Speaker Name";
		
		add_action( 'init', $this->init($this->slug, $this->label) );	
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		}
	}

	
	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the carousel custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow, $post;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
			
			add_filter( 'manage_edit-'.$this->slug."_columns", array( &$this, 'columns' ) ) ;
			add_action( 'manage_'.$this->slug.'_posts_custom_column', array( &$this, 'manage_columns' ), 10, 2 );
			
			add_filter('manage_edit-'.$this->slug.'_sortable_columns',array( &$this,  'order_column_register_sortable'));
			
		}
	}
	
	/**
	* make column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['order'] = 'order';
	  return $columns;
	}


	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != $this->slug ) return;
			
		$this->process_meta( $post_id, $post );
	}
	
	
	
	
	
	/**
	 * Set a more appropriate placeholder text for the New carousel title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == $this->slug ) return __( $this->title );
		return $text;
	}
	
	
	
	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( $this->slug."-metabox", __( "Speaker Details" ), array( &$this, 'meta_box' ), $this->slug, 'side', 'high' );
	}
	
	/**
	 * Function for processing and storing all carousel data.
	 */
	private function process_meta( $post_id, $post ) {
		update_post_meta( $post_id, $this->slug.'_image_id', $_POST['upload_image_id'] );
		update_post_meta( $post_id, $this->slug.'_designation', $_POST['designation'] );
		update_post_meta( $post_id, $this->slug.'_order', $_POST['order'] );
	}
	
	//columns in list view
	function columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( $this->label ),
			'image' => __( 'Profile Image' ),
			'designation' => __( 'Designation' ),
			'order' => __( 'Order' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	
	function manage_columns( $column, $post_id ){
		global $post;
		
		$image_id = get_post_meta( $post_id, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$designation = get_post_meta( $post_id, $this->slug.'_designation', true );
		$order = get_post_meta( $post_id, $this->slug.'_order', true );
		
		if($column=='image'){
			?><img id="carousel_image" src="<?php echo $image_src ?>" style="max-width:100px;" /><?php
		}
		else if($column=='designation'){
			echo $designation;
		}
		else if($column=='order'){
			echo $order;
		}
		
		
	}
	
	/**
	 * Display the image meta box
	 */
	public function meta_box() {
		global $post;
		
		$image_src = '';
		
		$image_id = get_post_meta( $post->ID, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$designation = get_post_meta( $post->ID, $this->slug.'_designation', true );
		$order = get_post_meta( $post->ID, $this->slug.'_order', true );
		$order *= 1;
		?>
		<style>
		#<?php echo $this->slug; ?> td{
			vertical-align:top;
		}
		</style>
		<table id='<?php echo $this->slug; ?>' style='width:100%'>
		<tr>
			<td colspan=2>
			<b>Profile Image (175px x 175px)<br /><br /></b>
			<img id="speaker_image" src="<?php echo $image_src ?>" style="max-width:100%;" />
			<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php echo $image_id; ?>" />
			<p>
				<input type='button' class='button' value="<?php _e( 'Set Image' ) ?>"  id="set-image" />
				<input type='button' class='button' style="<?php echo ( ! $image_id ? 'display:none;' : '' ); ?>" value="<?php _e( 'Remove Image' ) ?>"  id="remove-image" />
			</p>
			</td>
		</tr>
		<tr>
			<td>
			<b>Designation (e.g. Founder - e27)<br /><br /></b>
			<input type="text" name="designation" value="<?php echo htmlentities($designation); ?>" style='width:100%' />
			<br /><br />
			<b>Order<br /><br /></b>
			<input type="text" name="order" value="<?php echo htmlentities($order); ?>" style='width:100%' />
			
			</td>
		</tr>
		</table>

		<!--- script below -->
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;
	
			$('#set-image').click(function(){
				
				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
				
				return false;
			});
			
			$('#remove-image').click(function() {
				
				$('#upload_image_id').val('');
				$('img').attr('src', '');
				$(this).hide();
				
				return false;
			});
			
			// handler function which is invoked after the user selects an image from the gallery popup.
			// this function displays the image and sets the id so it can be persisted to the post meta
			window.attach_image = function(html) {
				
				// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
				$('body').append('<div id="temp_image">' + html + '</div>');
					
				var img = $('#temp_image').find('img');
				
				imgurl   = img.attr('src');
				imgclass = img.attr('class');
				imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
	
				$('#upload_image_id').val(imgid);
				$('#remove-image').show();
	
				$('img#speaker_image').attr('src', imgurl);
				try{tb_remove();}catch(e){};
				$('#temp_image').remove();
				
				// restore the send_to_editor handler function
				window.send_to_editor = window.send_to_editor_default;
				
			}
	
		});
		</script>
		<?php
	}
}



class E_Sponsor extends Echelon {
	
	var $slug;
	var $label;
	var $title;
		
	public function __construct() {
		$this->slug = "e_sponsor";
		$this->label = "Echelon Sponsors";
		$this->title = "Sponsor Name";
		
		add_action( 'init', $this->init($this->slug, $this->label) );	
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		}
	}

	
	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the carousel custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow, $post;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
			
			add_filter( 'manage_edit-'.$this->slug."_columns", array( &$this, 'columns' ) ) ;
			add_action( 'manage_'.$this->slug.'_posts_custom_column', array( &$this, 'manage_columns' ), 10, 2 );
			
			add_filter('manage_edit-'.$this->slug.'_sortable_columns',array( &$this,  'order_column_register_sortable'));
			
		}
	}
	
	/**
	* make column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['order'] = 'order';
	  $columns['type'] = 'type';
	  return $columns;
	}


	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != $this->slug ) return;
			
		$this->process_meta( $post_id, $post );
	}
	
	
	
	
	
	/**
	 * Set a more appropriate placeholder text for the New carousel title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == $this->slug ) return __( $this->title );
		return $text;
	}
	
	
	
	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( $this->slug."-metabox", __( "Sponsor Details" ), array( &$this, 'meta_box' ), $this->slug, 'side', 'high' );
	}
	
	/**
	 * Function for processing and storing all carousel data.
	 */
	private function process_meta( $post_id, $post ) {
		update_post_meta( $post_id, $this->slug.'_image_id', $_POST['upload_image_id'] );
		update_post_meta( $post_id, $this->slug.'_type', $_POST['type'] );
		update_post_meta( $post_id, $this->slug.'_order', $_POST['order'] );
		update_post_meta( $post_id, $this->slug.'_html', $_POST['html'] );
		update_post_meta( $post_id, $this->slug.'_link', $_POST['link'] );
	}
	
	//columns in list view
	function columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( $this->label ),
			'image' => __( 'Profile Image' ),
			'type' => __( 'Type' ),
			'order' => __( 'Order' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	
	function manage_columns( $column, $post_id ){
		global $post;
		
		$image_id = get_post_meta( $post_id, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$type = get_post_meta( $post_id, $this->slug.'_type', true );
		$order = get_post_meta( $post_id, $this->slug.'_order', true );
		$html = get_post_meta( $post_id, $this->slug.'_html', true );
		
		if($column=='image'){
			?><img id="carousel_image" src="<?php echo $image_src ?>" style="max-width:100px;" /><?php
		}
		else if($column=='type'){
			echo $type;
		}
		else if($column=='html'){
			echo $html;
		}
		else if($column=='order'){
			echo $order;
		}
		
		
	}
	
	/**
	 * Display the image meta box
	 */
	public function meta_box() {
		global $post;
		
		$image_src = '';
		
		$image_id = get_post_meta( $post->ID, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$type = get_post_meta( $post->ID, $this->slug.'_type', true );
		$order = get_post_meta( $post->ID, $this->slug.'_order', true );
		$html = get_post_meta( $post->ID, $this->slug.'_html', true );
		$link = get_post_meta( $post->ID, $this->slug.'_link', true );
		
		$order *= 1;
		?>
		<style>
		#<?php echo $this->slug; ?> td{
			vertical-align:top;
		}
		</style>
		<table id='<?php echo $this->slug; ?>' style='width:100%'>
		<tr>
			<td colspan=2>
			<b>Logo (175px x 175px)<br /><br /></b>
			<img id="<?php echo $this->slug; ?>_image" src="<?php echo $image_src ?>" style="max-width:100%;" />
			<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php echo $image_id; ?>" />
			<p>
				<input type='button' class='button' value="<?php _e( 'Set Image' ) ?>"  id="set-image" />
				<input type='button' class='button' style="<?php echo ( ! $image_id ? 'display:none;' : '' ); ?>" value="<?php _e( 'Remove Image' ) ?>"  id="remove-image" />
			</p>
			<br />
			<b>URL Link<br /></b>
			<input type="text" name="link" value="<?php echo htmlentities($link); ?>" style='width:100%' />
			</td>
		</tr>
		<tr>
			<td>
			<br /><br />
			<b>Type<br /></b>
			<select name='type' id='xtype'>
				<option value='Regular'>Regular</option>
				<option value='Premier'>Premier</option>
			</select>
			<script>
			jQuery("#xtype").val("<?php echo $type; ?>");
			</script>
			<br /><br />
			<b>Order<br /></b>
			<input type="text" name="order" value="<?php echo htmlentities($order); ?>" style='width:100%' />
			
			</td>
		</tr>
		<tr>
			<td>
			<br /><br />
			----- Or -----
			<br /><br />
			<b>HTML<br /></b>
			<textarea name='html' style='width:100%; height:200px'><?php echo htmlentities($html);  ?></textarea>
			
			</td>
		</tr>
		</table>

		<!--- script below -->
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;
	
			$('#set-image').click(function(){
				
				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
				
				return false;
			});
			
			$('#remove-image').click(function() {
				
				$('#upload_image_id').val('');
				$('img').attr('src', '');
				$(this).hide();
				
				return false;
			});
			
			// handler function which is invoked after the user selects an image from the gallery popup.
			// this function displays the image and sets the id so it can be persisted to the post meta
			window.attach_image = function(html) {
				
				// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
				$('body').append('<div id="temp_image">' + html + '</div>');
					
				var img = $('#temp_image').find('img');
				
				imgurl   = img.attr('src');
				imgclass = img.attr('class');
				imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
	
				$('#upload_image_id').val(imgid);
				$('#remove-image').show();
	
				$('img#<?php echo $this->slug; ?>_image').attr('src', imgurl);
				try{tb_remove();}catch(e){};
				$('#temp_image').remove();
				
				// restore the send_to_editor handler function
				window.send_to_editor = window.send_to_editor_default;
				
			}
	
		});
		</script>
		<?php
	}
}


class E_MediaPartner extends Echelon {
	
	var $slug;
	var $label;
	var $title;
		
	public function __construct() {
		$this->slug = "e_mediapartners";
		$this->label = "Echelon Media Partners";
		$this->title = "Media Partner Name";
		
		add_action( 'init', $this->init($this->slug, $this->label) );	
		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		}
	}

	
	/** Admin methods ******************************************************/
	
	
	/**
	 * Initialize the admin, adding actions to properly display and handle 
	 * the carousel custom post type add/edit page
	 */
	public function admin_init() {
		global $pagenow, $post;
		
		if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
			
			add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
			add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ), 1, 2 );
			add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
			
			add_filter( 'manage_edit-'.$this->slug."_columns", array( &$this, 'columns' ) ) ;
			add_action( 'manage_'.$this->slug.'_posts_custom_column', array( &$this, 'manage_columns' ), 10, 2 );
			
			add_filter('manage_edit-'.$this->slug.'_sortable_columns',array( &$this,  'order_column_register_sortable'));
			
		}
	}
	
	/**
	* make column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['order'] = 'order';
	  $columns['type'] = 'type';
	  return $columns;
	}


	/**
	 * Save meta boxes
	 * 
	 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
	 */
	public function meta_boxes_save( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( is_int( wp_is_post_revision( $post ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post ) ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		if ( $post->post_type != $this->slug ) return;
			
		$this->process_meta( $post_id, $post );
	}
	
	
	
	
	
	/**
	 * Set a more appropriate placeholder text for the New carousel title field
	 */
	public function enter_title_here( $text, $post ) {
		if ( $post->post_type == $this->slug ) return __( $this->title );
		return $text;
	}
	
	
	
	/**
	 * Add and remove meta boxes from the edit page
	 */
	public function meta_boxes() {
		add_meta_box( $this->slug."-metabox", __( "Media Partner Details" ), array( &$this, 'meta_box' ), $this->slug, 'side', 'high' );
	}
	
	/**
	 * Function for processing and storing all carousel data.
	 */
	private function process_meta( $post_id, $post ) {
		update_post_meta( $post_id, $this->slug.'_image_id', $_POST['upload_image_id'] );
		update_post_meta( $post_id, $this->slug.'_type', $_POST['type'] );
		update_post_meta( $post_id, $this->slug.'_order', $_POST['order'] );
		update_post_meta( $post_id, $this->slug.'_html', $_POST['html'] );
		update_post_meta( $post_id, $this->slug.'_link', $_POST['link'] );
	}
	
	//columns in list view
	function columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( $this->label ),
			'image' => __( 'Profile Image' ),
			'type' => __( 'Type' ),
			'order' => __( 'Order' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	
	function manage_columns( $column, $post_id ){
		global $post;
		
		$image_id = get_post_meta( $post_id, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$type = get_post_meta( $post_id, $this->slug.'_type', true );
		$order = get_post_meta( $post_id, $this->slug.'_order', true );
		$html = get_post_meta( $post_id, $this->slug.'_html', true );
		
		if($column=='image'){
			?><img id="carousel_image" src="<?php echo $image_src ?>" style="max-width:100px;" /><?php
		}
		else if($column=='type'){
			echo $type;
		}
		else if($column=='html'){
			echo $html;
		}
		else if($column=='order'){
			echo $order;
		}
		
		
	}
	
	/**
	 * Display the image meta box
	 */
	public function meta_box() {
		global $post;
		
		$image_src = '';
		
		$image_id = get_post_meta( $post->ID, $this->slug.'_image_id', true );
		$image_src = wp_get_attachment_url( $image_id );
		$type = get_post_meta( $post->ID, $this->slug.'_type', true );
		$order = get_post_meta( $post->ID, $this->slug.'_order', true );
		$html = get_post_meta( $post->ID, $this->slug.'_html', true );
		$link = get_post_meta( $post->ID, $this->slug.'_link', true );
		
		$order *= 1;
		?>
		<style>
		#<?php echo $this->slug; ?> td{
			vertical-align:top;
		}
		</style>
		<table id='<?php echo $this->slug; ?>' style='width:100%'>
		<tr>
			<td colspan=2>
			<b>Logo (200px x 200px)<br /><br /></b>
			<img id="<?php echo $this->slug; ?>_image" src="<?php echo $image_src ?>" style="max-width:100%;" />
			<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php echo $image_id; ?>" />
			<p>
				<input type='button' class='button' value="<?php _e( 'Set Image' ) ?>"  id="set-image" />
				<input type='button' class='button' style="<?php echo ( ! $image_id ? 'display:none;' : '' ); ?>" value="<?php _e( 'Remove Image' ) ?>"  id="remove-image" />
			</p>
			<br />
			<b>URL Link<br /></b>
			<input type="text" name="link" value="<?php echo htmlentities($link); ?>" style='width:100%' />
			</td>
		</tr>
		<tr>
			<td>
			<br /><br />
			<b>Type<br /></b>
			<select name='type' id='xtype'>
				<option value='Regular'>Regular</option>
				<option value='Premier'>Premier</option>
			</select>
			<script>
			jQuery("#xtype").val("<?php echo $type; ?>");
			</script>
			<br /><br />
			<b>Order<br /></b>
			<input type="text" name="order" value="<?php echo htmlentities($order); ?>" style='width:100%' />
			
			</td>
		</tr>
		<tr>
			<td>
			<br /><br />
			----- Or -----
			<br /><br />
			<b>HTML<br /></b>
			<textarea name='html' style='width:100%; height:200px'><?php echo htmlentities($html);  ?></textarea>
			
			</td>
		</tr>
		</table>

		<!--- script below -->
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;
	
			$('#set-image').click(function(){
				
				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
				
				return false;
			});
			
			$('#remove-image').click(function() {
				
				$('#upload_image_id').val('');
				$('img').attr('src', '');
				$(this).hide();
				
				return false;
			});
			
			// handler function which is invoked after the user selects an image from the gallery popup.
			// this function displays the image and sets the id so it can be persisted to the post meta
			window.attach_image = function(html) {
				
				// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
				$('body').append('<div id="temp_image">' + html + '</div>');
					
				var img = $('#temp_image').find('img');
				
				imgurl   = img.attr('src');
				imgclass = img.attr('class');
				imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
	
				$('#upload_image_id').val(imgid);
				$('#remove-image').show();
	
				$('img#<?php echo $this->slug; ?>_image').attr('src', imgurl);
				try{tb_remove();}catch(e){};
				$('#temp_image').remove();
				
				// restore the send_to_editor handler function
				window.send_to_editor = window.send_to_editor_default;
				
			}
	
		});
		</script>
		<?php
	}
}


class E_Settings {
	public function __construct() {
		add_action("admin_menu", $this->setup_theme_admin_menus()); 
	}
	public function setup_theme_admin_menus(){
		add_menu_page('Echelon Theme Settings', 'Echelon Theme Settings', 'manage_options',   
			'echelon_theme_settings', array( &$this, 'theme_settings_page' ), '', '61');  
			
	}
	// We also need to add the handler function for the top level menu  
	function theme_settings_page() {  
		// Check that the user is allowed to update options  
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		} 
		if (isset($_POST['echelon_options'])) {  
			
			foreach($_POST as $key=>$value){
				$value = esc_attr($value);     
				update_option($key, $value);  
			}
		}  
		?>  
			<div class="wrap">  
				<?php screen_icon('themes'); ?> <h2>General Settings</h2>  
				<style>
				td{
					vertical-align:top;
				}
				</style>
				<form method="POST" action="">  
					<input type='hidden' name='echelon_options' value='1' />
					<table>
					<tr>
					<td>
						<table class="form-table">  
							<tr valign="top">  
								<th scope="row">  
									<label for="num_elements">  
										Google Analytics Code
									</label>   
								</th>  
								<td>  
									<textarea name="echelon_ga_code" style='width:400px; height:200px'><?php echo htmlentities(get_option("echelon_ga_code")) ?></textarea>
								</td>  
							</tr> 
						</table>  
					</td>
					<td>
						<table class="form-table">  
							<tr valign="top">  
								<th scope="row">  
									<label for="num_elements">  
										Facebook URL
									</label>   
								</th>  
								<td>  
									<input type='text' name="echelon_fb_url" style='width:220px;' value="<?php echo htmlentities(get_option("echelon_fb_url")) ?>" />
								</td>  
							</tr>
							<tr valign="top">  
								<th scope="row">  
									<label for="num_elements">  
										Twitter URL
									</label>   
								</th>  
								<td>  
									<input type='text' name="echelon_tw_url" style='width:220px;' value="<?php echo htmlentities(get_option("echelon_tw_url")) ?>" />
								</td>  
							</tr>
							<tr valign="top">  
								<th scope="row">  
									<label for="num_elements">  
										GPlus URL
									</label>   
								</th>  
								<td>  
									<input type='text' name="echelon_gp_url" style='width:220px;' value="<?php echo htmlentities(get_option("echelon_gp_url")) ?>" />
								</td>  
							</tr>
							<tr valign="top">  
								<th scope="row">  
									<label for="num_elements">  
										LinkedIn URL
									</label>   
								</th>  
								<td>  
									<input type='text' name="echelon_in_url" style='width:220px;' value="<?php echo htmlentities(get_option("echelon_in_url")) ?>" />
								</td>  
							</tr> 
						</table> 
					</td>
					</tr>
					<tr>
					<td colspan='2' style='text-align:center; padding-top:30px;'>
						<input type='submit' class='button button-primary button-large' value='Save' />
					</td>
					</tr>
					</table>
				</form>  
			</div>  
		<?php  
	}  
}




// finally instantiate our plugin class and add it to the set of globals (not really needed but it will instantiate the class)
$GLOBALS['E_Carousel'] = new E_Carousel();
$GLOBALS['E_Youtube'] = new E_Youtube();
$GLOBALS['E_Speaker'] = new E_Speaker();
$GLOBALS['E_Sponsor'] = new E_Sponsor();
$GLOBALS['E_MediaPartner'] = new E_MediaPartner();
$GLOBALS['E_Settings'] = new E_Settings();




?>
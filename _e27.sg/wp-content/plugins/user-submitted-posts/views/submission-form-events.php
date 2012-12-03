<?php // User Submitted Posts - HTML5 Submission Form
//jairus
@session_start();
global $usp_options, $current_user;

$author_ID  = $usp_options['author'];
$default_author = get_the_author_meta('display_name', $author_ID);
if ($authorName == $default_author) {
	$authorName = '';
} ?>

<!-- User Submitted Posts @ http://perishablepress.com/user-submitted-posts/ -->
<div id="user-submitted-posts">

	<?php if ($usp_options['usp_form_content'] !== '') {
		echo $usp_options['usp_form_content'];
	} ?>
	
	<form method="post" enctype="multipart/form-data" action="" onsubmit="return populateContent()">

		<?php if($_GET['submission-error'] == '1') { ?>
		<div id="usp-error-message"><?php echo $usp_options['error-message']; ?></div>
		<?php } ?>

		<?php if($_GET['success'] == '1') { ?>
		<div id="usp-success-message"><?php echo $usp_options['success-message']; ?></div>
		<?php } else { ?>
		All fields with * are required.
		<?php if (($usp_options['usp_name'] == 'show') && ($usp_options['usp_use_author'] == false)) { ?>
		<fieldset class="usp-name">
			<label for="user-submitted-name"><?php _e('Your Name'); ?></label>
			<input name="user-submitted-name" type="text" value="" placeholder="<?php _e('Your Name'); ?>">
		</fieldset>
		<?php } if (($usp_options['usp_url'] == 'show') && ($usp_options['usp_use_url'] == false)) { ?>
		<fieldset class="usp-url">
			<label for="user-submitted-url"><?php _e('Your URL'); ?></label>
			<input name="user-submitted-url" type="text" value="" placeholder="<?php _e('Your URL'); ?>">
		</fieldset>
		<?php }
		if ($usp_options['usp_title'] == 'show') { 
			?>
			<fieldset class="usp-title">
				<label for="user-submitted-title">* <?php _e('Event Name'); ?></label>
				<input name="user-submitted-title" class='required' type="text" value="" placeholder="<?php _e('Event Name'); ?>">
			</fieldset>
			<?php
		} 
		if ($usp_options['usp_tags'] == 'show') { ?>
		<fieldset class="usp-tags">
			<label for="user-submitted-tags"><?php _e('Event Tags'); ?></label>
			<input name="user-submitted-tags" id="user-submitted-tags" type="text" value="" placeholder="<?php _e('Event Tags'); ?>">
		</fieldset>
		<?php } 
		
		if (($usp_options['usp_category'] == 'show') && ($usp_options['usp_use_cat'] == false)) { ?>
		<fieldset class="usp-category">
			<label for="user-submitted-category"><?php _e('Event Category'); ?></label>
			<select name="user-submitted-category">
				<?php foreach($usp_options['categories'] as $categoryId) { $category = get_category($categoryId); if(!$category) { continue; } ?>
				<option value="<?php echo $categoryId; ?>"><?php $category = get_category($categoryId); echo htmlentities($category->name); ?></option>
				<?php } ?>
			</select>
		</fieldset>
		<?php }
		if ($usp_options['usp_content'] == 'show') { 
			?>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Organizer'); ?></label>
				<input name="user-submitted-organizer" title="<?php echo _e('Organizer'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('Organizer'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Start Date'); ?></label>
				<input name="user-submitted-startdate" title="<?php echo _e('Start Date'); ?>" class="user-submitted-subcontent required" type="text" value="" placeholder="<?php _e('E.g. Aug 8, '.(date('Y')+1)); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('End Date'); ?></label>
				<input name="user-submitted-enddate" title="<?php echo _e('End Date'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('E.g. Aug 10, '.(date('Y')+1)); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Location'); ?></label>
				<input name="user-submitted-location" title="<?php echo _e('Location'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('Location'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title"><?php _e('Registration Link'); ?></label>
				<input name="user-submitted-registrationlink" title="<?php echo _e('Registration Link'); ?>" class="user-submitted-subcontent"  type="text" value="" placeholder="<?php _e('Registration Link'); ?>">
			</fieldset>
			<fieldset class="usp-content">	
				<label for="user-submitted-content" style='width:300px'>* <?php _e('Event Description / Agenda'); ?></label>
				<textarea name="user-submitted-description" title="<?php echo _e('Event Description / Agenda'); ?>" class="user-submitted-subcontent required"  rows="5" placeholder="<?php _e('Event Description / Agenda'); ?>"></textarea>
			</fieldset>
			<fieldset class="usp-content" style='display:none'>	
				<label for="user-submitted-content"><?php _e('Your Event Story'); ?></label>
				<textarea name="user-submitted-content" rows="5" placeholder="<?php _e('Your Event Story'); ?>"></textarea>
			</fieldset>
			<?php 
		}
		if ($usp_options['usp_captcha'] == 'show') { 
			//jairus 
			if($usp_options['usp_question']=='random()'){
				$a = rand(0, 9);
				$b = rand(0, 9);
				$_SESSION['usp_response'] = $a+$b;
				$usp_options['usp_question'] = $a." + ".$b;
			}
			?>
			<fieldset class="usp-captcha">
				<label for="user-submitted-captcha">* Captcha <?php echo $usp_options['usp_question']; ?></label>
				<input name="user-submitted-captcha" class='required' type="text" value="" placeholder="<?php _e('Anti-spam: '); echo $usp_options['usp_question']; ?>">
			</fieldset>
			<?php 
		}
		
		
		if ($usp_options['usp_images'] == 'show') { ?>
		<?php if ($usp_options['max-images'] !== 0) { ?>
		<fieldset class="usp-images">
			<label for="user-submitted-image"><?php _e('Upload Image(s)'); ?></label>
			<div id="usp-upload-message"><?php echo "Event banner/image (220 x 220 px)"; ?></div>
			<div id="user-submitted-image">
				<?php if($usp_options['min-images'] < 1) {
					$numberImages = 1;
				} else {
					$numberImages = $usp_options['min-images'];
				} for($i = 0; $i < $numberImages; $i++) { ?>
				<input name="user-submitted-image[]" type="file" size="25" class="usp-clone">
				<?php } ?>
				<a href="#" id="usp_add-another"><?php _e('Add another image'); ?></a>
			</div>
		</fieldset>
		<?php } ?>
		<?php } ?>
		<fieldset id="coldform_verify" style="display:none;">
			<label for="user-submitted-verify">Human verification: leave this field empty.</label>
			<input name="user-submitted-verify" type="text" value="">
		</fieldset>
		<div id="usp-submit">
			<?php if (!empty($usp_options['redirect-url'])) { ?>
			<input type="hidden" name="redirect-override" value="<?php echo $usp_options['redirect-url']; ?>">
			<?php } ?>
			<?php if ($usp_options['usp_use_author'] == true) { ?>
			<input class="hidden" type="hidden" name="user-submitted-name" value="<?php echo $current_user->user_login; ?>">
			<?php } ?>
			<?php if ($usp_options['usp_use_url'] == true) { ?>
			<input class="hidden" type="hidden" name="user-submitted-url" value="<?php echo $current_user->user_url; ?>">
			<?php } ?>
			<?php if ($usp_options['usp_use_cat'] == true) { ?>
			<input class="hidden" type="hidden" name="user-submitted-category" value="<?php echo $usp_options['usp_use_cat_id']; ?>">
			<?php } ?>
			<input name="user-submitted-post" type="submit" value="<?php _e('Submit Post'); ?>">
		</div>

		<?php } ?>

	</form>
</div>
<script>(function(){var e = document.getElementById("coldform_verify");e.parentNode.removeChild(e);})();</script>
<script>
function populateContent(){
	missing = false;
	jQuery(".required").each(function(){
		if(!jQuery(this).val()){
			missing = true;
			jQuery(this).css("border", "2px solid red");
		}
	});
	if(missing){
		alert("Please complete all required fields.");
		return false;
	}
	
	contentstr = "";
	jQuery(".user-submitted-subcontent").each(function(){
		contentstr += "<b>"+jQuery(this).attr("title")+": </b>\n"+jQuery(this).val()+"\n\n~~*~~\n\n";
	});
	jQuery('[name="user-submitted-content"]').val(contentstr);
	return true;
}
<?php
function sanitizeX($str){
	$str = addslashes($str);
	$str = str_replace("\n", "\\n", $str);
	$str = str_replace("\r", "\\r", $str);
	return $str;
}

if(is_array($_SESSION['user-submitted'])&&$_GET['submission-error']){
	foreach($_SESSION['user-submitted'] as $key=>$value){
		?>jQuery('[name="<?php echo $key; ?>"]').val("<?php echo sanitizeX($value); ?>");<?php
	}
}
?>
</script>

<!-- User Submitted Posts @ http://perishablepress.com/user-submitted-posts/ -->
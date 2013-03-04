<?php // User Submitted Posts - HTML5 Submission Form
//jairus
@session_start();
global $usp_options, $current_user;

$author_ID  = $usp_options['author'];
$default_author = get_the_author_meta('display_name', $author_ID);
if ($authorName == $default_author) {
	$authorName = '';
} ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<!-- User Submitted Posts @ http://perishablepress.com/user-submitted-posts/ -->
<div id="user-submitted-posts">

	<?php if ($usp_options['usp_form_content'] !== '') {
		echo $usp_options['usp_form_content'];
	} ?>
	
	<form method="post" enctype="multipart/form-data" action="?sid=<?php echo session_id(); ?>" onsubmit="return populateContent()">

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
				<label for="user-submitted-title"><?php _e('Organizer Website'); ?></label>
				<input name="user-submitted-organizerlink" title="<?php echo _e('Organizer Website'); ?>" class="user-submitted-subcontent"  type="text" value="" placeholder="<?php _e('E.g. http://www.e27.sg'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Start Date / Time'); ?></label>
				<input name="user-submitted-startdate" title="<?php echo _e('Start'); ?>" class="datepicker user-submitted-subcontent required" type="text" value="" placeholder="" style='width:200px'>
				&nbsp;<select name="user-submitted-starttimeh"><?php
				for($i=1; $i<=12; $i++){
					$n = substr("0".$i, -2);
					echo "<option value='".$n."'>".$n."</option>";
				}
				
				?></select>
				<select name="user-submitted-starttimem"><?php
				for($i=0; $i<=59; $i++){
					$n = substr("0".$i, -2);
					echo "<option value='".$n."'>".$n."</option>";
				}
				
				?></select>
				<select name="user-submitted-starttimea">
					<option value='a.m.'>a.m</option>
					<option value='p.m.'>p.m</option>
				</select>
				
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('End Date'); ?></label>
				<input name="user-submitted-enddate" title="<?php echo _e('End'); ?>" class="datepicker user-submitted-subcontent required" type="text" value="" placeholder="" style='width:200px'>
				&nbsp;<select name="user-submitted-endtimeh"><?php
				for($i=1; $i<=12; $i++){
					$n = substr("0".$i, -2);
					echo "<option value='".$n."'>".$n."</option>";
				}
				
				?></select>
				<select name="user-submitted-endtimem"><?php
				for($i=0; $i<=59; $i++){
					$n = substr("0".$i, -2);
					echo "<option value='".$n."'>".$n."</option>";
				}
				
				?></select>
				<select name="user-submitted-endtimea">
					<option value='a.m.'>a.m</option>
					<option value='p.m.'>p.m</option>
				</select>
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Location'); ?></label>
				<input name="user-submitted-location" title="<?php echo _e('Location'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('Location'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Country'); ?></label>
				<!--<input name="user-submitted-country" title="<?php echo _e('Country'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('Country'); ?>">-->
				<select name="user-submitted-country">
				<option value="Andorra">Andorra</option>
				<option value="United Arab Emirates">United Arab Emirates</option>
				<option value="Afghanistan">Afghanistan</option>
				<option value="Antigua and Barbuda">Antigua and Barbuda</option>
				<option value="Anguilla">Anguilla</option>
				<option value="Albania">Albania</option>
				<option value="Armenia">Armenia</option>
				<option value="Angola">Angola</option>
				<option value="Antarctica">Antarctica</option>
				<option value="Argentina">Argentina</option>
				<option value="American Samoa">American Samoa</option>
				<option value="Austria">Austria</option>
				<option value="Australia">Australia</option>
				<option value="Aruba">Aruba</option>
				<option value="Åland Islands">Åland Islands</option>
				<option value="Azerbaijan">Azerbaijan</option>
				<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
				<option value="Barbados">Barbados</option>
				<option value="Bangladesh">Bangladesh</option>
				<option value="Belgium">Belgium</option>
				<option value="Burkina Faso">Burkina Faso</option>
				<option value="Bulgaria">Bulgaria</option>
				<option value="Bahrain">Bahrain</option>
				<option value="Burundi">Burundi</option>
				<option value="Benin">Benin</option>
				<option value="Saint Barthélemy">Saint Barthélemy</option>
				<option value="Bermuda">Bermuda</option>
				<option value="Brunei Darussalam">Brunei Darussalam</option>
				<option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
				<option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
				<option value="Brazil">Brazil</option>
				<option value="Bahamas">Bahamas</option>
				<option value="Bhutan">Bhutan</option>
				<option value="Bouvet Island">Bouvet Island</option>
				<option value="Botswana">Botswana</option>
				<option value="Belarus">Belarus</option>
				<option value="Belize">Belize</option>
				<option value="Canada">Canada</option>
				<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
				<option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
				<option value="Central African Republic">Central African Republic</option>
				<option value="Congo">Congo</option>
				<option value="Switzerland">Switzerland</option>
				<option value="Côte d\'Ivoire">Côte d\'Ivoire</option>
				<option value="Cook Islands">Cook Islands</option>
				<option value="Chile">Chile</option>
				<option value="Cameroon">Cameroon</option>
				<option value="China">China</option>
				<option value="Colombia">Colombia</option>
				<option value="Costa Rica">Costa Rica</option>
				<option value="Cuba">Cuba</option>
				<option value="Cape Verde">Cape Verde</option>
				<option value="Curaçao">Curaçao</option>
				<option value="Christmas Island">Christmas Island</option>
				<option value="Cyprus">Cyprus</option>
				<option value="Czech Republic">Czech Republic</option>
				<option value="Germany">Germany</option>
				<option value="Djibouti">Djibouti</option>
				<option value="Denmark">Denmark</option>
				<option value="Dominica">Dominica</option>
				<option value="Dominican Republic">Dominican Republic</option>
				<option value="Algeria">Algeria</option>
				<option value="Ecuador">Ecuador</option>
				<option value="Estonia">Estonia</option>
				<option value="Egypt">Egypt</option>
				<option value="Western Sahara">Western Sahara</option>
				<option value="Eritrea">Eritrea</option>
				<option value="Spain">Spain</option>
				<option value="Ethiopia">Ethiopia</option>
				<option value="Finland">Finland</option>
				<option value="Fiji">Fiji</option>
				<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
				<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
				<option value="Faroe Islands">Faroe Islands</option>
				<option value="France">France</option>
				<option value="Gabon">Gabon</option>
				<option value="United Kingdom">United Kingdom</option>
				<option value="Grenada">Grenada</option>
				<option value="Georgia">Georgia</option>
				<option value="French Guiana">French Guiana</option>
				<option value="Guernsey">Guernsey</option>
				<option value="Ghana">Ghana</option>
				<option value="Gibraltar">Gibraltar</option>
				<option value="Greenland">Greenland</option>
				<option value="Gambia">Gambia</option>
				<option value="Guinea">Guinea</option>
				<option value="Guadeloupe">Guadeloupe</option>
				<option value="Equatorial Guinea">Equatorial Guinea</option>
				<option value="Greece">Greece</option>
				<option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
				<option value="Guatemala">Guatemala</option>
				<option value="Guam">Guam</option>
				<option value="Guinea-Bissau">Guinea-Bissau</option>
				<option value="Guyana">Guyana</option>
				<option value="Hong Kong">Hong Kong</option>
				<option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
				<option value="Honduras">Honduras</option>
				<option value="Croatia">Croatia</option>
				<option value="Haiti">Haiti</option>
				<option value="Hungary">Hungary</option>
				<option value="Indonesia">Indonesia</option>
				<option value="Ireland">Ireland</option>
				<option value="Israel">Israel</option>
				<option value="Isle of Man">Isle of Man</option>
				<option value="India">India</option>
				<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
				<option value="Iraq">Iraq</option>
				<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
				<option value="Iceland">Iceland</option>
				<option value="Italy">Italy</option>
				<option value="Jersey">Jersey</option>
				<option value="Jamaica">Jamaica</option>
				<option value="Jordan">Jordan</option>
				<option value="Japan">Japan</option>
				<option value="Kenya">Kenya</option>
				<option value="Kyrgyzstan">Kyrgyzstan</option>
				<option value="Cambodia">Cambodia</option>
				<option value="Kiribati">Kiribati</option>
				<option value="Comoros">Comoros</option>
				<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
				<option value="North Korea">North Korea</option>
				<option value="South Korea">South Korea</option>
				<option value="Kuwait">Kuwait</option>
				<option value="Cayman Islands">Cayman Islands</option>
				<option value="Kazakhstan">Kazakhstan</option>
				<option value="Lao People\'s Democratic Republic">Lao People\'s Democratic Republic</option>
				<option value="Lebanon">Lebanon</option>
				<option value="Saint Lucia">Saint Lucia</option>
				<option value="Liechtenstein">Liechtenstein</option>
				<option value="Sri Lanka">Sri Lanka</option>
				<option value="Liberia">Liberia</option>
				<option value="Lesotho">Lesotho</option>
				<option value="Lithuania">Lithuania</option>
				<option value="Luxembourg">Luxembourg</option>
				<option value="Latvia">Latvia</option>
				<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
				<option value="Morocco">Morocco</option>
				<option value="Monaco">Monaco</option>
				<option value="Moldova, Republic of">Moldova, Republic of</option>
				<option value="Montenegro">Montenegro</option>
				<option value="Saint Martin (French part)">Saint Martin (French part)</option>
				<option value="Madagascar">Madagascar</option>
				<option value="Marshall Islands">Marshall Islands</option>
				<option value="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
				<option value="Mali">Mali</option>
				<option value="Myanmar">Myanmar</option>
				<option value="Mongolia">Mongolia</option>
				<option value="Macao">Macao</option>
				<option value="Northern Mariana Islands">Northern Mariana Islands</option>
				<option value="Martinique">Martinique</option>
				<option value="Mauritania">Mauritania</option>
				<option value="Montserrat">Montserrat</option>
				<option value="Malta">Malta</option>
				<option value="Mauritius">Mauritius</option>
				<option value="Maldives">Maldives</option>
				<option value="Malawi">Malawi</option>
				<option value="Mexico">Mexico</option>
				<option value="Malaysia">Malaysia</option>
				<option value="Mozambique">Mozambique</option>
				<option value="Namibia">Namibia</option>
				<option value="New Caledonia">New Caledonia</option>
				<option value="Niger">Niger</option>
				<option value="Norfolk Island">Norfolk Island</option>
				<option value="Nigeria">Nigeria</option>
				<option value="Nicaragua">Nicaragua</option>
				<option value="Netherlands">Netherlands</option>
				<option value="Norway">Norway</option>
				<option value="Nepal">Nepal</option>
				<option value="Nauru">Nauru</option>
				<option value="Niue">Niue</option>
				<option value="New Zealand">New Zealand</option>
				<option value="Oman">Oman</option>
				<option value="Panama">Panama</option>
				<option value="Peru">Peru</option>
				<option value="French Polynesia">French Polynesia</option>
				<option value="Papua New Guinea">Papua New Guinea</option>
				<option value="Philippines">Philippines</option>
				<option value="Pakistan">Pakistan</option>
				<option value="Poland">Poland</option>
				<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
				<option value="Pitcairn">Pitcairn</option>
				<option value="Puerto Rico">Puerto Rico</option>
				<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
				<option value="Portugal">Portugal</option>
				<option value="Palau">Palau</option>
				<option value="Paraguay">Paraguay</option>
				<option value="Qatar">Qatar</option>
				<option value="Réunion">Réunion</option>
				<option value="Romania">Romania</option>
				<option value="Serbia">Serbia</option>
				<option value="Russian Federation">Russian Federation</option>
				<option value="Rwanda">Rwanda</option>
				<option value="Saudi Arabia">Saudi Arabia</option>
				<option value="Solomon Islands">Solomon Islands</option>
				<option value="Seychelles">Seychelles</option>
				<option value="Sudan">Sudan</option>
				<option value="Sweden">Sweden</option>
				<option value="Singapore" selected="selected">Singapore</option>
				<option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
				<option value="Slovenia">Slovenia</option>
				<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
				<option value="Slovakia">Slovakia</option>
				<option value="Sierra Leone">Sierra Leone</option>
				<option value="San Marino">San Marino</option>
				<option value="Senegal">Senegal</option>
				<option value="Somalia">Somalia</option>
				<option value="Suriname">Suriname</option>
				<option value="Sao Tome and Principe">Sao Tome and Principe</option>
				<option value="El Salvador">El Salvador</option>
				<option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
				<option value="Syrian Arab Republic">Syrian Arab Republic</option>
				<option value="Swaziland">Swaziland</option>
				<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
				<option value="Chad">Chad</option>
				<option value="French Southern Territories">French Southern Territories</option>
				<option value="Togo">Togo</option>
				<option value="Thailand">Thailand</option>
				<option value="Tajikistan">Tajikistan</option>
				<option value="Tokelau">Tokelau</option>
				<option value="Timor-Leste">Timor-Leste</option>
				<option value="Turkmenistan">Turkmenistan</option>
				<option value="Tunisia">Tunisia</option>
				<option value="Tonga">Tonga</option>
				<option value="Turkey">Turkey</option>
				<option value="Trinidad and Tobago">Trinidad and Tobago</option>
				<option value="Tuvalu">Tuvalu</option>
				<option value="Taiwan">Taiwan</option>
				<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
				<option value="Ukraine">Ukraine</option>
				<option value="Uganda">Uganda</option>
				<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
				<option value="United States">United States</option>
				<option value="Uruguay">Uruguay</option>
				<option value="Uzbekistan">Uzbekistan</option>
				<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
				<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
				<option value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
				<option value="Virgin Islands, British">Virgin Islands, British</option>
				<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
				<option value="Vietnam">Vietnam</option>
				<option value="Vanuatu">Vanuatu</option>
				<option value="Wallis and Futuna">Wallis and Futuna</option>
				<option value="Samoa">Samoa</option>
				<option value="Yemen">Yemen</option>
				<option value="Mayotte">Mayotte</option>
				<option value="South Africa">South Africa</option>
				<option value="Zambia">Zambia</option>
				<option value="Zimbabwe">Zimbabwe</option>
			</select>
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title">* <?php _e('Your E-mail'); ?></label>
				<input name="user-submitted-email" title="<?php echo _e('Your E-mail'); ?>" class="user-submitted-subcontent required"  type="text" value="" placeholder="<?php _e('Your E-mail'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title"><?php _e('Registration Link'); ?></label>
				<input name="user-submitted-registrationlink" title="<?php echo _e('Registration Link'); ?>" class="user-submitted-subcontent"  type="text" value="" placeholder="<?php _e('Registration Link'); ?>">
			</fieldset>
			<fieldset class="usp-content">
				<label for="user-submitted-title"><?php _e('Discount Code'); ?></label>
				<input name="user-submitted-discountcode" title="<?php echo _e('Discount Code'); ?>" class="user-submitted-subcontent"  type="text" value="" placeholder="<?php _e(''); ?>">
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
		
		
		if ($usp_options['usp_tags'] == 'show') { 
			?>
			<fieldset class="usp-tags">
				<label for="user-submitted-tags"><?php _e('Tags'); ?></label>
				<input name="user-submitted-tags" id="user-submitted-tags" type="text" value="" placeholder="<?php _e('E.g. events, meetup, startup'); ?>">
			</fieldset>
			<?php 
		} 
		
		if ($usp_options['usp_images'] == 'show') { ?>
		<?php if ($usp_options['max-images'] !== 0) { ?>
		<fieldset class="usp-images">
			<label for="user-submitted-image"><?php _e('Upload Image(s)'); ?></label>
			<div id="usp-upload-message"><?php echo "Event banner/image (300 x 300 px)"; ?></div>
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
		<?php } 
		
		
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
		
		?>
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
<script>
//jQuery(".datepicker").datepicker( "option", "dateFormat", "DD, d MM, yy" );
jQuery(".datepicker").datepicker();
jQuery(".datepicker").datepicker( "option", "dateFormat", "DD, d MM, yy" );
</script>
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
	/*
	Title: <Event Name>

	<body>
	<Event Description/Agenda>
	
	Event details:
	Date: <Start Date> - <End Date>
	Time: <Start Time> - <End Time>
	Venue: <Location>
	
	Register Here <-- insert registration link here
	
	</body>
		
	user-submitted-title
	user-submitted-organizer
	user-submitted-startdate
	user-submitted-location
	user-submitted-registrationlink
	user-submitted-description
	*/
	/*
	jQuery(".user-submitted-subcontent").each(function(){
		contentstr += "<b>"+jQuery(this).attr("title")+": </b>\n"+jQuery(this).val()+"\n\n~~*~~\n\n";
	});
	*/
	
	
	
	country = jQuery('[name="user-submitted-country"]').val();
	email = jQuery('[name="user-submitted-email"]').val();
	
	if(!country){
		country = "Event";
	}
	
	title = jQuery('[name="user-submitted-title"]').val();
	jQuery('[name="user-submitted-title"]').val("["+country+"] "+title);
	description = jQuery('[name="user-submitted-description"]').val();
	startdate = jQuery('[name="user-submitted-startdate"]').val();
	enddate = jQuery('[name="user-submitted-enddate"]').val();
	starttimeh = jQuery('[name="user-submitted-starttimeh"]').val();
	starttimem = jQuery('[name="user-submitted-starttimem"]').val();
	starttimea = jQuery('[name="user-submitted-starttimea"]').val();
	endtimeh = jQuery('[name="user-submitted-endtimeh"]').val();
	endtimem = jQuery('[name="user-submitted-endtimem"]').val();
	endtimea = jQuery('[name="user-submitted-endtimea"]').val();
	locationx = jQuery('[name="user-submitted-location"]').val();
	registrationlink = jQuery('[name="user-submitted-registrationlink"]').val();
	discountcode = jQuery('[name="user-submitted-discountcode"]').val();
	organizer = jQuery('[name="user-submitted-organizer"]').val();
	organizerlink = jQuery('[name="user-submitted-organizerlink"]').val();
	tags = jQuery('[name="user-submitted-tags"]').val();
	tags = tags.toLowerCase();
	if(tags.indexOf("events")==-1){
		tags = "events, "+jQuery('[name="user-submitted-tags"]').val();
		jQuery('[name="user-submitted-tags"]').val(tags);
	}
	
	contentstr += "<h3>"+title+"</h3>";
	contentstr += "<p>"+description+"</p>";
	contentstr += "<p>Event details:</p>";
	contentstr += "<ul>";
	contentstr += "<li><strong>Start</strong>: "+startdate+" "+starttimeh+":"+starttimem+" "+starttimea+"</li>";
	contentstr += "<li><strong>End</strong>: "+enddate+" "+endtimeh+":"+endtimem+" "+endtimea+"</li>";
	contentstr += "<li><strong>Venue</strong> : "+locationx+"</li>";
	if(country){
		contentstr += "<li><strong>Country</strong> :"+country+"</li>";
	}
	if(email){
		contentstr += "<li><strong>E-mail</strong> :"+email+"</li>";
	}
	if(registrationlink){
		contentstr += "<li><a href='"+registrationlink+"'>Register here</a></li>";
	}
	if(discountcode){
		contentstr += "<li><strong>Discount Code</strong> :"+discountcode+"</li>";
	}
	if(organizerlink){
		contentstr += "<li><strong>Organizer</strong> : <a href='"+organizerlink+"'>"+organizer+"</a></li>";
	}
	else{
		contentstr += "<li><strong>Organizer</strong> : "+organizer+"</li>";
	}
	contentstr += "</ul>";

	
	
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
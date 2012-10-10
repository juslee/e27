<?php 
include("../lib/dbcon.php"); 
//include("../classes/class.acl.php");


//$com_id=$_GET['test'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width">
<title>StartupList - Admin</title>
<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" title="default" />
<script type="text/javascript" src="../js/jquery-1.4.1.min.js" ></script>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() {
Cufon.replace('h1', { fontFamily: 'myriadreg' });
Cufon.replace('h2', { fontFamily: 'helvthin' });
Cufon.replace('h3', { fontFamily: 'myriadreg' });
Cufon.replace('h4', { fontFamily: 'myriadreg' });
Cufon.replace('h5', { fontFamily: 'myriadreg' });
Cufon.replace('h6', { fontFamily: 'helvthin' });
Cufon.replace('h7', { fontFamily: 'myriadreg' });
Cufon.replace('arrow', { fontFamily: 'myriadreg' });
Cufon.replace('heading', { fontFamily: 'Museo' });
Cufon.replace('museo', { fontFamily: 'Museo' });
Cufon.replace('details', { fontFamily: 'Myriad Pro' });
Cufon.replace('shadow', { fontFamily: 'myriadreg' });
});
</script>
<script type="text/javascript">
// ================== SCROLL FOLLOW DIV FUNCTION ================== //
$(function() {
    var offset = $("#sidebar").offset();
    var topPadding = 45;
    $(window).scroll(function() {
        if ($(window).scrollTop() > offset.top) {
            $("#sidebar").stop().animate({
                marginTop: $(window).scrollTop() - offset.top + topPadding
            });
        } else {
            $("#sidebar").stop().animate({
                marginTop: 0
            });
        };
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
	var SubInvestment_count = 1;
	var Subcomp_count = 1;
	var SubCompanies = [];
	var SubInvestment = [];
	var profile_person_active1 = '0';
	var ccv;
	var ccvv;
	
	$(".display_boxp").live("click", function () {
		var thi = $(this).attr("id");
		
		$("#cName" + ccv).val(thi);
		$('#cName' + ccv).keydown(function () {
			var cName = $('#cName' + ccv).val();
			if (cName == '') {
				$("#displayp" + ccv).hide();
			}
		});
	});
	$('#new_Companies').live('click', function () {
		
		$('#Companies_part').before('<br><ul class="company_details" id="comp' + Subcomp_count + '"><li><label>Company' + Subcomp_count + '</label><input type="text" class="search" id="cName' + Subcomp_count + '" name="0" title="' + Subcomp_count + '"/></li><li><label>Role</label><input type="text" class="common_input" id="cRole' + Subcomp_count + '" /></li><li><label>Start Date</label><input type="text" class="common_input" id="cStart' + Subcomp_count + '"  /></li><li><label>End Date</label><input type="text" class="common_input" id="cEnd' + Subcomp_count + '" /></li><div class="disZ" id="displayp' + Subcomp_count + '"></div></ul><div class="clear"></div>');
		Subcomp_count++;
		$(".search").keyup(function () {
			var searchbox = $(this).val();
			ccv = $(this).attr('title');
			//alert(ccv);
			var dataString = '&searchword=' + searchbox;
			//alert(dataString);
			if (searchbox == '') {}
			else {
				
				$.ajax({
					type : "POST",
					url : "searchPeoplePage.php",
					data : dataString,
					cache : false,
					success : function (html) {
						//alert(html);
						$("#displayp" + ccv).html(html).show();
						$('#cName' + ccv).keydown(function () {
							var cName = $('#cName' + ccv).val();
							if (cName == '') {
								$("#displayp" + ccv).hide();
							}
						});
						$("#displayp" + ccv).live("mouseenter", function () {}).live("click", function () {
							$("#displayp"+ ccv).hide();
						});
					}
				});
			}
			return false;
			
		});
	});
	$(".display_boxpi").live("click", function () {
		var thinv = $(this).attr("id");
		//alert(thinv);
		$("#IName" + ccvv).val(thinv);
		$('#IName' + ccvv).keydown(function () {
			var IName = $('#IName' + ccvv).val();
			if (IName == '') {
				$("#displayF" + ccvv).hide();
			}
		});
	});
	$('#new_Investment').live('click', function () {
		
		$('#Investment_part').before('<br><ul class="company_details" id="inve' + SubInvestment_count + '"><li><label>Investment' + SubInvestment_count + '</label><input type="text" class="searchF" id="IName' + SubInvestment_count + '" name="0" title="' + SubInvestment_count + '" /></li><li><label>Role</label><input type="text" class="common_input" id="IRole' + SubInvestment_count + '" /></li><li><label>Start Date</label><input type="text" class="common_input" id="IStart' + SubInvestment_count + '"  /></li><li><label>End Date</label><input type="text" class="common_input" id="IEnd' + SubInvestment_count + '" /></li><div class="disZ" id="displayF' + SubInvestment_count + '"></div></ul><div class="clear"></div>');
		SubInvestment_count++;
		 $(".searchF").keyup(function () {
			var searchbox = $(this).val();
			ccvv= $(this).attr('title');
			//alert(searchbox);
			var dataString = 'searchword=' + searchbox;
			
			if (searchbox == '') {}
			else {
				
				$.ajax({
					type : "POST",
					url : "searchInvOrg.php",
					data : dataString,
					cache : false,
					success : function (html) {
						//alert(html);
						$("#displayF"+ccvv).html(html).show();
						$('#IName' + ccvv).keydown(function () {
							var IName = $('#IName' + ccvv).val();
							if (IName == '') {
								$("#displayF" + ccvv).hide();
							}
						});
						$("#displayF" + ccvv).live("mouseenter", function () {}).live("click", function () {
							$("#displayF" + ccvv).hide();
						});
					}
				});
			}
			return false;
			
		});
		
	});
	
	//****************Start Submit section******************//
	$('#addperson').live('click', function () {
		submit();
		
	});
	
	function submit() {
		var sa = 1;
		var a = 0;
		while (sa < Subcomp_count) {
			
			SubCompanies[a] = $("#cName" + sa).val();
			SubCompanies[a + 1] = $("#cRole" + sa).val();
			SubCompanies[a + 2] = $("#cStart" + sa).val();
			SubCompanies[a + 3] = $("#cEnd" + sa).val();
			//alert(del[a]);
			sa++;
			a = a + 4;
		}
		
		var sb = 1;
		var b = 0;
		while (sb < SubInvestment_count) {
			
			SubInvestment[b] = $("#IName" + sb).val();
			SubInvestment[b + 1] = $("#IRole" + sb).val();
			SubInvestment[b + 2] = $("#IStart" + sb).val();
			SubInvestment[b + 3] = $("#IEnd" + sb).val();
			//alert(del[a]);
			sb++;
			b = b + 4;
		}
		
		var stringifyCompaniesSub = JSON.stringify(SubCompanies);
		var stringifyInvestmentSub = JSON.stringify(SubInvestment);
		//alert(stringifyCompaniesSub);
		var profile_person_id = $("#profile_person_id").val();
		var profile_person_name = $("#profile_person_name").val();
		var profile_person_blog_url = $("#profile_person_blog_url").val();
		var profile_person_twitter_username = $("#profile_person_twitter_username").val();
		var profile_person_linkedin_username = $("#profile_person_linkedin_username").val();
		var profile_person_image = $("#img22").attr('class');
		var profile_person_des = $("#profile_person_des").val();
		var profile_person_email = $("#profile_person_email").val();
		var profile_person_active = $("#profile_person_active").val();
		if (profile_person_active == 'on') {
			
			profile_person_active1 = '1';
			
		} else {
			profile_person_active1 = '0';
		}
		var dataString = '&profile_person_name=' + profile_person_name + '&profile_person_blog_url=' + profile_person_blog_url + '&profile_person_twitter_username=' + profile_person_twitter_username + '&profile_person_linkedin_username=' + profile_person_linkedin_username + '&profile_person_image=' + profile_person_image + '&profile_person_des=' + profile_person_des + '&profile_person_email=' + profile_person_email + '&profile_person_active=' + profile_person_active1 + '&stringifyCompaniesSub=' + stringifyCompaniesSub + '&stringifyInvestmentSub=' + stringifyInvestmentSub;
		/* var atpos = profile_person_email.indexOf("@");
		var dotpos = profile_person_email.lastIndexOf("."); */
		//alert(dataString);
		 if (profile_person_name == '' || profile_person_email == '') {
			// $('.success').fadeOut(200).hide();
			$('.error').fadeIn(400).delay(4000).fadeOut(400);
			
		} else {
			$.ajax({
				type : "POST",
				url : "../lib/peopleSubmit.php",
				data : dataString,
				success : function (data) {
					//alert(data);
					if (data == 0) {
						$('#info').html('Person Already Exists.').fadeIn(400).delay(4000).fadeOut(400);
					} else {
						$('.success').fadeIn(400).delay(4000).fadeOut(400);
						$("#profile_person_name").val('');
						$("#profile_person_blog_url").val('');
						$("#profile_person_twitter_username").val('');
						$("#profile_person_linkedin_username").val('');
						$("#profile_person_image").val('');
						$("#profile_person_des").val('');
						$("#profile_person_email").val('');
						$("#profile_person_active").val('');
						$("#img22").slideToggle(500);
						$("#timg2").slideToggle(500);
						$("#slide_toggle").slideToggle(500);
						$("#slide_toggle1").slideToggle(500);
						
					}
				}
			});
		} 
		return false;
		
	}
	$("#profile_person_email").keyup(function(){
		
			var email = $("#profile_person_email").val();
		
			if(email != 0)
			{
				if(isValidEmailAddress(email))
				{
					$("#validEmail").css({
						"background-image": "url('../img/validYes.png')"
					});
				} else {
					$("#validEmail").css({
						"background-image": "url('../img/validNo.png')"
					});
				}
			} else {
				$("#validEmail").css({
					"background-image": "none"
				});			
			}
		
		});
		function isValidEmailAddress(emailAddress) {
 		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
 		return pattern.test(emailAddress);
	}
	$('#profile_person_image').live('change', function () {
		$("#preview2").html('');
		$("#preview2").html('<img src="loader.gif" alt="Uploading...."/>');
		$("#imageform2").ajaxForm({
			target : '#preview2'
		}).submit();
	});
	//****************Href Name Autofill******************//
	$.urlParam = function (profilePerson_name) {
		var results = new RegExp('[\\?&]' + profilePerson_name + '=([^&#]*)').exec(window.location.href);
		return results[1] || 0;
	}
	//alert('profilePerson_name');
	
	var profilePerson_name = $.urlParam('profilePerson_name');
	if (profilePerson_name != '') {
		$('#profile_person_name').val('' + profilePerson_name);
	}

	//****************End Submit section******************//
	
	
});
</script>

</head>



<body>
<div id="wrapper">
		<?php include('../lib/left_bar.php');?>
	<div class="clear"></div>
	
	<div id="main_content">
		<div id="sidebar" style="display:none">
			<span class="small">
			</span>
		</div>
		
		<h2 class="form_title">Add Person</h2>
		<div id="form_container">
			<div id="form_top"></div>
			<div id="id-form" class="order">
				<div class="form_midblue">
					<!-- // ========== DETAILS ============ // -->
					<ul class="company_details">
						<li><label>Name:</label>
						<input id="profile_person_name" type="text" name="profile_person_name" class="text" tabindex="" value="" /></li>
						<!--<li><label >Last Name:</label>
						<input id="profile_person_lname" type="text" name="profile_person_lname" class="text" tabindex="" value="" placeholder=""/></li>-->
						<li><label>Blog url:</label>
						<input  id="profile_person_blog_url" name="profile_person_blog_url" type="text" class="text" tabindex="" placeholder="" value=""/></li>
						<li><label>Twitter username:</label>
						<input id="profile_person_twitter_username" type="text" name="profile_person_twitter_username" class="text" tabindex="" value="" placeholder="" /></li>
						<li><label>LinkedIn username:</label>
						<input id="profile_person_linkedin_username" type="text" name="profile_person_linkedin_username" class="text" tabindex="" value="" placeholder=""/></li>
						<li><label>Profile Image:</label>
						<form id="imageform2" method="post" enctype="multipart/form-data" action='ajaximagePeople.php'><input type='hidden' id='timg2' value=""/>
						<input type="file" name="profile_person_image" id="profile_person_image" class="file_1" tabindex=""/><div id="preview2" title='' style='' ></div><div class="clear"></div>
						</form></li>
						<li><label>Description:</label>
						<textarea id="profile_person_des" type="text" name="profile_person_des" class="textarea" tabindex="" placeholder="" rows="10"></textarea></li>
						<li><label>Email:</label>
						<input id="profile_person_email" type="text" name="profile_person_email" class="text" tabindex="" placeholder="" value=""/><span id="validEmail"></span></li>
						
						<li>
							<label >Active?:</label>
							<select id="profile_person_active" name="profile_person_active" tabindex=""  class="" >
							<option value=""></option>
							<option value="on">Active</option>
							<option value="off">Not Active</option>
							</select></li>	
							
							<div class="clear"></div>							
					</ul>
				</div>
				<div class="form_midyellow">
					<!-- // ========== Companies  ============ // -->
					<ul class="company_details">
						<li><label>Companies:</label><img id='new_Companies' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
							</li><div id='slide_toggle'><div id='Companies_part'></div></div><div style=" width:300px; float:right;left:345px;position:absolute; z-index:2;" align="right"><div id="display"></div></div>
						<div class="clear"></div>
					</ul>
				</div>
				<div class="form_midyellow">
					<!-- // ========== Investment Organizations  ============ // -->
					<ul class="company_details">
						<li><label >Investment Org:</label><img id='new_Investment' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
							</li><div id='slide_toggle1'><div id='Investment_part'></div></div><div style=" width:300px; float:right;left:345px;position:absolute; z-index:2;" align="right"><div id="display"></div></div>
						<div class="clear"></div>
					</ul>
				</div>
				<div class="form_midblue">
					<!-- // ========== BUTTONS ============ // -->
					
					<a href="#_" id="addperson" class="fright"></a>
					<div id='info' style=''></div>
					<span class="error" style="display:none">Please Enter Valid Data</span><span  class="success" style="display:none">Person Successfully Created.</span>
					<span  class="echoerror" style=""></span>
					<div class="clear"></div>
				</div>
				<div id="form_btm"></div>
			</div>
		</div>
	</div>
</div> <!-- close wrapper -->
</body>
</html>
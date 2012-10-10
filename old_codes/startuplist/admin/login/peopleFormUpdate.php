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
	$.urlParam = function (test) {
		var results = new RegExp('[\\?&]' + test + '=([^&#]*)').exec(window.location.href);
		return results[1] || 0;
	}
	var peopleId = $.urlParam('test');
	//alert(peopleId);
	//var companyId=<?echo $com_id?>;
	var Comp_count = 1;
	var Inve_count = 1;
	var Comp = [];
	var Inve = [];
	var ccv;
	var ccvv;
		//alert(companyId);
		getPeopleInfo(peopleId);
	function getPeopleInfo(peopleId) {
		$.getJSON('getPeopleInfo.php?peopleId=' + peopleId, function (datac) {
			//alert(datac.peopleBasic);
			$('#profile_person_name').val('' + datac.peopleBasic[0]);
			$('#profile_person_blog_url').val('' + datac.peopleBasic[1]);
			$('#profile_person_twitter_username').val('' + datac.peopleBasic[2]);
			$('#profile_person_linkedin_username').val('' + datac.peopleBasic[3]);
			$('#timg2').val('' + datac.peopleBasic[4]);
			$('#profile_person_des').val('' + datac.peopleBasic[5]);
			$('#profile_person_email').val('' + datac.peopleBasic[6]);
			$('#profile_person_active').val('' + datac.peopleBasic[7]);
			$('#profile_people_id').val('' + datac.peopleBasic[8]);
			$('#profilePersonOld').val('' + datac.peopleBasic[0]);
			$('#preview2').html('<center><img src="../img/uploads/' + datac.peopleBasic[4] + '" style="width:90px;height:90px" id="comp_image" class=' + datac.peopleBasic[4] + '></center>');
			
			var CompLength = datac.peopleCompanies.length;
			//alert(datac.peopleCompanies);
			var CompCounArray = 0;
			var cCoun = 1;
			var CompCounUpdate = 1;
			while (CompCounUpdate < CompLength) {
				$('#Companies_part').before('<br><ul class="company_details" id="delUlC' + cCoun + '"><li><label>Companies' + cCoun + ':</label><input disabled="disabled" type="text" class="common_input" id="cName' + cCoun + '" name="' + datac.peopleCompanies[CompCounArray] + '" value="' + datac.peopleCompanies[CompCounArray + 1] + '" ></li><li><label>Role</label><input disabled="disabled" type="text" class="common_input" id="cRole' + cCoun + '" value="' + datac.peopleCompanies[CompCounArray + 2] + '" /></li><li><label>Start Date</label><input disabled="disabled" type="text" class="common_input" id="cStart' + cCoun + '" value="' + datac.peopleCompanies[CompCounArray + 3] + '" /></li><li><label>End Date</label><input  disabled="disabled" type="text" class="common_input" id="cEnd' + cCoun + '" value="' + datac.peopleCompanies[CompCounArray + 4] + '" /><a href="#nogo" id="minus"  style="float:right;margin: 5px 0px 10px 20px;" class="delUlC' + cCoun + '" title="comp" name="' + datac.peopleCompanies[CompCounArray] + '" ><img src="../img/button_minus.png" style="height:25px;width:25px;" tabindex="15"/></a></li></ul>');
				cCoun++;
				CompCounArray = CompCounArray + 5;
				Comp_count++;
				CompCounUpdate = CompCounUpdate + 5;
			}
			
			var InveLength = datac.peopleInvestment.length;
			//alert(datac.peopleInvestment);
			var InveCounArray = 0;
			var ICoun = 1;
			var InveCounUpdate = 1;
			while (InveCounUpdate < InveLength) {
				$('#Investment_part').before('<br><ul class="company_details" id="delUlI' + ICoun + '"><li><label>Investment' + ICoun + ':</label><input disabled="disabled" type="text" class="common_input" id="IName' + ICoun + '" name="' + datac.peopleInvestment[InveCounArray] + '" value="' + datac.peopleInvestment[InveCounArray + 1] + '" ></li><li><label>Role</label><input disabled="disabled" type="text" class="common_input" id="IRole' + ICoun + '" value="' + datac.peopleInvestment[InveCounArray + 2] + '" /></li><li><label>Start Date</label><input disabled="disabled" type="text" class="common_input" id="IStart' + ICoun + '" value="' + datac.peopleInvestment[InveCounArray + 3] + '" /></li><li><label>End Date</label><input  disabled="disabled" type="text" class="common_input" id="IEnd' + ICoun + '" value="' + datac.peopleInvestment[InveCounArray + 4] + '" /><a href="#nogo" id="minus"  style="float:right;margin: 5px 0px 10px 20px;" class="delUlI' + ICoun + '" title="Inve" name="' + datac.peopleInvestment[InveCounArray] + '" ><img src="../img/button_minus.png" style="height:25px;width:25px;" tabindex="15"/></a></li></ul>');
				ICoun++;
				InveCounArray = InveCounArray + 5;
				Inve_count++;
				InveCounUpdate = InveCounUpdate + 5;
			}
			
		});
	}
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
		
		$('#Companies_part').before('<br><ul class="company_details" id="delUlC' + Comp_count + '"><li><label>Company' + Comp_count + '</label><input type="text" class="search" id="cName' + Comp_count + '" name="0" title="' + Comp_count + '"/></li><li><label>Role</label><input type="text" class="common_input" id="cRole' + Comp_count + '" /></li><li><label>Start Date</label><input type="text" class="common_input" id="cStart' + Comp_count + '"  /></li><li><label>End Date</label><input type="text" class="common_input" id="cEnd' + Comp_count + '" /><a href="#nogo" id="minus" class="delUlC' + Comp_count + '" style="float:right;margin: 5px 0px 10px 20px;"  title="comp" name="0"><img src="../img/button_minus.png" style="height:25px;width:25px;" tabindex="15"/></a></li></ul><div id="displayp' + Comp_count + '"></div><div class="clear"></div>');
		Comp_count++;
		$(".search").keyup(function () {
			var searchbox = $(this).val();
			ccv = $(this).attr('title');
			//alert(ccv);
			var dataString = '&searchword=' + searchbox;
			
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
		
		$('#Investment_part').before('<br><ul class="company_details" id="delUlI' + Inve_count + '"><li><label>Investment' + Inve_count + '</label><input type="text" class="searchF" id="IName' + Inve_count + '" name="0" title="' + Inve_count + '"/></li><li><label>Role</label><input type="text" class="common_input" id="IRole' + Inve_count + '" /></li><li><label>Start Date</label><input type="text" class="common_input" id="IStart' + Inve_count + '"  /></li><li><label>End Date</label><input type="text" class="common_input" id="IEnd' + Inve_count + '" /><a href="#nogo" id="minus" class="delUlI' + Inve_count + '" style="float:right;margin: 5px 0px 10px 20px;"  title="Inve" name="0"><img src="../img/button_minus.png" style="height:25px;width:25px;" tabindex="15"/></a></li><div id="displayF' + Inve_count + '"></div></ul><div class="clear"></div>');
		Inve_count++;
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
		$('#minus').live('click', function () {
		var addonDel = [];
		var trash_id = $(this).attr('class');
		var trash_name = $(this).attr('title');
		//$('#'+trash_id).fadeOut(500);
		var addon_id = $(this).attr('name');
		addonDel = '&trash_name=' + trash_name + '&addon_id=' + addon_id;
		//alert(addonDel);
		if (confirm("Sure you want to delete this? There is NO undo!")) {
			$.ajax({
				type : "post",
				url : "../lib/delete_addonPeople.php",
				data : addonDel,
				success : function (data) {
					$('#' + trash_id).fadeOut(500);
				}
			});
		}
	});
	//****************updating section******************//
	$('#updateperson').live('click', function () {
		update();
		
	});
	
	function update() {
		
		var profile_person_name = $("#profile_person_name").val();
		//alert(profile_person_name);
		var profile_person_blog_url = $("#profile_person_blog_url").val();
		var profile_person_twitter_username = $("#profile_person_twitter_username").val();
		var profile_person_linkedin_username = $("#profile_person_linkedin_username").val();
		var profile_person_des = $("#profile_person_des").val();
		var profile_person_email = $("#profile_person_email").val();
		var profile_person_image = $("#profile_person_image").val();
		var profile_person_active = $("#profile_person_active").val();
		var profile_people_id = $("#profile_people_id").val();
		var profilePersonOld = $("#profilePersonOld").val();
		if (profile_person_image == '') {
			
			var profile_person_image1 = $("#timg2").val();
			
		} else {
			var profile_person_image1 = $("#img22").attr('class');
		}
		if (profile_person_active == '1') {
			var profile_person_active1 = '1';
		} else {
			var profile_person_active1 = '0';
		}
		var compCounter = 0;
		var compCounterLoop = 1;
		//alert(Comp_count);
		while (compCounterLoop < Comp_count) {
			Comp[compCounter] = $('#cName' + compCounterLoop).attr('name');
			Comp[compCounter + 1] = $('#cName' + compCounterLoop).val();
			Comp[compCounter + 2] = $('#cRole' + compCounterLoop).val();
			Comp[compCounter + 3] = $('#cStart' + compCounterLoop).val();
			Comp[compCounter + 4] = $('#cEnd' + compCounterLoop).val();
			compCounter = compCounter + 5;
			compCounterLoop++;
		}
		
		var InveCounter = 0;
		var InveCounterLoop = 1;
		while (InveCounterLoop < Inve_count) {
			Inve[InveCounter] = $('#IName' + InveCounterLoop).attr('name');
			Inve[InveCounter + 1] = $('#IName' + InveCounterLoop).val();
			Inve[InveCounter + 2] = $('#IRole' + InveCounterLoop).val();
			Inve[InveCounter + 3] = $('#IStart' + InveCounterLoop).val();
			Inve[InveCounter + 4] = $('#IEnd' + InveCounterLoop).val();
			InveCounter = InveCounter + 5;
			InveCounterLoop++;
		}
		
		var stringifyCompaniesUp = JSON.stringify(Comp);
		var stringifyInvestmentUp = JSON.stringify(Inve);
		
		var updatedData = '&peopleId=' + peopleId + '&profile_person_name=' + profile_person_name + '&profile_person_blog_url=' + profile_person_blog_url + '&profile_person_twitter_username=' + profile_person_twitter_username + '&profile_person_linkedin_username=' + profile_person_linkedin_username + '&profile_person_image=' + profile_person_image1 + '&profile_person_des=' + profile_person_des + '&profile_person_email=' + profile_person_email + '&profile_person_active=' + profile_person_active1 + '&stringifyCompaniesUp=' + stringifyCompaniesUp + '&stringifyInvestmentUp=' + stringifyInvestmentUp+ '&profile_people_id=' + profile_people_id+ '&profilePersonOld=' + profilePersonOld;
		//alert(updatedData);
/* 		var atpos = profile_email.indexOf("@");
		var dotpos = profile_email.lastIndexOf("."); */
		 if (profile_person_name == '' || profile_person_email == '') {
			$('.error').fadeIn(400).delay(4000).fadeOut(400);
		} else {
			$.ajax({
				type : "post",
				url : "../lib/peopleInfoUpdate.php",
				data : updatedData,
				success : function (data) {
					if (data == 0) {
						$('#info').html('Person Already Exists.').fadeIn(400).delay(4000).fadeOut(400);
					} else {
						$('.success').fadeIn(400).delay(4000).fadeOut(400);
						
						//$("#img22").slideToggle(500);
					}
				}
			});
		} 
	}
	//****************End updating section******************//
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
	
});
</script>

</head>

<body>
<div id="wrapper">
	<?php include('../lib/left_bar.php');?>
	<div class="clear"></div>

	<div id="main_content">
		<!--<div id="sidebar">
		<a href="" id="updatecompany"></a>
		<!-- 			<a href="" id="addcompany"></a> --
		<span class="small">Last Updated: __ / __ / __</span>
		</div>-->

		<h2 class="form_title">Edit Person</h2>
		<div id="form_container">
			<div id="form_top"></div>
			<div id="id-form" class="order">
				<div class="form_midblue">
					<!-- // ========== DETAILS ============ // -->
					<ul class="company_details">
						<li>
							<label>Name:</label>
							<input id="profile_person_name" type="text" name="profile_person_name" class="text" tabindex="" value="" />
						</li>
						<!--<li>
							<label >Last Name:</label>
							<input id="profile_person_lname" type="text" name="profile_person_lname" class="text" tabindex="" value="" placeholder=""/>
						</li>-->
						<li>
							<label>Blog url:</label>
							<input  id="profile_person_blog_url" name="profile_person_blog_url" type="text" class="text" tabindex="" placeholder="" value=""/>
						</li>
						<li>
							<label>Twitter username:</label>
							<input id="profile_person_twitter_username" type="text" name="profile_person_twitter_username" class="text" tabindex="" value="" placeholder="" />
						</li>
						<li>
							<label>LinkedIn username:</label>
							<input id="profile_person_linkedin_username" type="text" name="profile_person_linkedin_username" class="text" tabindex="" value="" placeholder=""/>
						</li>
						<li>
							<label>Profile Image:</label>
							<form id="imageform2" method="post" enctype="multipart/form-data" action='ajaximagePeople.php'>
								<input type='hidden' id='timg2' value=""/>
								<input type="file" name="profile_person_image" id="profile_person_image" class="file_1" tabindex=""/>
								<div id="preview2" title='' style='border-top-left-radius:3px;border-bottom-right-radius:3px;border-top-right-radius:3px;border-bottom-left-radius:3px;height:100px;width:100px;border:solid 1px #ffffff;display:block;box-shadow: 0px 2px 6px ;-moz-box-shadow:0px 2px 6px;-webkit-box-shadow: 0px 2px 6px;font-size:10px; float: right; padding: 4px;margin: -40px 10px 10px 20px;' ></div><div class="clear"></div>
							</form>
						</li>
						<li>
							<label>Description:</label>
							<textarea id="profile_person_des" type="text" name="profile_person_des" class="textarea" tabindex="" placeholder="" rows="10"></textarea>
						</li>
						<li>
							<label>Email:</label>
							<input id="profile_person_email" type="text" name="profile_person_email" class="text" tabindex="" placeholder="" value=""/><span id="validEmail"></span>
						</li>

						<li>
							<label >Active?:</label>
							<select id="profile_person_active" name="profile_person_active" tabindex=""  class="" >
								<option value=""></option>
								<option value="1">Active</option>
								<option value="0">Not Active</option>
							</select>
						</li>
						<li>
							<input id="profile_people_id" type="hidden" name="profile_people_id" class="text" tabindex="" value="" />
						</li>
						<li>
							<input id="profilePersonOld" type="hidden" name="profilePersonOld" class="text" tabindex="" value="" />
						</li>
						<div class="clear"></div>
					</ul>
				</div>
				<div class="form_midyellow">
					<!-- // ========== Companies  ============ // -->
					<ul class="company_details">
						<li>
							<label>Companies:</label><img id='new_Companies' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
						</li>
						<div class="slide_toggle">
							<div id='Companies_part'></div>
						</div>
						<div style=" width:300px; float:right;left:180px;position:absolute; z-index:2;" align="right">
							<div id="displayp"></div>
						</div>
						<div class="clear"></div>
					</ul>
				</div>
				<div class="form_midyellow">
					<!-- // ========== Investment Organizations  ============ // -->
					<ul class="company_details">
						<li>
							<label>Investment Organizations:</label><img id='new_Investment' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
						</li>
						<div class="slide_toggle">
							<div id='Investment_part'></div>
						</div>
						<div style=" width:300px; float:right;left:180px;position:absolute; z-index:2;" align="right">
							<div id="displayp"></div>
						</div>
						<div class="clear"></div>
					</ul>
				</div>
				<div class="form_midblue">
					<!-- // ========== BUTTONS ============ // -->

					<a href="#_" id="updateperson" class="fright"></a>
					<div id='info' style=''></div>
					<span class="error" style="display:none">Please Enter Valid Data</span><span  class="success" style="display:none">Update Complete.</span>
					<span  class="echoerror" style=""></span>
					<div class="clear"></div>
				</div>
				<div id="form_btm"></div>
			</div>
		</div>
	</div>
</div>
<!-- close wrapper -->
</body>
</html>
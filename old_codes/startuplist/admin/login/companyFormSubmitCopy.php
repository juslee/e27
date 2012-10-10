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
<script type="text/javascript" src="../js/jquery.limit-1.2.source.js"></script>
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
$(document).ready(function () {
	var Subcompeti_count = 1;
	var Subpeople_count = 1;
	var Submiles_count = 1;
	var Subfund_count = 1;
	var Subcompetitors = [];
	var Subpeople = [];
	var Submiles = [];
	var Subfund = [];
	var fundtype = [];
	var ccv;
	var ccvv;
	var ccvvv;
	var ssss;
	var ssssp;
	var ssssi;
	var addfundtype_id;
	var feaCount=1;
	$(".display_box").live("click", function () {
		
		var thi = $(this).attr("id");
		//alert(thi);
		$('#competitor' + ccv).val(thi);
		$('#competitor' + ccv).keydown(function () {
			var competitor = $('#competitor' + ccv).val();
			if (competitor == '') {
				$("#display" + ccv).hide();
			}
		});
		
	});
	
	$('#new_competitors').live('click', function () {
		
		$('#competitors_part').before('<br><ul class="company_details" id="delUl' + Subcompeti_count + '"><li><label>Competitor' + Subcompeti_count + '</label><input type="text" class="search" id="competitor' + Subcompeti_count + '" class="CName" name="0" title="' + Subcompeti_count + '"/></li></ul><div class="disZ" id="display' + Subcompeti_count + '"></div><div class="clear"></div>');
		Subcompeti_count++;
		$(".search").keyup(function () {
			var searchbox = $(this).val();
			ccv = $(this).attr('title');
			//alert(ccv);
			var dataString = 'searchword=' + searchbox;
			
			if (searchbox == '') {}
			else {
				
				$.ajax({
					type : "POST",
					url : "search.php",
					data : dataString,
					cache : false,
					success : function (html) {
						//alert(html);
						$("#display" + ccv).html(html).show();
						$('#competitor' + ccv).keydown(function () {
							var competitor = $('#competitor' + ccv).val();
							if (competitor == '') {
								$("#display" + ccv).hide();
							}
						});
						$("#display" + ccv).live("mouseenter", function () {}).live("click", function () {
							$("#display" + ccv).hide();
						});
						
					}
				});
			}
			return false;
		});
	});
	$(".display_boxp").live("click", function () {
		var thip = $(this).attr("id");
		
		$("#pName" + ccvv).val(thip);
		$('#pName' + ccvv).keydown(function () {
			var pName = $('#pName' + ccvv).val();
			if (pName == '') {
				$("#displayp" + ccvv).hide();
			}
		});
	});
	$('#new_people').live('click', function () {
		
		$('#people_part').before('<br><ul class="company_details" id="delUl' + Subpeople_count + '"><li><label>People' + Subpeople_count + '</label><input type="text" class="searchp" id="pName' + Subpeople_count + '" name="0" title="' + Subpeople_count + '"/></li><li><label>Role</label><input type="text" class="common_input" id="pRole' + Subpeople_count + '" /></li><li><label>Start Date</label><input type="text" class="common_input" id="pStart' + Subpeople_count + '"  /></li><li><label>End Date</label><input type="text" class="common_input" id="pEnd' + Subpeople_count + '" /></li></ul><div class="disZ" id="displayp' + Subpeople_count + '"></div><div class="clear"></div>');
		Subpeople_count++;
		$(".searchp").keyup(function () {
			var searchbox = $(this).val();
			ccvv = $(this).attr('title');
			//alert(searchbox);
			var dataString = 'searchword=' + searchbox;
			
			if (searchbox == '') {}
			else {
				
				$.ajax({
					type : "POST",
					url : "search_person.php",
					data : dataString,
					cache : false,
					success : function (html) {
						//alert(html);
						$("#displayp" + ccvv).html(html).show();
						$('#pName' + ccvv).keydown(function () {
							var pName = $('#pName' + ccvv).val();
							if (pName == '') {
								$("#displayp" + ccvv).hide();
							}
						});
						$("#displayp" + ccvv).live("mouseenter", function () {}).live("click", function () {
							$("#displayp" + ccvv).hide();
						});
					}
				});
			}
			return false;
			
		});
	});
	
	$('#new_milestones').live('click', function () {
		$('#milestones_part').before('<br><ul class="company_details" id="delUl' + Submiles_count + '"><li><label>Milestone' + Submiles_count + '</label><input type="text" class="" id="miles' + Submiles_count + '" name="0" maxlength="90"/></li></ul><div class="clear"></div>');
		Submiles_count++;
		
	});
	
	$('#new_fund').live('click', function () {
		$('#funding_part').before('<br><ul class="company_details" id="delUl' + Subfund_count + '"><li><label>Funding Round' + Subfund_count + '</label><select type="text" class="common_input" id="round' + Subfund_count + '" name="0" ><option value=""></option><option value="Seed">Seed</option><option value="Angel">Angel</option><option value="Series A">Series A</option><option value="Series B">Series B</option><option value="Series C">Series C</option><option value="Series D">Series D</option><option value="Series E">Series E</option><option value="Series F">Series F</option><option value="Series G">Series G</option><option value="Series H">Series H</option><option value="Grant">Grant</option><option value="Debt Round">Debt Round</option><option value="Unattributed">Unattributed</option><option value="Post Ipo Equity">Post Ipo Equity</option><option value="Post Ipo Debt">Post Ipo Debt</option></select></li><li><label>Funding Sign</label><select type="text" class="common_input" id="asign' + Subfund_count + '"><option value="">(Select a Currency from the List)</option><option value=USD>dollar: United States</option><option value=THB>baht: Thai</option><option value=PAB>balboa: Panamanian</option><option value=TND>dinar: Tunisian</option><option value=MAD>dirham: Moroccan</option><option value=AUD>dollar: Australian</option><option value=BSD>dollar: Bahamian</option><option value=BBD>dollar: Barbadian</option><option value=BZD>dollar: Belizean</option><option value=BMD>dollar: Bermudian</option><option value=BND>dollar: Bruneian</option><option value=CAD>dollar: Canadian</option><option value=XCD>dollar: East Caribbean</option><option value=FJD>dollar: Fijian</option><option value=HKD>dollar: Hong Kong</option><option value=JMD>dollar: Jamaican</option><option value=NAD>dollar: Namibian</option><option value=NZD>dollar: New Zealand</option><option value=SGD>dollar: Singapore</option><option value=USD>dollar: United States</option><option value=VND>dong: Vietnamese</option><option value=PTE>escudo: Portuguese</option><option value=EUR>euro: European Union</option><option value=HUF>forint: Hungarian</option><option value=BEF>franc: Belgian</option><option value=DJF>franc: Djiboutian</option><option value=FRF>franc: French</option><option value=LUF>franc: Luxembourg</option><option value=CHF>franc: Swiss</option><option value=AWG>guilder: Aruban</option><option value=NLG>guilder: Netherlands</option><option value=ISK>krona: Icelandic</option><option value=SEK>krona: Swedish</option><option value=DKK>krone: Danish</option><option value=NOK>krone: Norwegian</option><option value=EEK>kroon: Estonian</option><option value=HRK>kuna: Croatian</option><option value=MMK>kyat: Burmese</option><option value=HNL>lempira: Honduran</option><option value=SZL>lilangeni: Swazi</option><option value=ITL>lira: Italian</option><option value=LTL>litas: Lithuanian</option><option value=LSL>loti: Lesotho</option><option value=DEM>mark: German</option><option value=FIM>markka: Finnish</option><option value=BAM>marks: Bos. and Herz.</option><option value=TWD>new dollar: Taiwanese</option><option value=TRY>new lira: Turkish</option><option value=ILS>new shekel: Israeli</option><option value=BTN>ngultrum: Bhutanese</option><option value=PEN>nuevo sol: Peruvian</option><option value=ADP>peseta: Andorran</option><option value=ESP>peseta: Spanish</option><option value=ARS>peso: Argentine</option><option value=CLP>peso: Chilean</option><option value=COP>peso: Colombian</option><option value=CUP>peso: Cuban</option><option value=MXN>peso: Mexican</option><option value=PHP>peso: Philippine</option><option value=GBP>pound sterling: British</option><option value=FKP>pound: Falkland</option><option value=GIP>pound: Gibraltar</option><option value=IEP>pound: Irish</option><option value=SHP>pound: Saint Helenian</option><option value=GTQ>quetzal: Guatemalan</option><option value=ZAR>rand: South African</option><option value=BRL>real: Brazilian</option><option value=OMR>rial: Omani</option><option value=MYR>ringgit: Malaysian</option><option value=INR>rupee: Indian</option><option value=PKR>rupee: Pakistani</option><option value=LKR>rupee: Sri Lankan</option><option value=IDR>rupiah: Indonesian</option><option value=ATS>schilling: Austrian</option><option value=KRW>won: South Korean</option><option value=JPY>yen: Japanese</option><option value=CNY>yuan renminbi: Chinese</option><option value=PLN>zloty: Polish</option></select></li><li><label>Funding Amount</label><input type="text" class="common_input" id="amount' + Subfund_count + '" /></li><li><label>Funding Date</label><input type="text" class="common_input" id="date' + Subfund_count + '" /></li><li><label>Funding Type</label><ul class="fundtype_con'+Subfund_count+'"><ul id="fundtypeUl'+Subfund_count+'"><a href="#_" id="addfundtype" name="'+Subfund_count+'" ><img src="../img/button_plus.png" style="height:25px;width:25px; margin:0px 0px 0px 20px"/></a></ul></ul><li id="fundtype_Cpanel"><a href="#_" id="del_fundtype" name="'+Subfund_count+'"></a></li></li><li><label style="display:none;">Funding Person</label><input type="text" style="display:none;" class="common_input" id="person' + Subfund_count + '" /></li></ul><div class="clear"></div>');
		Subfund_count++;
		$(".funding_type").live("change", function () {
			var id = $(this).val();
			//alert(id);
			$('.FundingTypeSearch').show();
			if (id == "Person") {
				$(".FundingTypeSearch").live("keyup", function () {
					var searchboxp = $(this).val();
					ssssp = $(this).attr('title');
					var dataStringp = 'searchwordp=' + searchboxp;
					//alert(dataStringp);
					if (searchboxp == '') {}
					else {
						$.ajax({
							type : "POST",
							url : "search_personFundingType.php",
							data : dataStringp,
							cache : false,
							success : function (htmlp) {
								//alert(html);
								$("#displayfunding" + ssss).empty();
								$("#displayfunding" + ssss).hide();
								$("#displayfunding" + ssssi).empty();
								$("#displayfunding" + ssssi).hide();
								$("#displayfunding" + ssssp).html(htmlp).show();
								$('#type' + ssssp).keydown(function () {
									var type = $('#type' + ssssp).val();
									if (type == '') {
										$("#displayfunding" + ssss).hide();
									}
								});
								$("#displayfunding" + ssssp).live("mouseenter", function () {}).live("click", function () {
									$("#displayfunding" + ssssp).hide();
								});
							}
						});
					}
				});
			} else if (id == "Company") {
				$(".FundingTypeSearch").live("keyup", function () {
					var searchboxc = $(this).val();
					ssss = $(this).attr('title');
					var dataStringc = 'searchword=' + searchboxc;
					if (searchboxc == '') {}
					else {
						$.ajax({
							type : "POST",
							url : "search.php",
							data : dataStringc,
							cache : false,
							success : function (htmlc) {
								//alert(html);
								$("#displayfunding" + ssssp).empty();
								$("#displayfunding" + ssssp).hide();
								$("#displayfunding" + ssssi).empty();
								$("#displayfunding" + ssssi).hide();
								$("#displayfunding" + ssss).html(htmlc).show();
								$('#type' + ssss).keydown(function () {
									var type = $('#type' + ssss).val();
									if (type == '') {
										$("#displayfunding" + ssss).hide();
									}
								});
								$("#displayfunding" + ssss).live("mouseenter", function () {}).live("click", function () {
									$("#displayfunding" + ssss).hide();
								});
							}
						});
					}
				});
			} else {
				$(".FundingTypeSearch").live("keyup", function () {
					var searchboxi = $(this).val();
					ssssi = $(this).attr('title');
					var dataStringi = 'searchword=' + searchboxi;
					if (searchboxi == '') {}
					else {
						$.ajax({
							type : "POST",
							url : "searchfundInvOrg.php",
							data : dataStringi,
							cache : false,
							success : function (html) {
								//alert(html);
								$("#displayfunding" + ssssp).empty();
								$("#displayfunding" + ssssp).hide();
								$("#displayfunding" + ssss).empty();
								$("#displayfunding" + ssss).hide();
								$("#displayfunding" + ssssi).html(html).show();
								$('#type' + ssssi).keydown(function () {
									var type = $('#type' + ssssi).val();
									if (type == '') {
										$("#displayfunding" + ssssi).hide();
									}
								});
								$("#displayfunding" + ssssi).live("mouseenter", function () {}).live("click", function () {
									$("#displayfunding" + ssssi).hide();
								});
							}
						});
					}
				});
			}
		});
		
	});
	$(".display_box").live("click", function () {
		
		var ss = $(this).attr("id");
		//alert(thi);
		$('#type' + ssss).val(ss);
		$('#type' + ssss).keydown(function () {
			var type = $('#type' + ssss).val();
			if (type == '') {
				$("#displayfunding" + ssss).hide();
			}
		});
		
	});
	$(".display_boxType").live("click", function () {
		var ssp = $(this).attr("id");
		
		$("#type" + ssssp).val(ssp);
		$('#type' + ssssp).keydown(function () {
			var type = $('#type' + ssssp).val();
			if (type == '') {
				$("#displayfunding" + ssssp).hide();
			}
		});
	});
	$(".display_boxpif").live("click", function () {
		
		var ssi = $(this).attr("id");
		//alert(thi);
		$('#type' + ssssi).val(ssi);
		$('#type' + ssssi).keydown(function () {
			var type = $('#type' + ssssi).val();
			if (type == '') {
				$("#displayfunding" + ssssi).hide();
			}
		});
		
	});
	
	$('#addfundtype').live('click',function(){
	if(addfundtype_id!=$(this).attr('name')){

	}
	
	addfundtype_id=$(this).attr('name');
	//alert(addfundtype_id);
	var fundtype_id=$(".fundtype"+addfundtype_id).size();
	alert(fundtype_id);
	
	$("#fundtypeUl"+addfundtype_id).before('<li id="fundtypeLi'+(fundtype_id+1)+'" name="0"><label>Funding Type' + (fundtype_id+1) + '</label><select type="text" class="common_input funding_type  fundtype'+addfundtype_id+'" " id="ctype' +(fundtype_id+1)+ '" title='+addfundtype_id+' fundtypeID="0"><option value="">Select</option><option value="Company">Company</option><option value="Person">Person</option><option value="Investment Org">Investment Org</option></select><input style="display:none;margin: -37px 0px 0px 375px;min-width: 0px;" type="text" class="FundingTypeSearch fundtypee'+(fundtype_id+1)+'" id="type' +(fundtype_id+1)+ '" name="' +addfundtype_id+'"/></li><div id="displayfunding' +(fundtype_id+1)+ '" class="disfund"></div>');
});
	//****************Start Submit section******************//
	$('#addcompany').live('click', function () {
		submit();
		
	});
	
	function submit() {
		
		var sa = 1;
		var a = 0;
		while (sa < Subpeople_count) {
			
			Subpeople[a] = $("#pName" + sa).val();
			Subpeople[a + 1] = $("#pRole" + sa).val();
			Subpeople[a + 2] = $("#pStart" + sa).val();
			Subpeople[a + 3] = $("#pEnd" + sa).val();
			sa++;
			a = a + 4;
		}
		
		var sb = 1;
		var b = 0;
		while (sb < Subcompeti_count) {
			
			Subcompetitors[b] = $("#competitor" + sb).val();
			sb++;
			b = b + 1;
		}
		var sc = 1;
		var c = 0;
		while (sc < Submiles_count) {
			
			Submiles[c] = $("#miles" + sc).val();
			Submiles[c + 1] = $("#found" + sc).val();
			
			//alert(del[a]);
			sc++;
			c = c + 2;
		}
		var sd = 1;
		var d = 0;
		while (sd < Subfund_count) {
			
			Subfund[d] = $("#round" + sd).val();
			Subfund[d + 1] = $("#asign" + sd).val();
			Subfund[d + 2] = $("#amount" + sd).val();
			Subfund[d + 3] = $("#date" + sd).val();
			Subfund[d + 4] = $("#type" + sd).val();
			Subfund[d + 5] = $("#ctype" + sd).val();
			//alert(del[a]);
			sd++;
			d = d + 6;
		}
	
		var fundtypeCounter=0;
		$(".funding_type").each(function() {
			
			fundtype[fundtypeCounter]=$(this).val();

		// $(".FundingTypeSearch").each(function() {

			// fundtype[fundtypeCounter+1]=$(this).val();

		// });
			fundtypeCounter=fundtypeCounter+2;

		});
	
	
		var stringifyPeopleSub = JSON.stringify(Subpeople);
		var stringifyCompetitorsSub = JSON.stringify(Subcompetitors);
		var stringifyMilesSub = JSON.stringify(Submiles);
		var stringifyFundSub = JSON.stringify(Subfund);
		var stringifyFundSubNew = JSON.stringify(fundtype);
		
		
		alert(stringifyFundSubNew);
		var profile_id = $("#profile_id").val();
		var profile_name = $("#profile_name").val();
		var profile_description = $("#profile_description").val();
		var profile_category = $("#profile_category").val();
		var profile_homepage_url = $("#profile_homepage_url").val();
		var profile_blog_url = $("#profile_blog_url").val();
		var profile_twitter_username = $("#profile_twitter_username").val();
		var profile_facebook_username = $("#profile_facebook_username").val();
		var profile_email = $("#profile_email").val();
		var profile_number_of_employees = $("#profile_number_of_employees").val();
		var profile_founded_month = $("#profile_founded_month").val();
		var profile_founded_day = $("#profile_founded_day").val();
		var profile_founded_year = $("#profile_founded_year").val();
		var profile_logo = $("#img22").attr('class');
		var profile_country = $("#profile_country").val();
		var profile_screenshots = $("#img23").attr('class');
		var profile_status = $("#profile_status").val();
		var profile_active = $("#profile_active").val();
		if (profile_active == 'on') {
			var profile_active1 = '1';
		} else {
			var profile_active1 = '0';
		}
		var profile_org = '1';
		
		var dataString = '&profile_name=' + profile_name + '&profile_description=' + profile_description + '&profile_category=' + profile_category + '&profile_homepage_url=' + profile_homepage_url + '&profile_blog_url=' + profile_blog_url + '&profile_twitter_username=' + profile_twitter_username + '&profile_facebook_username=' + profile_facebook_username + '&profile_email=' + profile_email + '&profile_number_of_employees=' + profile_number_of_employees + '&profile_founded_month=' + profile_founded_month + '&profile_founded_day=' + profile_founded_day + '& profile_founded_year=' + profile_founded_year + '&profile_logo=' + profile_logo + '&profile_country=' + profile_country + '&profile_screenshots=' + profile_screenshots + '&profile_status=' + profile_status + '&profile_active=' + profile_active1 + '&profile_org=' + profile_org + '&stringifyPeopleSub=' + stringifyPeopleSub + '&stringifyCompetitorsSub=' + stringifyCompetitorsSub + '&stringifyMilesSub=' + stringifyMilesSub + '&stringifyFundSub=' + stringifyFundSub +'&stringifyFundSubNew=' + stringifyFundSubNew;
		//alert(dataString);
		// var atpos=profile_email.indexOf("@");
		// var dotpos=profile_email.lastIndexOf(".");
		if (profile_name == '' || profile_country == '') {
			$('.error').fadeIn(400).delay(4000).fadeOut(400);
		} else {
			$.ajax({
				type : "POST",
				url : "../lib/companySubmit.php",
				data : dataString,
				data : dataString,
				success : function (data) {
					//alert(data);
					
					if (data == 0) {
						$('#info').html('Company Already Exists.').fadeIn(400).delay(4000).fadeOut(400);
					} else {
						$('.success').fadeIn(400).delay(4000).fadeOut(400);
						//alert(data);
						$("#profile_name").val('');
						$("#profile_description").val('');
						$("#profile_category").val('');
						$("#profile_homepage_url").val('');
						$("#profile_blog_url").val('');
						$("#profile_twitter_username").val('');
						$("#profile_facebook_username").val('');
						$("#profile_email").val('');
						$("#profile_number_of_employees").val('');
						$("#profile_founded_month").val('');
						$("#profile_founded_day").val('');
						$("#profile_founded_year").val('');
						$("#profile_logo").val('');
						$("#profile_country").val('');
						$("#profile_screenshots").val('');
						$("#profile_status").val('');
						$("#profile_active").val('');
						$("#validEmail").fadeOut(500);
						$(".sign_toggle").fadeOut(500);
						$("#img22").fadeOut(500);
						$("#img23").fadeOut(500);
						$("#timg").slideToggle(500);
						$("#timg1").slideToggle(500);
					}
					
				}
			});
		}
		return false;
		
	}
	$('#profile_logo').live('change', function () {
		$("#preview").html('');
		$("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
		$('#imageform').ajaxForm({
			target : '#preview'
		}).submit();
	});
	
	$('#profile_screenshots').live('change', function () {
		$("#preview1").html('');
		$("#preview1").html('<img src="loader.gif" alt="Uploading...."/>');
		$("#imageform1").ajaxForm({
			target : '#preview1'
		}).submit();
	});
	$("#profile_email").keyup(function () {
		
		var email = $("#profile_email").val();
		
		if (email != 0) {
			if (isValidEmailAddress(email)) {
				$("#validEmail").css({
					"background-image" : "url('../img/validYes.png')"
				});
			} else {
				$("#validEmail").css({
					"background-image" : "url('../img/validNo.png')"
				});
			}
		} else {
			$("#validEmail").css({
				"background-image" : "none"
			});
		}
		
	});
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
	//****************End Submit section******************//
	//****************Href Name Autofill******************//
	$.urlParam = function (comprofile_name) {
		var results = new RegExp('[\\?&]' + comprofile_name + '=([^&#]*)').exec(window.location.href);
		return results[1] || 0;
	}
	//alert('comprofile_name');
	
	var comprofile_name = $.urlParam('comprofile_name');
	if (comprofile_name != '') {
		$('#profile_name').val('' + comprofile_name);
	}
	
});
</script>

</head>

<body>
	<div id="wrapper">
		<?php include('../lib/left_bar.php');?>
		<div class="clear"></div>

		<div id="main_content">
			<div id="sidebar" style="display:none">
				<span class="small"></span>
			</div>

			<h2 class="form_title">Add Company</h2>
			<div id="form_container">
				<div id="form_top"></div>
				<div id="id-form" class="order">
					<div class="form_midblue">
						<!-- // ========== DETAILS ============ // -->
						<ul class="company_details">
							<li>
								<label>Name:</label>
								<input id="profile_name" type="text" name="profile_name" class="searchProName" value=""/>
								<div id="displayName"></div>
							</li>
							<li>
								<label>Description:</label><textarea id="profile_description" type="text" name="profile_description" class="text" value="" rows="10"></textarea>
							</li>							
							<li>
								<label>Category:</label>
								<select id="profile_category" name="profile_category" tabindex="" class="text">
									<option value=""></option>
									<option value="Advertising">Advertising</option>
									<option value="BioTech">BioTech</option>
									<option value="CleanTech">CleanTech</option>
									<option value="Consumer Electronics/Devices">Consumer Electronics/Devices</option>
									<option value="Consumer Web">Consumer Web</option>
									<option value="eCommerce">eCommerce</option>
									<option value="Education">Education</option>
									<option value="Enterprise">Enterprise</option>
									<option value="Games, Video and Entertainment">Games, Video and Entertainment</option>
									<option value="Legal">Legal</option>
									<option value="Mobile/Wireless">Mobile/Wireless</option>
									<option value="Network/Hosting">Network/Hosting</option>
									<option value="Consulting">Consulting</option>
									<option value="Communications">Communications</option>
									<option value="Search">Search</option>
									<option value="Security">Security</option>
									<option value="Semiconductor">Semiconductor</option>
									<option value="Software">Software</option>
									<option value="Other">Other</option>
								</select>
							</li>
							<li>
								<label>Website:</label>
								<input id="profile_homepage_url" type="text" name="profile_homepage_url" class="text" value=""/>
							</li>
							<li>
								<label>Blog URL:</label>
								<input id="profile_blog_url" type="text" name="profile_blog_url" class="text" value=""/>
							</li>
							<li>
								<label>Twitter Username:</label>
								<input id="profile_twitter_username" type="text" name="profile_twitter_username" class="text" value=""/>
							</li>
							<li>
								<label>Facebook Username:</label>
								<input id="profile_facebook_username" type="text" name="profile_facebook_username" class="text" value=""/>
							</li>
							<li>
								<label>Email:</label>
								<input id="profile_email" type="text" name="profile_email" class="text" value=""/><span id="validEmail"></span>
							</li>
							<li>
								<label>No. of Employees:</label>
								<input id="profile_number_of_employees" type="text" name="profile_number_of_employees" class="text" value=""/>
							</li>
							<li>
								<label>Founding Date:</label>
								<select id="profile_founded_month" name="profile_founded_month" tabindex=""  class="text" >
									<option value="" selected="selected"></option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
								<select id="profile_founded_day" name="profile_founded_day" tabindex=""  class="">
									<option selected="selected" value="" ></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
								<select id="profile_founded_year" name="profile_founded_year" tabindex=""  class="">
									<option selected="selected" value="" ></option>
									<option value="2013">2013</option>
									<option value="2012" selected="selected">2012</option>
									<option value="2011">2011</option>
									<option value="2010">2010</option>
									<option value="2009">2009</option>
									<option value="2008">2008</option>
									<option value="2007">2007</option>
									<option value="2006">2006</option>
									<option value="2005">2005</option>
									<option value="2004">2004</option>
									<option value="2003">2003</option>
									<option value="2002">2002</option>
									<option value="2001">2001</option>
									<option value="2000">2000</option>
									<option value="1999">1999</option>
								</select>
							</li>

							<li>
								<label>Country:</label>
								<select id="profile_country" type="text" name="profile_country" tabindex=""  class="text" >
									<option value="">Select Country</option>
									<option value="United States">United States</option>
									<option value="United Kingdom">United Kingdom</option>
									<option value="Afghanistan">Afghanistan</option>
									<option value="Albania">Albania</option>
									<option value="Algeria">Algeria</option>
									<option value="American Samoa">American Samoa</option>
									<option value="Andorra">Andorra</option>
									<option value="Angola">Angola</option>
									<option value="Anguilla">Anguilla</option>
									<option value="Antarctica">Antarctica</option>
									<option value="Antigua and Barbuda">Antigua and Barbuda</option>
									<option value="Argentina">Argentina</option>
									<option value="Armenia">Armenia</option>
									<option value="Aruba">Aruba</option>
									<option value="Australia">Australia</option>
									<option value="Austria">Austria</option>
									<option value="Azerbaijan">Azerbaijan</option>
									<option value="Bahamas">Bahamas</option>
									<option value="Bahrain">Bahrain</option>
									<option value="Bangladesh">Bangladesh</option>
									<option value="Barbados">Barbados</option>
									<option value="Belarus">Belarus</option>
									<option value="Belgium">Belgium</option>
									<option value="Belize">Belize</option>
									<option value="Benin">Benin</option>
									<option value="Bermuda">Bermuda</option>
									<option value="Bhutan">Bhutan</option>
									<option value="Bolivia">Bolivia</option>
									<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
									<option value="Botswana">Botswana</option>
									<option value="Bouvet Island">Bouvet Island</option>
									<option value="Brazil">Brazil</option>
									<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
									<option value="Brunei Darussalam">Brunei Darussalam</option>
									<option value="Bulgaria">Bulgaria</option>
									<option value="Burkina Faso">Burkina Faso</option>
									<option value="Burundi">Burundi</option>
									<option value="Cambodia">Cambodia</option>
									<option value="Cameroon">Cameroon</option>
									<option value="Canada">Canada</option>
									<option value="Cape Verde">Cape Verde</option>
									<option value="Cayman Islands">Cayman Islands</option>
									<option value="Central African Republic">Central African Republic</option>
									<option value="Chad">Chad</option>
									<option value="Chile">Chile</option>
									<option value="China">China</option>
									<option value="Christmas Island">Christmas Island</option>
									<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
									<option value="Colombia">Colombia</option>
									<option value="Comoros">Comoros</option>
									<option value="Congo">Congo</option>
									<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
									<option value="Cook Islands">Cook Islands</option>
									<option value="Costa Rica">Costa Rica</option>
									<option value="Cote D'ivoire">Cote D'ivoire</option>
									<option value="Croatia">Croatia</option>
									<option value="Cuba">Cuba</option>
									<option value="Cyprus">Cyprus</option>
									<option value="Czech Republic">Czech Republic</option>
									<option value="Denmark">Denmark</option>
									<option value="Djibouti">Djibouti</option>
									<option value="Dominica">Dominica</option>
									<option value="Dominican Republic">Dominican Republic</option>
									<option value="Ecuador">Ecuador</option>
									<option value="Egypt">Egypt</option>
									<option value="El Salvador">El Salvador</option>
									<option value="Equatorial Guinea">Equatorial Guinea</option>
									<option value="Eritrea">Eritrea</option>
									<option value="Estonia">Estonia</option>
									<option value="Ethiopia">Ethiopia</option>
									<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
									<option value="Faroe Islands">Faroe Islands</option>
									<option value="Fiji">Fiji</option>
									<option value="Finland">Finland</option>
									<option value="France">France</option>
									<option value="French Guiana">French Guiana</option>
									<option value="French Polynesia">French Polynesia</option>
									<option value="French Southern Territories">French Southern Territories</option>
									<option value="Gabon">Gabon</option>
									<option value="Gambia">Gambia</option>
									<option value="Georgia">Georgia</option>
									<option value="Germany">Germany</option>
									<option value="Ghana">Ghana</option>
									<option value="Gibraltar">Gibraltar</option>
									<option value="Greece">Greece</option>
									<option value="Greenland">Greenland</option>
									<option value="Grenada">Grenada</option>
									<option value="Guadeloupe">Guadeloupe</option>
									<option value="Guam">Guam</option>
									<option value="Guatemala">Guatemala</option>
									<option value="Guinea">Guinea</option>
									<option value="Guinea-bissau">Guinea-bissau</option>
									<option value="Guyana">Guyana</option>
									<option value="Haiti">Haiti</option>
									<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
									<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
									<option value="Honduras">Honduras</option>
									<option value="Hong Kong">Hong Kong</option>
									<option value="Hungary">Hungary</option>
									<option value="Iceland">Iceland</option>
									<option value="India">India</option>
									<option value="Indonesia">Indonesia</option>
									<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
									<option value="Iraq">Iraq</option>
									<option value="Ireland">Ireland</option>
									<option value="Israel">Israel</option>
									<option value="Italy">Italy</option>
									<option value="Jamaica">Jamaica</option>
									<option value="Japan">Japan</option>
									<option value="Jordan">Jordan</option>
									<option value="Kazakhstan">Kazakhstan</option>
									<option value="Kenya">Kenya</option>
									<option value="Kiribati">Kiribati</option>
									<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
									<option value="Korea, Republic of">Korea, Republic of</option>
									<option value="Kuwait">Kuwait</option>
									<option value="Kyrgyzstan">Kyrgyzstan</option>
									<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
									<option value="Latvia">Latvia</option>
									<option value="Lebanon">Lebanon</option>
									<option value="Lesotho">Lesotho</option>
									<option value="Liberia">Liberia</option>
									<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
									<option value="Liechtenstein">Liechtenstein</option>
									<option value="Lithuania">Lithuania</option>
									<option value="Luxembourg">Luxembourg</option>
									<option value="Macao">Macao</option>
									<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
									<option value="Madagascar">Madagascar</option>
									<option value="Malawi">Malawi</option>
									<option value="Malaysia">Malaysia</option>
									<option value="Maldives">Maldives</option>
									<option value="Mali">Mali</option>
									<option value="Malta">Malta</option>
									<option value="Marshall Islands">Marshall Islands</option>
									<option value="Martinique">Martinique</option>
									<option value="Mauritania">Mauritania</option>
									<option value="Mauritius">Mauritius</option>
									<option value="Mayotte">Mayotte</option>
									<option value="Mexico">Mexico</option>
									<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
									<option value="Moldova, Republic of">Moldova, Republic of</option>
									<option value="Monaco">Monaco</option>
									<option value="Mongolia">Mongolia</option>
									<option value="Montserrat">Montserrat</option>
									<option value="Morocco">Morocco</option>
									<option value="Mozambique">Mozambique</option>
									<option value="Myanmar">Myanmar</option>
									<option value="Namibia">Namibia</option>
									<option value="Nauru">Nauru</option>
									<option value="Nepal">Nepal</option>
									<option value="Netherlands">Netherlands</option>
									<option value="Netherlands Antilles">Netherlands Antilles</option>
									<option value="New Caledonia">New Caledonia</option>
									<option value="New Zealand">New Zealand</option>
									<option value="Nicaragua">Nicaragua</option>
									<option value="Niger">Niger</option>
									<option value="Nigeria">Nigeria</option>
									<option value="Niue">Niue</option>
									<option value="Norfolk Island">Norfolk Island</option>
									<option value="Northern Mariana Islands">Northern Mariana Islands</option>
									<option value="Norway">Norway</option>
									<option value="Oman">Oman</option>
									<option value="Pakistan">Pakistan</option>
									<option value="Palau">Palau</option>
									<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
									<option value="Panama">Panama</option>
									<option value="Papua New Guinea">Papua New Guinea</option>
									<option value="Paraguay">Paraguay</option>
									<option value="Peru">Peru</option>
									<option value="Philippines">Philippines</option>
									<option value="Pitcairn">Pitcairn</option>
									<option value="Poland">Poland</option>
									<option value="Portugal">Portugal</option>
									<option value="Puerto Rico">Puerto Rico</option>
									<option value="Qatar">Qatar</option>
									<option value="Reunion">Reunion</option>
									<option value="Romania">Romania</option>
									<option value="Russian Federation">Russian Federation</option>
									<option value="Rwanda">Rwanda</option>
									<option value="Saint Helena">Saint Helena</option>
									<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
									<option value="Saint Lucia">Saint Lucia</option>
									<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
									<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
									<option value="Samoa">Samoa</option>
									<option value="San Marino">San Marino</option>
									<option value="Sao Tome and Principe">Sao Tome and Principe</option>
									<option value="Saudi Arabia">Saudi Arabia</option>
									<option value="Senegal">Senegal</option>
									<option value="Serbia and Montenegro">Serbia and Montenegro</option>
									<option value="Seychelles">Seychelles</option>
									<option value="Sierra Leone">Sierra Leone</option>
									<option value="Singapore">Singapore</option>
									<option value="Slovakia">Slovakia</option>
									<option value="Slovenia">Slovenia</option>
									<option value="Solomon Islands">Solomon Islands</option>
									<option value="Somalia">Somalia</option>
									<option value="South Africa">South Africa</option>
									<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
									<option value="Spain">Spain</option>
									<option value="Sri Lanka">Sri Lanka</option>
									<option value="Sudan">Sudan</option>
									<option value="Suriname">Suriname</option>
									<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
									<option value="Swaziland">Swaziland</option>
									<option value="Sweden">Sweden</option>
									<option value="Switzerland">Switzerland</option>
									<option value="Syrian Arab Republic">Syrian Arab Republic</option>
									<option value="Taiwan, Province of China">Taiwan, Province of China</option>
									<option value="Tajikistan">Tajikistan</option>
									<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
									<option value="Thailand">Thailand</option>
									<option value="Timor-leste">Timor-leste</option>
									<option value="Togo">Togo</option>
									<option value="Tokelau">Tokelau</option>
									<option value="Tonga">Tonga</option>
									<option value="Trinidad and Tobago">Trinidad and Tobago</option>
									<option value="Tunisia">Tunisia</option>
									<option value="Turkey">Turkey</option>
									<option value="Turkmenistan">Turkmenistan</option>
									<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
									<option value="Tuvalu">Tuvalu</option>
									<option value="Uganda">Uganda</option>
									<option value="Ukraine">Ukraine</option>
									<option value="United Arab Emirates">United Arab Emirates</option>
									<option value="United Kingdom">United Kingdom</option>
									<option value="United States">United States</option>
									<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
									<option value="Uruguay">Uruguay</option>
									<option value="Uzbekistan">Uzbekistan</option>
									<option value="Vanuatu">Vanuatu</option>
									<option value="Venezuela">Venezuela</option>
									<option value="Viet Nam">Viet Nam</option>
									<option value="Virgin Islands, British">Virgin Islands, British</option>
									<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
									<option value="Wallis and Futuna">Wallis and Futuna</option>
									<option value="Western Sahara">Western Sahara</option>
									<option value="Yemen">Yemen</option>
									<option value="Zambia">Zambia</option>
									<option value="Zimbabwe">Zimbabwe</option>
								</select>
							</li>

							<li>
								<label >Logo:</label>
								<form id="imageform" method="post" enctype="multipart/form-data" action="ajaximageLogo.php" >
									<input id="timg" type='hidden'  value="" />
									<input type="file" name="profile_logo" id="profile_logo" class="text" tabindex=""/>
									<div id="preview" style='' ></div>
								</form>
							</li><div class="clear"></div>
							<li>
								<label >Screenshots:</label>
								<form id="imageform1" method="post" enctype="multipart/form-data" action='ajaximageScreen.php'>
									<input id="timg1" type='hidden'  value="" />
									<input type="file" name="profile_screenshots" id="profile_screenshots" class="text" tabindex=""/>
									<div id="preview1" style='' ></div>
								</form>
							</li><div class="clear"></div>
							<li>
								<label >Status:</label>
								<select id="profile_status" name="profile_status" tabindex=""  class="" >
									<option value=""></option>
									<option value="Live">Live</option>
									<option value="Close">Close</option>
								</select>
							</li><div class="clear"></div>
							<li>
								<label >Active?:</label>
								<select id="profile_active" name="profile_active" tabindex=""  class="" >
									<option value=""></option>
									<option value="on">Active</option>
									<option value="off">Not Active</option>
								</select>
							</li>

							<div class="clear"></div>
						</ul>
					</div>
					<div class="form_midyellow">
						<!-- // ========== PEOPLE  ============ // -->
						<ul class="company_details">
							<li>
								<label >People:</label><img id='new_people' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
							</li>
							<div class="sign_toggle">
								<div id='people_part'></div>
							</div><div class="toogle_sign" style="" align="right"></div>
							<div class="clear"></div>
						</ul>
					</div>
					<div class="form_midblue">
						<!-- // ========== COMPETITOR ========= // -->
						<ul class="company_details">
							<li>
								<label>Competitor Name:</label><img id='new_competitors' src="../img/button_plus.png" style='height:25px;width:25px;' tabindex=""/>
							</li>
							<div class="sign_toggle">
								<div id='competitors_part'></div>
							</div><div class="toogle_sign" style="" align="right"></div>
							<div class="clear"></div>
						</ul>
					</div>
					<div class="form_midyellow">
						<!-- // ========== FUNDING ============ // -->
						<ul class="company_details">
							<li>
								<label>Funding Details:</label><img id='new_fund' src="../img/button_plus.png" style='height:25px;width:25px;'/>
							</li>
							<div class="sign_toggle">
								<div id='funding_part'></div>
							</div>
							<div class="clear"></div>
						</ul>
					</div>
					<div class="form_midblue">
						<!-- // ========== MILESTONES ========= // -->
						<ul class="company_details">
							<li>
								<label>History Name:</label><img id='new_milestones' src="../img/button_plus.png" style='height:25px;width:25px'/>
							</li>
							<div class="sign_toggle">
								<div id='milestones_part'></div>
							</div>
							<div class="clear"></div>
						</ul>
					</div>
					<div class="form_midblue">
						<!-- // ========== BUTTONS ============ // -->

						<a href="#_" id="addcompany" class="fright"></a>
						<div id='info' style=''></div>
						<span class="error" style="display:none">Please Enter Valid Data</span><span  class="success" style="display:none">Company Successfully Created.</span>
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

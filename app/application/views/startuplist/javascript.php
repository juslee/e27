<?php
//header("Content-type: text/css", true);
?>
/********************************** number formating *****************************/
	
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function fNum(num){
	num = uNum(num);
	num = num.toFixed(2);
	return addCommas(num);
}
function uNum(num){
	if(!num){
		num = 0;
	}
	else if(isNaN(num)){
		num = num.replace(/[^0-9\.]/g, "");
		if(isNaN(num)){
			num = 0;
		}
	}
	return num*1;
}

function rawurlencode (str) {
  str = (str + '').toString();
  return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
  replace(/\)/g, '%29').replace(/\*/g, '%2A');
}



function searchForIt(){
	q = jQuery("#q").val();
	q = jQuery.trim(q);
	self.location = "<?php echo site_url(); ?>search/all/?q="+rawurlencode(q);
}

jQuery(function(){
	jQuery(".datepicker").datepicker({ 
	dateFormat: "mm/dd/yy",
	changeMonth: true, changeYear: true, yearRange: '1910:<?php echo date("Y"); ?>',
	onSelect: function(date) {
			/*
			thedate = new Date(date);
			thedate.setDate(thedate.getDate());
			jQuery(this).val(dateFormat(thedate, "mmm dd, yyyy"));
			id = jQuery(this).attr("alt");
			jQuery("#"+id).val(date);
			return false;
			*/
		},
	});
	
	jQuery( "#dialog" ).dialog({ autoOpen: false, closeOnEscape: true, title: "",
		open: function(){
			setTimeout(function(){
				jQuery(".ui-dialog").fadeOut(200, function(){
					jQuery("#dialog").dialog("close");
				});
			}, 2000);
		}
	});

});

jQuery(function(){
	jQuery('#q').keypress(function(event){
		if ( event.which == 13 ) {
			searchForIt();
		}

	});
	jQuery('#screenshots').slides({
		preload: true,
		preloadImage: '<?php echo site_url(); ?>media/ajax-loader.gif',
		play: 3000,
		pause: 2500,
		hoverPause: true,
		autoHeight: true,
		animationStart: function(){
			jQuery(".productgal_contents").show();
			jQuery(".productgal_loader").hide();
		}
	});
	sbcposition = jQuery(".sidebarblockcontainer").position();
	sbcheight = jQuery(".sidebarblockcontainer").height();
	
	jQuery(window).resize(function () {
		return false;
		pos = jQuery(".sidebarblockcontainer").position();
		wh = uNum(jQuery(window).height());
		sh = uNum(jQuery(window).scrollTop())+uNum(jQuery(window).height()); //scroll plus window height
		ht = uNum(sbcheight )+uNum(sbcposition.top);
		st = uNum(jQuery(window).scrollTop());
		sl = uNum(jQuery(window).scrollLeft());

		jQuery(".sidebarblockcontainer").each(function(){
			if(jQuery(this).css("position")=="fixed"){
				//set to static
				jQuery(this).css("position", "static");
				//get position
				sbcposition = jQuery(".sidebarblockcontainer").position();
				//set back to fixed
				jQuery(this).css("position", "fixed");
			}
			jQuery(this).css("left", sbcposition.left-sl);
		});
		if(sbcheight>wh){
			if(sh-50>=ht){
				jQuery(".sidebarblockcontainer").each(function(){
					//pos = jQuery(this).position();
					//console.log("sbc top = ", sbcposition .top);
					//return false;
					if(jQuery(this).css("position")=="static"){
						jQuery(this).css("position", "fixed");
						//jQuery(this).css("top", (sbcheight-wh-sbcposition.top)-st));
						jQuery(this).css("top", (Math.abs(sbcheight-wh)*-1)-20); //-20 is some space at the bottom
						//jQuery(this).css("left", pos.left);
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		else{
			
			if(jQuery(window).scrollTop()+15>sbcposition.top){
				jQuery(".sidebarblockcontainer").each(function(){
					if(jQuery(this).css("position")=="static"){
						position = jQuery(this).position();
						if(jQuery(this).css("position")=="static"){
							jQuery(this).css("top", 0);
							jQuery(this).css("position", "fixed");
							
						}
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
	
	});
	jQuery(window).scroll(function () { 
		return false;
		pos = jQuery(".sidebarblockcontainer").position();
		wh = uNum(jQuery(window).height());
		sh = uNum(jQuery(window).scrollTop())+uNum(jQuery(window).height()); //scroll plus window height
		ht = uNum(sbcheight )+uNum(sbcposition.top);
		st = uNum(jQuery(window).scrollTop());
		sl = uNum(jQuery(window).scrollLeft());

		jQuery(".sidebarblockcontainer").each(function(){
			if(jQuery(this).css("position")=="fixed"){
				//set to static
				jQuery(this).css("position", "static");
				//get position
				sbcposition = jQuery(".sidebarblockcontainer").position();
				//set back to fixed
				jQuery(this).css("position", "fixed");
			}
			jQuery(this).css("left", sbcposition.left-sl);
		});
		if(sbcheight>wh){
			if(sh-50>=ht){
				jQuery(".sidebarblockcontainer").each(function(){
					//pos = jQuery(this).position();
					//console.log("sbc top = ", sbcposition .top);
					//return false;
					if(jQuery(this).css("position")=="static"){
						jQuery(this).css("position", "fixed");
						//jQuery(this).css("top", (sbcheight-wh-sbcposition.top)-st));
						jQuery(this).css("top", (Math.abs(sbcheight-wh)*-1)-20); //-20 is some space at the bottom
						//jQuery(this).css("left", pos.left);
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		else{
			
			if(jQuery(window).scrollTop()+15>sbcposition.top){
				jQuery(".sidebarblockcontainer").each(function(){
					if(jQuery(this).css("position")=="static"){
						position = jQuery(this).position();
						if(jQuery(this).css("position")=="static"){
							jQuery(this).css("top", 0);
							jQuery(this).css("position", "fixed");
							
						}
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		
	});

});


function alertX(data){
		//jAlert(data);
		jQuery("#dialoghtml").html(data);
		jQuery("#dialog").dialog("open"); 
	
	
}

function confirmX(data){
	return jConfirm(data);
}

/****************** JS Date ***************************/
var dateFormat = function () {
var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
	timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
	timezoneClip = /[^-+\dA-Z]/g,
	pad = function (val, len) {
		val = String(val);
		len = len || 2;
		while (val.length < len) val = "0" + val;
		return val;
	};

// Regexes and supporting functions are cached through closure
return function (date, mask, utc) {
	var dF = dateFormat;

	// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
	if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
		mask = date;
		date = undefined;
	}

	// Passing date through Date applies Date.parse, if necessary
	date = date ? new Date(date) : new Date;
	if (isNaN(date)) throw SyntaxError("invalid date");

	mask = String(dF.masks[mask] || mask || dF.masks["default"]);

	// Allow setting the utc argument via the mask
	if (mask.slice(0, 4) == "UTC:") {
		mask = mask.slice(4);
		utc = true;
	}

	var	_ = utc ? "getUTC" : "get",
		d = date[_ + "Date"](),
		D = date[_ + "Day"](),
		m = date[_ + "Month"](),
		y = date[_ + "FullYear"](),
		H = date[_ + "Hours"](),
		M = date[_ + "Minutes"](),
		s = date[_ + "Seconds"](),
		L = date[_ + "Milliseconds"](),
		o = utc ? 0 : date.getTimezoneOffset(),
		flags = {
			d:    d,
			dd:   pad(d),
			ddd:  dF.i18n.dayNames[D],
			dddd: dF.i18n.dayNames[D + 7],
			m:    m + 1,
			mm:   pad(m + 1),
			mmm:  dF.i18n.monthNames[m],
			mmmm: dF.i18n.monthNames[m + 12],
			yy:   String(y).slice(2),
			yyyy: y,
			h:    H % 12 || 12,
			hh:   pad(H % 12 || 12),
			H:    H,
			HH:   pad(H),
			M:    M,
			MM:   pad(M),
			s:    s,
			ss:   pad(s),
			l:    pad(L, 3),
			L:    pad(L > 99 ? Math.round(L / 10) : L),
			t:    H < 12 ? "a"  : "p",
			tt:   H < 12 ? "am" : "pm",
			T:    H < 12 ? "A"  : "P",
			TT:   H < 12 ? "AM" : "PM",
			Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
			o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
			S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
		};

	return mask.replace(token, function ($0) {
		return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
	});
};
}();


/********************************** number formating *****************************/

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function fNum(num){
	num = uNum(num);
	num = num.toFixed(2);
	return addCommas(num);
}
function uNum(num){
	if(!num){
		num = 0;
	}
	else if(isNaN(num)){
		num = num.replace(/[^0-9\.]/g, "");
		if(isNaN(num)){
			num = 0;
		}
	}
	return num*1;
}

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};

function addDays(date, daystoadd){
	if(daystoadd==""){
		daystoadd = 0;
	}
	daystoadd = Math.ceil(daystoadd);

	if(date){
		date = date.split(",");
		date = date[0].split("/");
		date = date[1]+"/"+date[0]+"/"+date[2];

		try{
			thedate = new Date(date);
			thedate.setDate(thedate.getDate()+daystoadd);
			return dateFormat(thedate, "dd/mm/yyyy, dddd");
		}
		catch(e){
		}
		
	}
}


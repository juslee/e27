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
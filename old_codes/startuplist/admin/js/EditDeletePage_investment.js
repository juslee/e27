// 9lessons programming blog
// Srinivas Tamada http://9lessons.info
$(document).ready(function()
{
$(".delete_profile_investment").live('click',function()
{
var profile_id = $(this).attr('id');
var b=$(this).parent().parent();
var dataString = 'profile_id='+profile_id;
if(confirm("Sure you want to delete this update? There is NO undo!"))
{
	$.ajax({
type: "POST",
url: "../lib/delete_ajax2.php",
data: dataString,
cache: false,
success: function(e)
{
b.hide();
e.stopImmediatePropagation();
}
		   });
	return false;
}
});
			
/* 
$(".edit_tr").live('click',function()
{
var ID=$(this).attr('id');

$("#one_"+ID).hide();
$("#two_"+ID).hide();
$("#three_"+ID).hide();

$("#one_input_"+ID).show();
$("#two_input_"+ID).show();
$("#three_input_"+ID).show();



}).live('change',function(e)
{
var ID=$(this).attr('id');

var one_val=$("#one_input_"+ID).val();
var two_val=$("#two_input_"+ID).val();
var three_val=$("#three_input_"+ID).val();


var dataString = 'id='+ID+'&profile_name='+one_val+'&profile_email='+two_val+'&profile_active='+three_val;
if(one_val.length>0)
{

$.ajax({
type: "POST",
url: "../lib/live_edit_ajax.php",
data: dataString,
cache: false,
success: function(e)
{

$("#one_"+ID).html(one_val);
$("#two_"+ID).html(two_val);
$("#three_"+ID).html(three_val);

e.stopImmediatePropagation();

}
});
}
else
{
alert('Enter something.');
}

}); */

// Edit input box click action
$(".editbox").live("mouseup",function(e)
{
e.stopImmediatePropagation();
});

// Outside click action
$(document).mouseup(function()
{

$(".editbox").hide();
$(".text").show();
});
			
			
//Pagination			
function loading_show(){
$('#loading').html("<img src='../img/loading.gif'/>").fadeIn('fast');
}
function loading_hide(){
$('#loading').fadeOut('fast');
}                
function loadData(page){
loading_show();                    
$.ajax
({
type: "POST",
url: "../lib/load_data_investment.php",
data: "page="+page,
success: function(msg)
{
$("#container_investment").ajaxComplete(function(event, request, settings)
{
loading_hide();
$("#container_investment").html(msg);
});
}
});
}
loadData(1);  // For first time page load default results
$('#container_investment .pagination li.active').live('click',function(){
var page = $(this).attr('p');
loadData(page);
});           
$('#go_btn').live('click',function(){
var page = parseInt($('.goto').val());
var no_of_pages = parseInt($('.total').attr('a'));
if(page != 0 && page <= no_of_pages){
loadData(page);
}else{
alert('Enter a PAGE between 1 and '+no_of_pages);
$('.goto').val("").focus();
return false;
}
});
});
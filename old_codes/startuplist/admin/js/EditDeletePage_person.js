// 9lessons programming blog
// Srinivas Tamada http://9lessons.info
$(document).ready(function()
{
 $(".delete_profile_person").live('click',function()
{
var id = $(this).attr('id');
var b=$(this).parent().parent();
var dataString = 'id='+ id;
if(confirm("Sure you want to delete this update? There is NO undo!"))
{
	$.ajax({
type: "POST",
url: "../lib/delete_ajax1.php",
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
			
//edit button of the second column.
/* $(".edit_tr1").live('click',function()
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


var dataString = 'id='+ ID +'&profile_person_name='+one_val+'&profile_person_email='+two_val+'&profile_person_active='+three_val;

if(one_val.length>0&& two_val.length>0 && three_val.length>0)
{

$.ajax({
type: "POST",
url: "../lib/live_edit_ajax12.php",
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
$('#loading1').html("<img src='../img/loading.gif'/>").fadeIn('fast');
}
function loading_hide(){
$('#loading1').fadeOut('fast');
}                
function loadData(page){
loading_show();                    
$.ajax
({
type: "POST",
url: "../lib/load_data_person.php",
data: "page="+page,
success: function(msg)
{
$("#container_person").ajaxComplete(function(event, request, settings)
{
loading_hide();
$("#container_person").html(msg);
});
}
});
}
loadData(1);  // For first time page load default results
$('#container_person .pagination_person li.active').live('click',function(){
var page = $(this).attr('p');
loadData(page);
});           
$('#go_btn_person').live('click',function(){
var page = parseInt($('.goto').val());//goto button.
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
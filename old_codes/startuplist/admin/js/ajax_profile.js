
	$(document).ready(function() {
		//this section controls the click of the input divs so we can edit
		$(".edit_tr").click(function() {
		//$("#edit").click(function() {
			var ID=$(this).attr('id');
			//var ID=$(".edit_tr").attr('id');
			$("#first_"+ID).hide();
			$("#last_"+ID).hide();
			$("#email_"+ID).hide();
			$("#contact_"+ID).hide();
			$("#position_"+ID).hide();
			$("#department_"+ID).hide();
			
			$("#ajax_profile").show();
			$("#first_input_"+ID).show();
			$("#last_input_"+ID).show();
			$("#email_input_"+ID).show();
			$("#contact_input_"+ID).show();
			$("#position_input_"+ID).show();
			$("#department_input_"+ID).show();
			
			
			
			}).change(function() {
			//$(".edit_tr").change(function() {
			var ID=$(this).attr('id');
			//var ID=$(".edit_tr").attr('id');
			var first=$("#first_input_"+ID).val();
			var last=$("#last_input_"+ID).val();
			var email=$("#email_input_"+ID).val();
			var contact=$("#contact_input_"+ID).val();
			var position=$("#position_input_"+ID).val();
			var department=$("#department_input_"+ID).val();
			var dataString = 'id='+ ID +'&firstname='+first+'&lastname='+last+'&email='+email+'&contact='+contact+'&position='+position+'&department='+department;
			$("#first_"+ID).html('<img src="load.gif" />');
	
			//this section makes sure the correct data is not-null and passed into ajax processing file
			if(first.length && last.length>0) {
				$.ajax({
				type: "POST",
				url: "../lib/edit_profile.php",
				data: dataString,
				cache: false,
				success: function(html) {	
					$("#first_"+ID).html(first);
					$("#last_"+ID).html(last);
					$("#email_"+ID).html(email);
					$("#contact_"+ID).html(contact);
					$("#position_"+ID).html(position);
					$("#department_"+ID).html(department);
				}
				});
			} else {
				alert('Enter something.');
			}
		}); //close document ready funtion
	
	//THIS SECTION IS FOR WHEN THE EDITABLE BOX IS MOUSE RELEASED.
	$(".editbox").mouseup(function() {
		return false
	});

	$(document).mouseup(function(){
		$(".editbox").hide();
		$(".text").show();
	});
});


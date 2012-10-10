<?php
include("../lib/dbcon.php");
$path = "../img/uploads/";
	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['profile_person_image']['name'];
			$size = $_FILES['profile_person_image']['size'];
			$sql_img=mysql_query("select * from profile_person where profile_person_image='".$name."'");
			$rowPI = mysql_num_rows($sql_img);
	
			if($rowPI == 0){
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(220*220))
						{
						

							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['profile_person_image']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$name))
								{
								//mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
									
									echo "<img style='height:95px;width:95px' src='../img/uploads/".$name."'  class='$name' id='img22'>";

								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
			}
			else
				echo "Duplicate image! Please select a image of a different name.!";	
			exit;
		}
		
		
?>
<?php

function protect($string){
	$string = trim(strip_tags(addslashes($string)));
	return $string;
}

function ajaxinput_div($w,$x,$y){
	
echo	"<div class='input'>";
echo			"<span id='".$x."_<?php echo ".$w."; ?>' class='text'><?php echo ".$y."; ?></span>";
echo			"<input type='text' value='<?php echo ".$y."; ?>' class='editbox' id='".$x."_input_<?php echo ".$id."; ?>' />";
echo	"</div>";
}

function circularthumb(){
	
}

function menugenerator($page){
	$active = "active";
	echo "<ul id='nav'>
          <li id='list1'><a href='../index3.php' class='home transition'><span>Home</span></a></li>
          <li id='list2'><a href='../pages/services_apps.php' class='services transition'><span>Services</span></a></li>
          
     	 <!--  <li id='list4'><a href='../pages/portfolio.php' class='portfolio transition'><span>Portfolio</span></a></li> -->
          <li id='list5'><a href='../pages/about.php' class='about transition'><span>About</span></a></li>
             
          <li id='list6'><a href='../pages/jobs.php' class='jobs transition'><span>Jobs</span></a></li>
          <li id='list7'><a href='../pages/contact.php' class='contact transition'><span>Contact</span></a></li>
</ul>";

	
}

// -----------------------------------------------------------------------  //
// -----------  FOLLOWING ARE THE FUNCTIONS FOR ADMIN CLASSES  -----------  //
// -----------------------------------------------------------------------  //

//get the username of a logged in user based on session ID
function usernamefromid(){ 
	$res1 = mysql_query("SELECT * FROM `users` WHERE `ID` = '".$_SESSION['userID']."'");
	$row1 = mysql_fetch_assoc($res1);
	echo $row1['username']; 
}

function redirectfromlogin(){
$userACL = new ACL($_SESSION['userID']);
if ($userACL->hasPermission('access_admin') === true){
echo "user has admin access";
header("Location: ../admin/index.php");
		
		}else{
			if ($userACL->hasPermission('login_staff') === true) {
			echo "must be staff so send to staff webpage";
			header("Location: http://www.10dd.co/admin/_staff.php");
			
			 }else{
				if ($userACL->hasPermission('login_client') === true) {
				echo "must be client so send to client webpage";
				header("Location: http://www.10dd.co/admin/_client.php");
										
				  }else{
					if ($userACL->hasPermission('login_vendor') === true) {
					echo "must be vendor so send to vendor webpage";
					header("Location: http://www.10dd.co/admin/_vendor.php");
						
						}else{
						   if ($userACL->hasPermission('basic_user') === true) {
						   echo "must be vendor so send to vendor webpage";
						   header("Location: http://www.10dd.co/admin/_vendor.php"); 
						   
						   }else{
						   echo "must not have access";
						   header("Location: http://www.10dd.co/admin/insufficientrights.php");
					}
				}
			}
		}
	}
}


function staffmenu() {
//this funtion detects what modules each user has access to and generates navigation HTML for only allowed items. 


}

function usersmenu() {
echo "<ul id='submenu'>";
echo 	"<li class='css3'><a href='../admin/create.php' class='medium button first blue'>New</a></li>";
echo 	"<li class='css3'><a href='../admin/users.php' class='medium button blue'>Users</a></li>";          
echo 	"<li class='css3'><a href='../admin/roles.php' class='medium button blue'>Roles</a></li>";          
echo 	"<li class='css3'><a href='../admin/perms.php' class='medium button last blue'>Permissions</a></li>";          
echo "</ul><div class='clear'></div>"; 

}


function projectsmenu() {
echo "<ul id='submenu'>";
echo 	"<li class='css3'><a href='../admin/projects_home.php' class='medium button first blue'>Projects</a></li>";          
echo 	"<li class='css3'><a href='../admin/projects_tasks.php' class='medium button blue'>Tasks</a></li>"; 
echo 	"<li class='css3'><a href='../admin/projects_artwork.php' class='medium button blue'>Artwork</a></li>";          
echo 	"<li class='css3'><a href='../admin/projects_.php' class='medium button last blue'>Testing</a></li>";          
echo "</ul><div class='clear'></div>"; 

}


// -----------------------------------------------------------------------  //
// -----------  FOLLOWING ARE THE FUNCTIONS FOR IMAGE BACKEND  -----------  //
// -----------------------------------------------------------------------  //
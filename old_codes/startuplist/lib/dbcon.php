<?php


//allow sessions to be passed so we can see if the user is logged in
session_start();

//connect to the database so we can check, edit, or insert data to our users table
$con = mysql_connect('localhost', 'mikesoer', '+10DDwaylan') or die(mysql_error());
$db = mysql_select_db('mikesoer_startuplist', $con) or die(mysql_error());

//include out functions file giving us access to the protect() function
//include("../lib/functions.php");
ob_start();

//echo "success";

?>
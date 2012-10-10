<?php
$mysql_hostname = "localhost";
$mysql_user = "mikesoer";
$mysql_password = "+10DDwaylan";
$mysql_database = "mikesoer_startuplist";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

?>
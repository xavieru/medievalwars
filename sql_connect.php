<?php 

$mysql_host = "mysql8.000webhost.com";
$mysql_database = "a2976640_medwars";
$mysql_user = "a2976640_medwars";
$mysql_password = "xxxxxxx";


mysql_connect($mysql_host, $mysql_user, $mysql_password)
  or die("<p>Error connecting to database: ".mysql_error()."</p>");

mysql_select_db($mysql_database)
  or die("<p>Error selecting database: ".mysql_error()."</p>");

?>


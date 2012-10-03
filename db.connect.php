<?php  
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is ins_header.php - Read the readme.txt file for more info	*/
/************************************************************************/

$host = "10.10.10.10";
$database = "agoractu";
$user = "dbusername";
$passwd = "dbpassword";


$conn = mysql_connect($host, $user, $passwd) or die ("You Suck - Connection Failed");

mysql_select_db($database);
?>

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


$conn = mysql_connect($host, $user, $passwd) or die ("Error - Connection Failed");
mysql_select_db($database);

//retrieve Site Parameters

$QueryConfig ="select title,subtitle,titlehead,numrows,lastrefresh,cron,lang from configuration where id = 0";
$ResultConfig = mysql_query($QueryConfig);
$ArrayConfig = mysql_fetch_row($ResultConfig);

$param = array();
$param['TITLE'] = mb_convert_encoding($ArrayConfig[0],"UTF-8");
$param['SUBTITLE'] = mb_convert_encoding($ArrayConfig[1],"UTF-8");
$param['TITLEHEAD'] = mb_convert_encoding($ArrayConfig[2],"UTF-8");
$param['NUMROWS'] = $ArrayConfig[3];
$param['LASTREFRESH'] = $ArrayConfig[4];
$param['CRON'] = $ArrayConfig[5];
$param['LANG'] = $ArrayConfig[6];

// Parse language file in array
$langarray = array();
if ($langdir = opendir('lang')){
while (false !== ($langdirentry = readdir($langdir))) {
if ($langdirentry != "." && $langdirentry != "..") {
	array_push($langarray,$langdirentry);
}

}
closedir($langdir);
}
?>

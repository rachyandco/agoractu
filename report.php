<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is report.php - Read the readme.txt file for more info		*/
/************************************************************************/


error_reporting(E_ALL);

include ("db.connect.php");

$intcommid=$_POST["expcommid"];
$intitemid=$_POST["expitemid"];
$intsource=$_POST["expsource"];
$intcurrent=$_POST["expcurrent"];
$intlisttype=$_POST["explisttype"];

	$up_query="UPDATE comments SET pub=1 WHERE com_id ='$intcommid'";
	mysql_query($up_query) or die('Error, query failed');
/*	echo $up_query;
	echo "<br><a href=\"list.php\">Short List</a>"; */
	echo "<script>
<!--
location.replace(\"".$intsource.".php?currentpage=".$intcurrent."&listtype=".$intlisttype."&postid=".$intitemid."#".$intitemid."\");
-->
</script>";

?>


<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is insert.php - Read the readme.txt file for more info		*/
/************************************************************************/


error_reporting(E_ALL);

include ("db.connect.php");

$intcontent=$_POST["expcontent"];
$intuser=$_POST["expuser"];
$intitemid=$_POST["expitemid"];
$intsource=$_POST["expsource"];
$intcurrent=$_POST["expcurrent"];
$intlisttype=$_POST["explisttype"];

if (strlen($intcontent) ==0){
/*alert*/ 

}else{
	$up_query="INSERT INTO comments ( content, who, what_item_id, com_ip ) VALUES ( '".htmlspecialchars($intcontent)."', '".htmlspecialchars($intuser)."' , '$intitemid','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($up_query) or die('Error, query failed');
/*	echo $up_query;
	echo "<br><a href=\"list.php\">Short List</a>"; */
}	echo "<script>
<!--
location.replace(\"".$intsource.".php?currentpage=".$intcurrent."&listtype=".$intlisttype."&postid=".$intitemid."#".$intitemid."\");
-->
</script>";

?>


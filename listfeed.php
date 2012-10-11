<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is listfeed.php - Read the readme.txt file for more info	*/
/************************************************************************/


include ("db.connect.php");
include ("ins_header.php");


echo "<div class=\"row-fluid\">
  <div class=\"span1\">&nbsp;</div>
  <div class=\"span8 post\">";

echo "<h2>".$lang['FEED_LIST']."</h2>";
 echo "<table  class=\"table\">"; 
$Query ="select `id`,`rss`,`name`,`logo` from `rssfeeds`";
$Result = mysql_query($Query);


   while ($line = mysql_fetch_row($Result))
   {

$nomjournal = mb_convert_encoding($line[2],"UTF-8");
echo "<tr><td>" .$line[0]. "</td>
<td>" .$line[1]. "</td>
<td><h3> " .$nomjournal. "</h3></td>";


if ($line[3] == NULL) {echo "<td></td>";} else {

echo "<td><img src=\"" .$line[3]. "\"></td>";}

echo "</tr>";

 }

echo "</table>";
echo "</div></div>";

include ("ins_footer.php");
?>

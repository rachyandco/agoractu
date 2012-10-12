<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is list.php - Read the readme.txt file for more information	*/
/************************************************************************/

include ("db.connect.php");
include ("ins_header.php");
include ("ins_parser.php");
?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span10">
<?

$search=$_POST["search"];
$postid=$_GET["postid"];

// recuperer variable dans url pour type de page
$listtype=$_GET["listtype"];
if ($listtype === NULL) {$listtype = 0;}

// pagination
// find out how many rows are in the table 
$sql = "SELECT COUNT(*) FROM rssingest";
$result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
$r = mysql_fetch_row($result);
$numrows = $r[0];

$rowsperpage = $param['NUMROWS'];
$totalpages = ceil($numrows / $rowsperpage);
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   $currentpage = (int) $_GET['currentpage'];
} else {
   $currentpage = 1;
}

if ($currentpage > $totalpages) {
   $currentpage = $totalpages;
}
if ($currentpage < 1) {
   $currentpage = 1;
}
$offset = ($currentpage - 1) * $rowsperpage;

/******  build the pagination links ******/
$range = 2;
echo "<div id=\"pagination\" class=\"pagination span10\">";
if ($currentpage > 1) {
   echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=1&amp;listtype=".$listtype."'><<</a>";
}
                     
if ($currentpage != $totalpages) {
   $nextpage = $currentpage + 1;
   echo "<a class=\"next\" href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&amp;listtype=".$listtype."'>plus d'articles</a>";
   
}
echo "</div>";
/****** end build pagination links ******/

/****** choix de la requete sql ******/

if (isset($search)) {

//Resultat de la recherche
$Query ="select item_id,feed_url,item_content,item_title,item_date,item_url from rssingest WHERE MATCH (item_content,item_title) AGAINST ('".$search."'  IN BOOLEAN MODE) order by item_date desc LIMIT $offset, $rowsperpage";
$Result = mysql_query($Query);
}
elseif ($listtype == 1) {

//tous les articles classé par nb de commentaire
$Query ="select r.item_id,r.feed_url,r.item_content,r.item_title,r.item_date,r.item_url,c.com_id, sum(c.what_item_id) csum from rssingest r left join comments c
on r.item_id = c.what_item_id where csum > '0' group by r.item_id LIMIT $offset, $rowsperpage";
//$Query ="select distinct r.item_id,r.feed_url,r.item_content,r.item_title,r.item_date,r.item_url,c.what_item_id from rssingest r join comments c on r.item_id = c.what_item_id order by r.item_date desc LIMIT $offset, $rowsperpage";
$Result = mysql_query($Query);
echo "$Query";
}
elseif ($listtype == 2) {

//tous les articles, avec commentaire classé par date

$Query ="select distinct r.item_id,r.feed_url,r.item_content,r.item_title,r.item_date,r.item_url,c.what_item_id,c.com_id from comments c join rssingest r on r.item_id = c.what_item_id order by c.com_id desc LIMIT $offset, $rowsperpage";
$Result = mysql_query($Query);
echo "$Query";


}
else {
// tous les articles par date
$Query ="select `item_id`,`feed_url`,`item_content`,`item_title`,`item_date`,`item_url` from `rssingest` where `item_date` < NOW() order by `item_date` desc LIMIT $offset, $rowsperpage";
$Result = mysql_query($Query);
}
/****** fin choix de la requete sql ******/
/******Afficher Resultat boucle ******/



echo "<div id=\"container\">";
   while ($line = mysql_fetch_row($Result))
	{
$nomjournal = mb_convert_encoding($line[1],"UTF-8");
echo "
<div class=\"row-fluid  well item\"  id=\"post-" .$line[0]. "\">
<div class=\"span10\">
<h4> <a id=\"" .$line[0]. "\" href=\"" .$line[5]. "\" target=\"_blank\">" .$line[3]. " </a></h4><small>" .$nomjournal. " - " .$line[4]. "<br>" .$line[2]. "</small>
<div class=\"row-fluid\">
<div class=\"span2\"><a href=\"#myModal" .$line[0]. "\" role=\"button\" class=\"btn\" data-toggle=\"modal\">".$lang['LIST_REACT']."</a></div>";
//
// Modal pour comment
echo " <div class=\"modal hide fade\" id=\"myModal" .$line[0]. "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel" .$line[0]. "\" aria-hidden=\"true\"><form method=POST action=insert.php>
    <div class=\"modal-header\">
    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
    <h3 id=\"myModalLabel" .$line[0]. "\">".$lang['MODAL_ADDCOMMENT']."</h3>
    </div>
    <div class=\"modal-body\">";


$Ed_query ="select * from `users` where `userid` ='$id'";
$Ed_result = mysql_query($Ed_query);

	echo "<h2>".$lang['MODAL_COMMENTEXT'].":</h2>";
	echo "<textarea name=expcontent></textarea>";
	echo "<h3>".$lang['MODAL_NAME'].":</h3>
		<input type=text name=expuser value=\"\">
		<input type=hidden name=expsource value=list>
		<input type=hidden name=expcurrent value=".$currentpage.">
		<input type=hidden name=explisttype value=".$listtype.">
		<input type=hidden name=expitemid value=".$line[0].">";

echo " </div>
    <div class=\"modal-footer\">
    	<button class=\"btn btn-primary\"  type=submit value=Save>".$lang['MODAL_SAVE']."</button>
	<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">".$lang['MODAL_CLOSE']."</button>
    
    </div></form>
    </div>";
// End Modal pour comment

//keep comments open if item selected
if ($postid == $line[0]){$opencomments = "in";} else {$opencomments = "";}
	
			$Query2 ="select `com_id`,`content`,`who`,`pub`,`timestamp` from `comments` where `pub` in (0,1) and `what_item_id` ='$line[0]'";
			$Result2 = mysql_query($Query2);
			$Num_rows2 = mysql_num_rows($Result2);

			if ($Num_rows2 == 0) {
				echo "<div class=\"span2\">0 ".$lang['LIST_COMMENTS'].".</div>";
			} 
			else
			{

				echo "<div class=\"accordion\"  id=\"accordion".$line[0]."\"> <div class=\"accordion-group\">
<div class=\"accordion-heading\"><a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion".$line[0]."\" href=\"#collapse".$line[0]."\">".$lang['LIST_SHOW']." ".$Num_rows2." ".$lang['LIST_COMMENTS2']." </a></div>
			<div id=\"collapse".$line[0]."\" class=\"accordion-body collapse ".$opencomments."\">
<div class=\"accordion-inner\"> <ul>";



		 	while ($line2 = mysql_fetch_row($Result2))
		   		{
				echo "
				<li>" .$line2[1]. " - <i>";
				if (!($line2[2] == NULL)) {
		 			echo mb_convert_encoding($line2[2],"UTF-8"); 
					} else {
				echo $lang['LIST_ANON'];
					}
				echo "</i>";

				echo " - ".mb_convert_encoding($line2[4],"UTF-8");
			
				if ($line2[3]==0){

// Modal pour signaler
echo " <div class=\"modal hide fade\" id=\"ModalReport" .$line2[0]. "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalReportLabel" .$line2[0]. "\" aria-hidden=\"true\"><form method=POST action=report.php>
    <div class=\"modal-header\">
    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
    <h3 id=\"ModalReportLabel" .$line2[0]. "\">".$lang['LIST_FLAGCOMMENT']."</h3>
    </div>
    <div class=\"modal-body\">";

	echo "<h2>".$lang['LIST_FLAGCOMMENT2']."</h2>";

	echo "  insert Captcha here
		<input type=hidden name=expcurrent value=".$currentpage.">
		<input type=hidden name=explisttype value=".$listtype.">
		<input type=hidden name=expitemid value=".$line[0].">
		<input type=hidden name=expsource value=list>
		<input type=hidden name=expcommid value=".$line2[0].">";



echo " </div>
    <div class=\"modal-footer\">
    	<button class=\"btn btn-primary\"  type=submit value=Save>".$lang['LIST_FLAG']."</button>
	<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">".$lang['MODAL_CANCEL']."</button>
    
    </div></form>
    </div>";
// End Modal pour signaler

				echo " - <a class=\"\"  data-toggle=\"modal\" href=\"#ModalReport" .$line2[0]. "\">".$lang['LIST_FLAG']."</a>";
					}else{
				echo "<small> - ".$lang['LIST_COMMENTWASFLAGGED']."</small>";}
				echo "</li> ";
		
				}
				echo "</ul></div></div></div></div>"; 
			}
echo "</div></div></div>";
 }
echo "</div>";
/******End Afficher Resultat boucle ******/


echo "</div>";

/* Placeholder for second column
<!--div3-->	<div class="span2">
<!--Sidebar content-->
Options
</div>
*/

echo "</div></div>";
include ("ins_footer.php");
?>

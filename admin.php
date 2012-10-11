<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is admin.php - Read the readme.txt file for more information	*/
/************************************************************************/





include ("db.connect.php");
include ("ins_header.php");


//charger la configuration
$QueryConfig ="select id,title,subtitle,titlehead,numrows from configuration";
$ResultConfig = mysql_query($QueryConfig);

//retour de l'action du formulaire
if(isset($_POST['delete']))
{
$commid = $_POST['commid'];
$up_query="UPDATE comments SET pub=2 WHERE com_id ='$commid'";
	mysql_query($up_query) or die('Error, query failed');
}

if(isset($_POST['restore']))
{
$commid = $_POST['commid'];
$up_query="UPDATE comments SET pub=0 WHERE com_id ='$commid'";
	mysql_query($up_query) or die('Error, query failed');
}

$query ="select `com_id`,`content`,`who`, `pub` from `comments` where pub=1";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
?>
 <div class="fluid mini-layout " id="adminrefresh">
    <div class="row-fluid mini-layout-body">
    <div class="span8">
     <!--Body content-->
<?
if ($num_rows == 0) {

echo $lang['ADMIN_NOCOMMENTS'];
	} else {
echo "<h2>".$lang['ADMIN_COMMENTSAVAILABLE']."</h2>";
	while ($line = mysql_fetch_row($result))
		{
echo "<div class=\"well\">";
echo "<div>".$line[1]."</div>";
echo "<div>".$lang['ADMIN_AUTHOR']." : ".$line[2]."</div>";

echo "<div class=\"btn-group\">
<form   style=\"display: inline\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<input type=hidden name=commid value=".$line[0].">
<button class=\"btn btn-danger\"  type=submit name=delete value=delete>".$lang['ADMIN_DELETE']."</button>
</form>&nbsp;
<form style=\"display: inline\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<input type=hidden name=commid value=".$line[0].">
<button class=\"btn\"  type=submit name=restore value=restore>".$lang['ADMIN_PUTBACK']."</button>
</form>
</div>";

echo "</div>";
		}

	}
?>
</div>
    <div class="span4 well mini-layout-sidebar">
<!--Sidebar content-->
<?   
	echo "<h2>".$lang['ADMIN_PARAM_CONFIG']."</h2>";

  while ($lineconfig = mysql_fetch_row($ResultConfig))
   {
echo "
<form>
<label>".$lang['ADMIN_PARAM_TITLE']." :</label>
<input type=text name=configtitle value=\"".mb_convert_encoding($lineconfig[1],"UTF-8")."\">
<label>".$lang['ADMIN_PARAM_SUBTITLE']." :</label>
<input type=text name=configsubtitle value=\"".mb_convert_encoding($lineconfig[2],"UTF-8")."\">
<label>".$lang['ADMIN_PARAM_TITLELABEL']." :</label>
<input type=text name=configtitlehead value=\"".mb_convert_encoding($lineconfig[3],"UTF-8")."\">
<label>".$lang['ADMIN_PARAM_NBARTICLES']." :</label>
<input type=text name=confignumrows value=\"".mb_convert_encoding($lineconfig[4],"UTF-8")."\">
<label>".$lang['ADMIN_PARAM_AUTOUPDATE']." :</label>
<select name=cron>
<option value=0>".$lang['ADMIN_PARAM_ACTIVATED']."</option>
<option value=1>".$lang['ADMIN_PARAM_DEACTIVATED']."</option>
</select>
<br>
<button class=\"btn btn-primary\"  type=submit value=Save>".$lang['ADMIN_PARAM_SAVE']."</button>
<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">".$lang['ADMIN_PARAM_CANCEL']."</button>
</form>
";
}
?>
    </div>
    </div>
    </div>
<?
include ("ins_footer.php");
?>

   
    

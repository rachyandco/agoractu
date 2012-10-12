<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is admin.php - Read the readme.txt file for more information	*/
/************************************************************************/

include ("db.connect.php");
include ("ins_header.php");

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
?>
<div class="well">
	<div><? echo $line[1];?>"</div>
		<div><? echo $lang['ADMIN_AUTHOR']; ?> : <? echo $line[2]; ?></div>
		<div class="btn-group">
			<form   style="display: inline" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
			<input type=hidden name=commid value="<? echo $line[0]; ?>">
			<button class="btn btn-danger"  type=submit name=delete value=delete><? echo $lang['ADMIN_DELETE']; ?></button>
			</form>
		&nbsp;
			<form style="display: inline" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
			<input type=hidden name=commid value="<? echo $line[0]; ?>">
			<button class="btn"  type=submit name=restore value=restore><? echo $lang['ADMIN_PUTBACK']; ?></button>
			</form>
		</div>
	</div>
<?
		}
	}
?>
</div>
    <div class="span4 well mini-layout-sidebar">
<!--Sidebar content-->
<?   
	echo "<h2>".$lang['ADMIN_PARAM_CONFIG']."</h2>";

if ($param['CRON'] == 0)
	{
		$cronselectON = "selected=\"selected\"";
		$cronselectOFF = "";
	} else 
	{
		$cronselectOFF = "selected=\"selected\"";
		$cronselectON = "";
}

echo "
<form>
<label>".$lang['ADMIN_PARAM_TITLE']." :</label>
<input type=text name=configtitle value=\"".$param['TITLE']."\">
<label>".$lang['ADMIN_PARAM_SUBTITLE']." :</label>
<input type=text name=configsubtitle value=\"".$param['SUBTITLE']."\">
<label>".$lang['ADMIN_PARAM_TITLELABEL']." :</label>
<input type=text name=configtitlehead value=\"".$param['TITLEHEAD']."\">
<label>".$lang['ADMIN_PARAM_NBARTICLES']." :</label>
<input type=text name=confignumrows value=\"".$param['NUMROWS']."\">
<label>".$lang['ADMIN_PARAM_AUTOUPDATE']." :</label>
<select name=cron>
<option value=0 ".$cronselectON.">".$lang['ADMIN_PARAM_ACTIVATED']."</option>
<option value=1 ".$cronselectOFF.">".$lang['ADMIN_PARAM_DEACTIVATED']."</option>
</select>
";

// Admin Form - Get available languages
echo "<label>".$lang['ADMIN_PARAM_SITELANGUAGE']." :</label>";
echo "<select name=lang>";
foreach($langarray as $langavail){
if ($param['LANG'] == $langavail)
	{$langselect = "selected=\"selected\"";
	} else {
	$langselect = "";
}
echo "<option value=\"".$langavail."\" ".$langselect.">".$langavail."</option>";
}
echo "</select>";

echo "<br>
<button class=\"btn btn-primary\"  type=submit value=Save>".$lang['ADMIN_PARAM_SAVE']."</button>
<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">".$lang['ADMIN_PARAM_CANCEL']."</button>
</form>
";
?>
    </div>
    </div>
    </div>
<?
include ("ins_footer.php");
?>

   
    

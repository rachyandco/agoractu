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

echo "Il n'y pas de commentaires à modérer.";
	} else {
echo "<h2>Commentaires à Modérer</h2>";
	while ($line = mysql_fetch_row($result))
		{
echo "<div class=\"well\">";
echo "<div>".$line[1]."</div>";
echo "<div>Auteur : ".$line[2]."</div>";

echo "<div class=\"btn-group\">
<form   style=\"display: inline\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<input type=hidden name=commid value=".$line[0].">
<button class=\"btn btn-danger\"  type=submit name=delete value=delete>Supprimer</button>
</form>&nbsp;
<form style=\"display: inline\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<input type=hidden name=commid value=".$line[0].">
<button class=\"btn\"  type=submit name=restore value=restore>Remettre</button>
</form>
</div>";

echo "</div>";
		}

	}
?>
</div>
    <div class="span4 well mini-layout-sidebar">
   <!--Sidebar content-->
	<h2>Configuration</h2>
<?
  while ($lineconfig = mysql_fetch_row($ResultConfig))
   {
echo "
<form>
<label>Titre du Site :</label>
<input type=text name=configtitle value=\"".mb_convert_encoding($lineconfig[1],"UTF-8")."\">
<label>Sous-Titre du Site :</label>
<input type=text name=configsubtitle value=\"".mb_convert_encoding($lineconfig[2],"UTF-8")."\">
<label>Titre du Site - dans la barre du navigateur :</label>
<input type=text name=configtitlehead value=\"".mb_convert_encoding($lineconfig[3],"UTF-8")."\">
<label>Nombre d'articles affichés par page :</label>
<input type=text name=confignumrows value=\"".mb_convert_encoding($lineconfig[4],"UTF-8")."\">
<label>Mise à jour automatique (désactiver si un cronjob est installé sur le serveur) :</label>
<select name=cron>
<option value=0>Activée</option>
<option value=1>Desactivée</option>
</select>
<br>
<button class=\"btn btn-primary\"  type=submit value=Save>Sauvegarder</button>
<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Annuler</button>
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

   
    

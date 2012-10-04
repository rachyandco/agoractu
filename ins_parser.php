<?php
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is ins_parser.php - Read the readme.txt file for more info	*/
/************************************************************************/


include ("db.connect.php");

/*check if cron job is on*/
$QueryCron ="select cron from configuration where id = 0";
$ResultCron = mysql_query($QueryCron);
$doupdate = mysql_fetch_row($ResultCron);
$doupdate2 = $doupdate[0];


/*if cron is set to 0 (Not) do refresh based on time*/
if ($doupdate2 == 0){

/*last refresh control*/
$QueryTime ="select lastrefresh from configuration where id = 0";
$ResultTime = mysql_query($QueryTime);
$linetime = mysql_fetch_row($ResultTime);
$actualtime = time();
$interval=time()-strtotime($linetime[0]);
if ($interval > 300){
$doupdate2 = 1;}
}


if ($doupdate2 == 1){

$Query ="select `id`,`rss`,`name`,`logo` from `rssfeeds`";
$Result = mysql_query($Query);

   while ($line = mysql_fetch_row($Result))
   {

	libxml_use_internal_errors(true);
	$RSS_DOC = simpleXML_load_file($line[1]);
	if (!$RSS_DOC) {
		echo "Failed loading XML\n";
		foreach(libxml_get_errors() as $error) {
			echo "\t", $error->message;
		}
	}


	/* Get title, link, managing editor, and copyright from the document  */
	$rss_title = $RSS_DOC->channel->title;
	$rss_link = $RSS_DOC->channel->link;
	$rss_editor = $RSS_DOC->channel->managingEditor;
	$rss_copyright = $RSS_DOC->channel->copyright;
	$rss_date = $RSS_DOC->channel->pubDate;
	$rss_description = $RSS_DOC->channel->description;


	//Loop through each item in the RSS document

	foreach($RSS_DOC->channel->item as $RSSitem)
	{
		$item_id 	= md5(addslashes($RSSitem->title));
		$fetch_date = date("Y-m-j G:i:s"); //NOTE: we don't use a DB SQL function so its database independant
		$item_title = addslashes($RSSitem->title);
		$item_content = addslashes($RSSitem->description);
		$item_date  = date("Y-m-j G:i:s", strtotime($RSSitem->pubDate));
		$item_url	= $RSSitem->link;

	//	echo "Processing item '" , $item_id , "' on " , $fetch_date 	, "<br/>";
	//	echo $item_title, " - ";
	//	echo $item_date, "<br/>";
	//	echo $item_url, "<br/>";

//add special handling for LeTemps (should be put in a pluggin)
/**/
if ($line[2] == "Le Temps"){
preg_match('/uuid(.*)\//i',$item_url, $matches);
$item_url = "http://m.letemps.ch/Page/Uuid/".$matches[1];
$item_url = str_replace("0E","-",$item_url);
$item_url = str_replace("0A","0",$item_url);
$item_url = str_replace("0C","",$item_url);

$item_content = substr($item_content, 0, strpos($item_content, "<img"));

}

/*
hack the url

source: Uuid 0Ce1280A2c20E0Addb0E11e20Ead9b0E2e14d57ab16f
objective: e12802c2-0ddb-11e2-ad9b-2e14d57ab16f
replace 0E by -
replace 0A by 0
replace 0C by nothing

hack the description
remove from first img tag

*/
//end special handling for LeTemps

		// Does record already exist? Only insert if new item...

		$item_exists_sql = "SELECT item_id FROM rssingest where item_id = '" . $item_id . "'";
		$item_exists = mysql_query($item_exists_sql, $conn);
		if(mysql_num_rows($item_exists)<1)
		{
	//		echo "<font color=green>Inserting new item..</font><br/>";
			$item_insert_sql = "INSERT INTO rssingest(item_id, feed_url,item_content, item_title, item_date, item_url, fetch_date) VALUES ('" . $item_id . "', '" . $line[2] . "', '" . $item_content . "','" . $item_title . "', '" . $item_date . "', '" . $item_url . "', '" . $fetch_date . "')";
			$insert_item = mysql_query($item_insert_sql, $conn);
		}
		else
		{
		//	echo "<font color=blue>Not inserting existing item..</font><br/>";
		}

	//	echo "<br/>";
	}

	// End of form //
//insert actual time
$time_insert_sql = "UPDATE configuration SET lastrefresh=NOW() WHERE  id = 0";
$insert_time = mysql_query($time_insert_sql, $conn);
} /*catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}*/

} /*last refresh control*/
?>

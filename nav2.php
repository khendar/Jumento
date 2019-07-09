<?php
include("db.php");
$parentselectquery = "SELECT * FROM pages WHERE page_id>0 AND parent_id=0 AND `page_visibility`='public' ORDER BY `page_order` ASC";
$parentselectresult = mysql_query($parentselectquery, $linkID) or die(mysql_error());
$count = mysql_num_rows($parentselectresult);
$current = $pageid;

if($count ==0)
{
	//echo "no parent pages<br>";
}
else
{
	$hnav= 	"<ul";
	for ($i=0;$i<$count;$i++)
	{	
		$thispage = mysql_fetch_array($parentselectresult);	
		$thisid = $thispage["page_id"];
		//echo "<a href=\"index.php?l=$thisid\">".$thispage["title"]."</a><br>";
		$hnav.="
		><li
			><a href=\"buildpage.php?l=$thisid\">".$thispage["page_title"]."</a
		></li
		";
		//recur($thisid, $linkID);
	}
	$hnav .= "></ul>";
}
return $hnav;
/*
function recur($id, $linkID){
		$childselectquery = "SELECT * FROM pages WHERE parent_id = $id";
		$childselectresult = mysql_query($childselectquery, $linkID) or die ($childselectquery.mysql_error());
		$childcount = mysql_num_rows($childselectresult);
		if($childcount ==0)
		{		
		}
		else
		{
			for ($i=0;$i<$childcount;$i++)
			{
				$thischildpage = mysql_fetch_array($childselectresult);	
				//echo "<blockquote>";
				$thischildid = $thischildpage["page_id"];
				//echo "<a href=\"index.php?l=$thischildid\">".$thischildpage["title"]."</a><br>";
				echo"
				><li
					><a href=\"index.php?l=$thischildid\">".$thischildpage["page_title"]."</a
				></li
				";
				//recur($thischildid, $linkID);
				//echo "</blockquote>";
			}
		}
}*/


?>
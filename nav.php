<?php
include("db.php");
$parentselectquery = "SELECT * FROM pages WHERE page_id>0 AND parent_id=0 AND `page_visibility`='public' ORDER BY `page_order` ASC";

$parentselectresult = $linkID->query($parentselectquery);
$count = $parentselectresult->num_rows;
$current = $pageid;

if($count ==0)
{
	//echo "no parent pages<br>";
}
else
{
	echo 	"<ul";
	for ($i=0;$i<$count;$i++)
	{	

		$thispage = $parentselectresult->fetch_assoc();	
		$thisid = $thispage["page_id"];
		
		
		//echo "<a href=\"index.php?l=$thisid\">".$thispage["title"]."</a><br>";
		echo"
		><li
			><a href=\"index.php?l=$thisid\">".$thispage["page_title"]."</a
		></li
		";
		//recur($thisid, $linkID);
	}
	echo "></ul>";
}
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
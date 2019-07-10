<?php
//$linkID = mysql_connect("localhost", "cyberia", "cyberia");
//mysql_select_db("cyberia", $linkID);
include("db.php");

$thispage = $_GET["p"];
if ($thispage!="")
{
	$getpage = "SELECT * FROM content WHERE page_id = $thispage";
	$getpageresult = $linkID->query($getpage);
	$page = $getpageresult->fetch_assoc();
	//print_r($page);
}
if ($_POST["submit"] == "Submit")
{
	$page_id = $_POST["page_id"];
	//echo $id;
	$title = $_POST["title"];
	$keywords = $_POST["keywords"];
	$description = addslashes($_POST["description"]);
	$content=addslashes($_POST["content"]);
	$updatequery = "UPDATE `content` SET title = '$title', keywords='$keywords',description = '$description', content = '$content'
	 WHERE page_id=$page_id";
	//echo $insertquery;
	echo "Page update";
	$updateresult = $linkID->query($updatequery);
	
	


	
}
else
{
	printform($page);
}
//print_form();


function printform($page)
{
$page_id = $page["page_id"];
//echo $id;
$title = $page["title"];
$description = $page["description"];
$content = $page["content"];
$keywords = $page["keywords"];
echo "
<table border=1 cellpadding=4 cellspacing=0 width=100%>
<form method=\"post\" name=\"editForm\" action = \"$_SERVER[PHP_SELF]?t=edit\">
<input type=\"hidden\" name =\"page_id\" value =\"$page_id\"></input>
<tr><td>Title</td><td><input type=\"text\" name=\"title\" value=\"$title\" size=60></input></td></tr>
<tr><td>Keywords</td><td><input type=\"text\" name=\"keywords\" value=\"$keywords\" size=80></input></td></tr>
<tr><td>Description</td><td><input type=\"text\" name=\"description\" value=\"$description\" size=80></input></td></tr>
<tr><td>Content</td><td><textarea name=\"content\" value=\"\" rows=5 cols = 60>$content</textarea></input></td></tr>
<tr><td></td><td><input type=\"submit\" name=\"submit\" value =\"Submit\"></tr>

</form>
</table>";
}


?>
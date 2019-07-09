<?php
$linkID = mysql_connect("localhost", "cyberia", "cyberia");
mysql_select_db("test", $linkID);


$query = "select section_content from sections where section_id=1";
$result = mysql_query($query);
$image = mysql_result($result, 0, 'section_content');
$display_block .= "<img src=\"$image\"/>";
echo $display_block;
?>

<?php

include("db.php");
include("lib/functions.php");
include("lib/cbparser/cbparser.php");

$page_title="Edit Page Mode";
$task = $_POST["task"];
$subtask = $_POST["subtask"];
$page_id = $_REQUEST["page_id"];
$section_id = $_POST["section_id"];
$section_order = $_POST["section_order"];
$currentuser = $_SESSION["username"];
$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'?l='.$page_id;
if($page_id != NULL)
{
echo '<h3>Edit Page</h3>';
switch($subtask){
    case("addbefore"):
	echo "<h4>Adding a new section</h4>";
		$makeroom = "UPDATE sections SET section_order = section_order + 1
		WHERE page_id = $page_id and section_order>=$section_order";
    	$makeroomresult = mysql_query($makeroom, $linkID) or die(mysql_error());
		$addnew = "INSERT INTO `sections` (`page_id`, `section_order`, `section_content`, `section_date_created`,`section_user_created`, `section_user_modified`)
		VALUES ($page_id, $section_order, 'some default content',NOW(), '$currentuser','$currentuser')";
		$addnewresult = mysql_query($addnew, $linkID) or die(mysql_error());
    break;
    case("addfirst"):
		echo "<h4>Adding a the first  section to a page</h4>";
		$addfirst = "INSERT INTO `sections` (`page_id`, `section_order`, `section_content`, `section_date_created`,`section_user_created`, `section_user_modified`)
		VALUES ($page_id,1 , 'some default content', NOW(), '$currentuser','$currentuser')";
		//echo $addfirst;
		$addfirstresult = mysql_query($addfirst, $linkID) or die(mysql_error());
    break;
    case("addafter"):
		echo "<h4>Adding a new section</h4>";
		$makeroom = "UPDATE sections SET section_order = section_order + 1
		WHERE page_id = $page_id and section_order>$section_order";
    	$makeroomresult = mysql_query($makeroom, $linkID) or die(mysql_error());
		$addnew = "INSERT INTO sections (`page_id`, `section_order`, `section_content`, `section_date_created`,`section_user_created`, `section_user_modified`)
		VALUES ($page_id, $section_order+1, 'some default content', NOW(),'$currentuser','$currentuser')";

		$addnewresult = mysql_query($addnew, $linkID) or die(mysql_error());
    break;
    case("edit"):
		echo "<h4>Editing section $section_id</h4>";
		$section_type=$_POST["section_type"];
		$section_content=addslashes($_POST["section_content"]);
                if($section_type=="bbcode")
                {
                 $section_content = bb2html($section_content);
                 }
                $section_content = str_replace('<script>','',$section_content);
                $section_content = str_replace('</script>','',$section_content);
                //$section_content = closetags($section_content);
		$editthis = "UPDATE sections SET section_content = '$section_content' ,
		`section_user_modified` = '$currentuser'
		WHERE section_id = $section_id";

    	$editthisresult = mysql_query($editthis, $linkID);
		if(mysql_error())
		{
			echo '<pre>'.$editthisresult .'</pre> caused'.mysql_error();
		}

	break;
    case("delete"):
		echo "<h4>Deleting section $section_id</h4>";
		$delete = "DELETE FROM sections WHERE section_id=$section_id";
		$deleteresult = mysql_query($delete, $linkID) or die(mysql_error());
		$squeezeup = "UPDATE sections SET section_order = section_order - 1 WHERE page_id = $page_id and section_order>$section_order";
		$squeezeupresult = mysql_query($squeezeup, $linkID) or die(mysql_error());

    break;
    case("moveup"):
		echo "moveup";
	break;
	case("type"):
		echo "<h4>Updating section type $section_id</h4>";

		$section_type = $_POST['section_type'];
			echo $section_type;
		$sectiontype='
UPDATE `sections` SET `section_type` = \''.$section_type.'\',
`section_date_modified` = NOW(), section_user_modified = \''.$currentuser.'\'
WHERE `section_id` ='.$section_id;

	$sectiontyperesult = mysql_query($sectiontype, $linkID);

	if($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $sectiontype . '</pre><br /> (caused: ' . $msg . ')';

	break;
	case("pageinfo"):
		echo "<h4>Updating page info $page_id</h4>";
		$page_title = addslashes($_POST["page_title"]);
		$page_keywords = addslashes($_POST["page_keywords"]);
		$page_description = addslashes($_POST["page_description"]);
		$page_visibility = $_POST['page_visibility'];
		$pageinfo = "UPDATE `pages` SET `page_title` = '$page_title', `page_keywords`='$page_keywords',
		`page_description` = '$page_description',`page_visibility`='$page_visibility', `user_modified` = '$currentuser' WHERE `page_id`=$page_id";
		//echo $pageinfo;
		$pageinforesult = mysql_query($pageinfo, $linkID) or die (mysql_error());

	break;
    default:
		echo "";
}


    $getpagequery = "SELECT * FROM pages, sections WHERE sections.page_id=$page_id
	AND sections.page_id = pages.page_id ORDER by sections.section_order ASC";
	//echo $getpagequery;
	$getpageresult = mysql_query($getpagequery,$linkID) or die(mysql_error());
    if(mysql_num_rows($getpageresult)!=0)
    {
		$page = mysql_fetch_array($getpageresult);
		showpageinfo($page, $linkID);
		$getpageresult = mysql_query($getpagequery,$linkID) or die(mysql_error());
		for($i=0;$i<mysql_num_rows($getpageresult);$i++)
        {
	    	$page = mysql_fetch_array($getpageresult);
	    	$pagecontents .= $page["section_content"];
	    	showsections($page, $linkID);
        }
		$page_description = $page["page_description"];
		$page_keywords = $page["page_keywords"];
		echo "<br/><div style=\"border:1px dashed #ddd;color:#ddd\">Preview</div>";
		echo "<div style=\"border:1px dashed #ddd;color:#aaa;background-color:#ddd\">";
		echo htmlentities("<meta name=\"description\" content=\"$page_description\">");
		echo '<br/>';
		echo htmlentities("<meta name=\"keywords\" content=\"$page_keywords\">");
		echo "</div><div style=\"border:1px dashed #ddd\">".stripslashes($pagecontents)."</div>";
    }
    else
    {
	    $getpagequery = "SELECT * FROM pages WHERE pages.page_id=$page_id ";
		$getpageresult = mysql_query($getpagequery,$linkID) or die(mysql_error());
		$page = mysql_fetch_array($getpageresult);
		showpageinfo($page, $linkID);
		echo "This page has no sections yet. <br/>";
		?>
		<form name="addfirst" method="post" action = "index.php">
		   <div>	<input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
	 	   	<input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
	    	<input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
	    	<input type="image" src="images/add.gif" style="width:20px;height:20px"  alt = "add a new section before the current one"/>
			Click here to add a new section.
	    	<input type="hidden" name="subtask" value="addfirst"/>
			<input type="hidden" name="task" value="editmode"/> </div>
		</form>
		<?php
    }
}
else
{
	include("editmodelist.php");
}

function showpageinfo($page, $linkID)
{
		$page_id = $page["page_id"];
		$page_title = $page["page_title"];
	    $page_description = $page["page_description"];
		$page_keywords = $page["page_keywords"];
		$page_date_created = $page["date_created"];
		$page_date_modified = $page["date_modified"];
		$page_user_created = $page["user_created"];
		$page_user_modified = $page["user_modified"];
		$page_visibility = $page["page_visibility"];
		$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'?l='.$page_id;
?>		
<form  id="editForm" method="post"  action = "index.php">
	<table class="output" cellpadding='4' cellspacing='0' width='100%'>
			<tr style="color:#aaa;font-size:80%;background-color:#dddddd" >
  				<td>
				<input type="hidden" name ="page_id" value ="<?php echo $page_id;?>"/>
				<?php
				echo 'Page: '.$page["page_id"].'.'.$page["parent_id"].'.'.$page["page_order"].'<br/>';
				echo 'Visibility: '.$page_visibility.'<br/>';
				?></td>
				<td>
				<?php 
				echo 'Created: '.$page_date_created.'<br/>';
				echo 'Last Modified: '.$page_date_modified.'<br/>';
				?>			
				</td>
				<td>
				<?php
				echo 'Created by: '.$page_user_created.'<br/>';
				echo 'Modified by: '.$page_user_modified.'<br/>';
				?>
				</td>
			</tr>
			<tr><td style="font-size:80%" >Title</td><td colspan="2"><input type="text" name="page_title" value="<?php echo htmlentities($page_title);?>" size='60' style="width:99%"/></td></tr>
			<tr><td style="font-size:80%">Keywords</td><td colspan="2"><input type="text" name="page_keywords" value="<?php echo htmlentities($page_keywords);?>" size='80' style="width:99%"/></td></tr>
			<tr><td style="font-size:80%">Description</td><td colspan="2"><input type="text" name="page_description" value="<?php echo htmlentities($page_description);?>" size='80' style="width:99%"/></td></tr>
			<tr><td style="font-size:80%">Visibility</td><td colspan="2">
			<div><input type="radio" name="page_visibility" value="public" <?php if ($page_visibility == 'public')echo 'checked="checked"';?> /> Public 
			<input type="radio" name="page_visibility" value="private" <?php if ($page_visibility == 'private')echo 'checked="checked"';?> /> Private 
			<input type="radio" name="page_visibility" value="group" <?php if ($page_visibility == 'group')echo 'checked="checked"';?> /> Group </div>
			</td></tr>
			<tr><td style="font-size:80%">Page URL</td><td colspan="2"><input type="text" name="url" value="
<?php echo htmlentities($url);?>" readonly="readonly" style="width:99%" onclick="javascript:this.select();" /> </td></tr>
			<tr><td></td><td colspan="2"><input type="submit" name="submit" value ="Submit" class="button" />
			<div><input type="hidden" name="subtask" value="pageinfo" />
			<input type="hidden" name="task" value="editmode" />
			<input type="hidden" name="page_id" value="<?php echo $page_id;?>" /></div>
			</td></tr>



		</table>
</form>
		<?php
}

function showsections($page, $linkID)
{
$page_id = $page["page_id"];
$section_id = $page["section_id"];
$section_order = $page["section_order"];
$section_type = $page["section_type"];
$section_status = $page["section_status"];
$section_modified = $page["section_date_modified"];
$section_created = $page["section_date_created"];
$section_user_created = $page["section_user_created"];
$section_user_modified = $page["section_user_modified"];
$section_content = $page["section_content"];
$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'?l='.$page_id;
$section_anchor = $url.'#'.$section_id;
?>
<table style="width:100%" class="output" cellpadding="4" cellspacing="0">
  <tr style="background-color:#dddddd">
    <td style="color:#aaa;font-size:80%;height:32px;">
    <?php 
	//.$page["section_id"].'.'
		echo 'Section: '.$page["page_id"].'.'.$page["section_order"].'<br/>';
		echo 'Type: '.$section_type.'<br/>';
		echo 'Status: '.$section_status.'<br/>';
	?>
    </td>
	<td style="color:#aaa;font-size:80%;height:32px;">
	<?php 
		echo 'Created: '.$section_created.'<br/>';
		echo 'Last Modified: '.$section_modified.'<br/>';
	?>
	</td>
	<td style="color:#aaa;font-size:80%;height:32px;">
	<?php 
		echo 'Created by: '.$section_user_created.'<br/>';
		echo 'Modified by: '.$section_user_modified.'<br/>';
	?>
	</td>
	    <td>

    </td>
    <td><form id="addbefore" method="post" action = "index.php">
	    <div><input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
	    <input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
	    <input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
	    <div class="info">
            <input type="image" src="images/add.gif" style="width:20px;height:20px"  alt = "add a new section before the current one"/>
    	    <span>
    	<?php
		echo 'Add a new section before this section';
	?>
	</span> </div>
            <input type="hidden" name="subtask" value="addbefore"/>
		<input type="hidden" name="task" value="editmode"/></div>
	</form></td>

  </tr>
  <tr>
    <td colspan="5" style="padding:5px;">
	<form id="edit" method="post" action="index.php">
	<?php
	switch($section_type)
	{
		case('html'):
			echo '<div><textarea name="section_content" style="font-size:80%;font-family:Verdana, Arial, Helvetica, sans-serif;width:100%" cols="80" rows = "20" >';
			echo stripslashes(htmlentities($section_content));
			echo '</textarea></div>';
		break;
		case('bbcode'):
			echo '<div><textarea name="section_content" style="font-size:80%;font-family:Verdana, Arial, Helvetica, sans-serif;width:100%" cols="80" rows = "20" >';
			echo strip_tags(html2bb($section_content));
			echo '</textarea></div>';
		break;
		case('wysiwyg_basic'):
			include("lib/FCKeditor/fckeditor.php") ;
			// Automatically calculates the editor base path based on the _samples directory.
			// This is usefull only for these samples. A real application should use something like this:
			// $oFCKeditor->BasePath = '/FCKeditor/' ;	// '/FCKeditor/' is the default value.
			$sBasePath = 'lib/FCKeditor/';
			//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

			$oFCKeditor = new FCKeditor('section_content') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->Height = '400' ;
			$oFCKeditor->Config['SkinPath']= '/demo/'.$sBasePath . 'editor/skins/silver/' ;
			$oFCKeditor->ToolbarSet = "Basic" ;
			$oFCKeditor->Value		= $section_content ;
			$oFCKeditor->Create() ;
		break;
		case('wysiwyg_full'):
			include("lib/FCKeditor/fckeditor.php") ;
			// Automatically calculates the editor base path based on the _samples directory.
			// This is usefull only for these samples. A real application should use something like this:
			// $oFCKeditor->BasePath = '/FCKeditor/' ;	// '/FCKeditor/' is the default value.
			$sBasePath = 'lib/FCKeditor/';
			//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

			$oFCKeditor = new FCKeditor('section_content') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->Config['SkinPath']= '/demo/'.$sBasePath . 'editor/skins/silver/' ;
			$oFCKeditor->Height = '400' ;
			$oFCKeditor->ToolbarSet = "Default" ;
			$oFCKeditor->Value = $section_content ;
			$oFCKeditor->Create() ;
		break;
	}
	?>
	</td>
  </tr>
  <tr style="background-color:#CCCCCC">
    <td>
	<div>
        <div class="info">
             <input type="image" src="images/edit.gif" style="width:20px;height:20px"  alt="edit this section"/>
             <span>
    	<?php
		echo 'Save changes to this section';
	?>
	</span> </div>
        <input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
        <input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
        <input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
        <input type="hidden" name="task" value="editmode"/>
        <input type="hidden" name="section_type" value="<?php echo $section_type;?>"/>

		<input type="hidden" name="subtask" value="edit"/></div>
    </form>
    </td>
	<td><input type="text" name="anchor" value="
<?php echo $section_anchor;?>" readonly="readonly" style="width:99%" onclick="javascript:this.select();" /></td>
	<td>
<form id="addbefore" method="post" action = "index.php">
<div>
<input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
<input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
<input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
<input type="hidden" name="task" value="editmode"/>
<input type="hidden" name="subtask" value="type"/>
<select name="section_type">
	<option value="html" <?php if($section_type=='html') echo "selected"?>>HTML
	<option value="wysiwyg_basic"  <?php if($section_type=='wysiwyg_basic') echo "selected"?>>Basic WYSIWYG
	<option value="wysiwyg_full"  <?php if($section_type=='wysiwyg_full') echo "selected"?>>Full WYSIWYG
	<option value="bbcode"  <?php if($section_type=='bbcode') echo "selected";?>>BBCode

</select>
	    <div class="info" a href="#">
<input type="image" src="images/edit.gif" style="width:20px;height:20px"  alt="edit this section"/>
    	<span>
            <?php
		echo 'Change sections type';
	?>
	</span> </div>
</div>
</form>

	</td>
	<td>
	<form id="addafter" method="post" action = "index.php">
	    <div><input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
	    <input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
	    <input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
	    <div class="info" a href="#">
            <input type="image" src="images/add.gif" style="width:20px;height:20px"  alt = "add a new section after the current one"/>
    	<span>
            <?php
		echo 'Add a new section after this one';
                	?>
	</span> </div>
	    <input type="hidden" name="subtask" value="addafter"/>
		<input type="hidden" name="task" value="editmode"/></div>
	</form>
    </td>
    <td>
    <form id="delete" method="post" action = "index.php" onclick="return confirm_entry('delete','section','<?php echo $page_id.'.'.$section_id;?>' )">
	   <div> <input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
	    <input type="hidden" name="section_id" value="<?php echo $section_id;?>"/>
	    <input type="hidden" name="section_order" value="<?php echo $section_order;?>"/>
	    <div class="info">
            <input type="image" src="images/delete.gif" style="width:20px;height:20px"  alt ="delete a section"/>
	        	<span>
            <?php
		echo 'Delete this section';
	?>
	</span> </div>
            <input type="hidden" name="subtask" value="delete"/>
		<input type="hidden" name="task" value="editmode"/></div>
	</form>
    </td>
  </tr>
</table>
<?php }


?>

<p>&nbsp;</p>
<p>&nbsp;</p>

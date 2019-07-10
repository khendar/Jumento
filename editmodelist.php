<?php
	$page_id = $_POST["page_id"];
	$task = $_POST["task"];
	$subtask = $_POST["subtask"];
	$page_order = $_POST["page_order"];
	//print_r($_POST);
	$currentuser = $_SESSION["username"];
	echo "<h3>Page Management</h3>";
	switch($subtask){
		case("addafter"):
			echo "<h4>Adding a new page</h4>";
			$makeroom = "
UPDATE pages SET page_order = page_order + 1 
			WHERE page_order > $page_order";

    		$makeroomresult = $linkID->query($makeroom);
			if ($msg = $linkID->error)
				echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
			$addnew = "
INSERT INTO pages (`page_order`, `page_title`, `page_description`, `page_keywords`,
			`user_created`, `date_created`,`user_modified`, `page_visibility`)
VALUES ($page_order+1, 'default title','default description','default keywords',
			'$currentuser', NOW() , '$currentuser','private')";

			$addnewresult = $linkID->query($addnew);
			if ($msg = $linkID->error)
				echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
		break;
		case("delete"):
		
			echo "<h4>Deleting page $page_id</h4>";
			$deletepage = "
DELETE FROM pages WHERE page_id=$page_id";

			$deleteresult = $linkID->query($deletepage);
			if ($msg = $linkID->error)
				echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
			$deletesections = "
DELETE FROM sections WHERE page_id=$page_id";
			$deleteresult = $linkID->query($deletesections) or die($linkID->error);
			$squeezeup = "
UPDATE pages SET page_order = page_order - 1 WHERE page_order > $page_order";
			$squeezeupresult = $linkID->query($squeezeup);
			if ($msg = $linkID->error)
				echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
    	break;
	}
	

	$getallquery = "
SELECT * FROM pages WHERE `parent_id`=0 ORDER BY `page_order` ASC";

	$getallresult = $linkID->query($getallquery);
	if ($msg = $linkID->error)
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
    	
	echo '<table style="width=100%;border:1px;padding:0px" cellspacing="0" class="output">';
	echo'
	<tr  style="padding:5px;font-size:90%;background-color:#ddddd">
		<th class="output">id</th>
   	 	<th class="output">name</th>
    	<th class="output"></th>
   		<th class="output"></th>
   		<th class="output"></th>
  		<th class="output"></th>		
		<th class="output"></th>
		<th class="output"></th>			
  	</tr>';

	for($i=0;$i<$getallresult->num_rows;$i++)
	{		
		$thispage = $getallresult->fetch_assoc();
		buildlist($thispage, $i);
	}
	echo '</table>';
	
function buildlist($thispage, $i)
{
		$page_id = $thispage["page_id"];
		$page_title = $thispage["page_title"];
		$page_order = $thispage["page_order"];
		$page_keywords = $thispage["page_keywords"];
		$page_description = $thispage["page_description"];
		$user_created = $thispage["user_created"];
		$user_modified = $thispage["user_modified"];
		$date_created = $thispage["date_created"];
		$date_modified = $thispage["date_modified"];
		$page_visibility = $thispage["page_visibility"];
?>

  <tr <?php if ($page_id == -1)echo 'style="background-color:#eee"';?>>
  <td><?php echo $page_id;?></td>
    <td>
	<?php
		echo $page_title; 
		if ($page_id == -1)echo '<span style="font-size:80%;"> [This page is reserved for the right side panel and cannot be deleted]</span>';?>
	</td>
    <td style="text-align:center ; padding:0px;">
		<form id="editpage_<?php echo $page_id;?>" method="post" action = "index.php">
	    	<div><input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
			<input type="hidden" name="task" value="editmode" />
			<input type="image" src="images/edit.gif" style="width:20px;height:20px" /></div>
		</form>
	</td>
    <td style="text-align:center ;padding:0px;">
	<?php if ($page_id != -1){?>
		<form id="addafter_<?php echo $page_id;?>" method="post" action = "index.php" >
	    	<div><input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
	    	<input type="hidden" name="page_order" value="<?php echo $page_order;?>" />
			<input type="hidden" name="task" value="editmodelist" />
			<input type="hidden" name="subtask" value="addafter" />
			<div class="info">
                        <input type="image" src="images/add.gif" style="width:20px;height:20px" />
		    	<span>
            <?php
		echo 'Add a new page after this one';
	?>
	</span> </div>
                </form>
	<?php }?>
	</td>
    <td style="text-align:center; padding:0px;">
	<?php if ($page_id != -1){?>
			<form id="delete_<?php echo $page_id;?>" method="post" action = "index.php"  onclick="return confirm_entry('delete','page','<?php echo $page_id;?>' )">
	    	<div><input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
	    	<input type="hidden" name="page_order" value="<?php echo $page_order;?>" />
			<input type="hidden" name="task" value="editmodelist" />
			<input type="hidden" name="subtask" value="delete" />
			<div class="info">
                        <input type="image" src="images/delete.gif" style="width:20px;height:20px" />
		    	<span>
            <?php
		echo 'Delete this page';
	?>
	</span> </div>
                </form>
	<?php }?>
	</td>
    <td style="text-align:center; padding:0px; ">
		<form id="moveup_<?php echo $page_id;?>" method="post" action = "index.php"  onclick="return confirm_entry('delete','page','<?php echo $page_id;?>' )">
	    	<div><input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
	    	<input type="hidden" name="page_order" value="<?php echo $page_order;?>" />
			<input type="hidden" name="task" value="editmodelist" />
			<input type="hidden" name="subtask" value="moveup" />
			<div class="info">
                        <input type="image" src="images/moveup.gif" style="width:20px;height:20px" />
		    	<span>
            <?php
		echo 'Move page up';
	?>
	</span> </div>
                </form>
	</td>
	    <td style="text-align:center; padding:0px; ">
		<form id="movedown_<?php echo $page_id;?>" method="post" action = "index.php"  onclick="return confirm_entry('delete','page','<?php echo $page_id;?>' )">
	    	<div><input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
	    	<input type="hidden" name="page_order" value="<?php echo $page_order;?>" />
			<input type="hidden" name="task" value="editmodelist" />
			<input type="hidden" name="subtask" value="movedown" />
		<div class="info">
                	<input type="image" src="images/movedown.gif" style="width:20px;height:20px" />
		    	<span>
            <?php
		echo 'Move Page down';
	?>
	</span> </div>
                </form>
	</td>
	<td style="text-align:center; padding:0px; ">
	<a class="info" href="#" ><img src="images/info.gif" alt="hover your mouse over this icon to see a summary of this pages properties" style="width:20px;height:20px;border:0px;" />
	<span>
	<?php
		echo 'Keywords: <strong>'.$page_keywords .'</strong><br/>';
		echo 'Description: <strong>'.$page_description.'</strong><br/>';
		echo 'Created by: <strong>'.$user_created.'</strong> on <strong>'.$date_created.'</strong><br/>';
		echo 'Modified by: <strong>'.$user_modified .'</strong> on <strong>' .$date_modified.'</strong><br/>';
		echo 'Visibility: <strong>'.$page_visibility.'</strong><br/>'
	?>
	</span>
	</a>
	</td>
  </tr>
<?php } 

?>

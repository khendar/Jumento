<?php
echo "<h3>Group Edit Mode</h3>";
	$getallquery = "SELECT * FROM `group_permissions`";
	$getallresult = $linkID->query($getallquery);
	echo '<table class="output" style="width:100%;padding:0px" cellspacing="0">';
	?>
	<tr style="padding:5px;font-size:90%;background-color:#dddddd">
		<th class="output" >id</th>
   	 	<th class="output" >Groupname</th>
    	<th class="output" >Groups</th>
   		<th class="output" >Users</th>
   		<th class="output" >Edit Pages</th>
    	<th class="output" >Pages</th>
    	<th class="output" >Configuration</th>
  	</tr>
	<?php
	for($i=0;$i<$getallresult->num_rows;$i++)
	{		
		$thisgroup = $getallresult->fetch_assoc();
		buildlist($thisgroup, $i);
	}
	echo '</table>';
	
function buildlist($thisgroup, $i)
{
		$group_id = $thisgroup["group_id"];
		$group_name = $thisgroup["group_name"];
		$groups = $thisgroup["groups"];
		$users =$thisgroup["users"];
		$edit_pages =$thisgroup["pages_edit"];
		$pages =$thisgroup["pages"];
		$configuration =$thisgroup["configuration"];
?>
  <tr <?php if($i%2)echo 'style="background-color:#eee"';?>>
    <td><?php echo $group_id;?></td>
    <td><?php echo $group_name;?></td>
    <td><?php echo $groups;?></td>
	<td><?php echo $users;?></td>
	<td><?php echo $edit_pages;?></td>
	<td><?php echo $pages;?></td>
	<td><?php echo $configuration;?></td>
  </tr>
<?php } ?>
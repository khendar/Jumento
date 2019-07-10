<?php
echo "<h3>User Edit Mode</h3>";
	$getallquery = "SELECT * FROM `users`, `group_permissions`, user_profiles where users.user_group = group_permissions.group_id and users.user_id = user_profiles.user_id ";

	$getallresult = $linkID->query($getallquery);
	$getgroups = '
	SELECT * FROM group_permissions';
	$getgroupsresult = $linkID->query($getgroups);
	if($msg = $linkID->error)
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
	
	echo '<table class="output" width="100%"  border="1" cellspacing="0" cellpadding="0">';
	?>
	<tr style="padding:5px;font-size:90%;background-color:#dddddd ">
		<th class="output">id</th>
   	 	<th class="output">Username</th>
    	<th class="output">Real Name</th>
   		<th class="output">User Group</th>
   		<th class="output"></th>
    	<th class="output"></th>
  	</tr>
	<?php

	for($i=0;$i<$getallresult->num_rows;$i++)
	{		
		$thisuser = $getallresult->fetch_assoc();
		buildlist($thisuser,$i, $getgroups);
	}
	echo '</table>';
	
function buildlist($thisuser,$i, $getgroups)
{
		$getgroupsresult = $linkID->query($getgroups);
		$user_id = $thisuser["user_id"];
		$user_name = $thisuser["user_name"];
		$real_name = $thisuser["real_name"];
		$user_group=$thisuser["user_group"];
		$user_avatar = $thisuser['user_avatar'];
		$date_joined = $thisuser['date_joined'];
		$date_last = $thisuser['date_last'];
		$ip_last = $thisuser['ip_last'];
		$online = $thisuser['online'];
		$banned = $thisuser['banned'];		

?>
  <tr <?php if($i%2)echo 'style="background-color:#eee"';?>>
    <td style="padding:5px"><?php echo $user_id;?></td>
    <td style="padding:5px"><?php echo $user_name;?></td>
    <td style="padding:5px"><?php echo $real_name;?></td>
	<td style="padding:5px"><?php buildgroups($getgroupsresult,$user_group);?></td>
    <td style="padding:5px"><input type="checkbox" name="banned" <?php if ($banned) echo 'checked="checked"';?>></td>
    <td style="padding:5px">
    <a class="info" href="#" ><img src="images/info.gif" alt="hover your mouse over this icon to see a summary of this 			user's statistics" style="width:20px;height:20px;border:0px;" />
	<span>
		<table style="border:0px; width:100%">
			<tr>
				
				<?php if($user_avatar!=NULL) 
				echo '<td>
					<img src="user_avatars/'.$user_avatar.'" 
					style="max-height:50px;max-width:50px">
					</td>';?>
		
				
				<td>
					Date Joined: <?php echo $date_joined;?><br/>
					Date Last: <?php echo $date_last;?><br/>
					Last IP: <?php echo $ip_last;?><br/>
					Online: <?php if($online) echo "yes"; else echo "no";?>
				</td>
			</tr>
		</table>
		

	</span>
	</a></td>
  </tr>
<?php } 

function buildgroups($result, $user_group)
{
echo '<select name="user_group">';

	for ($i=0;$i<$result->num_rows;$i++)
	{
		$group = $result->fetch_assoc();
		$group_id = $group['group_id'];
		$group_name = $group['group_name'];
//		print_r($group);
		echo "<option value=\"$group_id\"";
		if($group_id == $user_group)echo "selected=\"SELECTED\"";
		echo">$group_name\n";
	}
echo '</select>';
}
?>
<?php

echo "<h3>Configuration Mode</h3>";
$getconfig = '
SELECT * FROM `config`';
$getconfigresult = $linkID->query($getconfig);
if ($msg = $linkID->error)
	echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
	echo '<form id="changesettings" action="index.php" method="post">';
	echo '<table style="width:100%;padding:0px;" cellspacing="0"class="output">';
	echo'
	<tr  style="padding:5px;font-size:90%; background-color:#dddddd">
		<th class="output"></th>
   	 	<th class="output">Setting</th>
    	<th class="output">Value</th>
   		<th class="output">Description</th>
  	</tr>';
for($i=0;$i<$getconfigresult->num_rows;$i++)
{
	$setting = $getconfigresult->fetch_assoc();	
	buildlist($setting, $i);
}
	echo '</table>';
	echo '</form>';
function buildlist($thissetting, $i)
{
		$setting_id = $thissetting["setting_id"];
		$setting_name = $thissetting['setting_name'];
		$setting_value = $thissetting['setting_value'];
		$setting_description = $thissetting['setting_description'];
?>
	<tr <?php if($i%2)echo 'style="background-color:#eee"';?>>
  		<td><?php echo $setting_id;?></td>
    	<td>
			<?php echo $setting_name;?>
		</td>
    	<td >
			<input type="text" name="<?php echo $setting_name;?>" value="<?php echo $setting_value;?>" style="width:98%"/>
		</td>
    	<td style="text-align:center ;padding:0px;">
			<a class="info" href="#"><img src="images/info.gif" style="width:20px;height:20" alt="Click to get information about this setting" />
				<span>
					<?php echo $setting_description	?>
				</span>
			</a>
		</td>
  	</tr>
<?php } 
	

?>

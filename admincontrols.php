<div id="admincontrols">
<div class="admincontrolsheader">
Administration Controls
</div>

<?php

$keepalive = 'update user_profiles set date_last = NOW() where user_id = '.$_SESSION['user_id'];
$resultID = mysql_query($keepalive, $linkID);
if ($msg = mysql_error())
	echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $keepalive . '</pre><br /> (caused: ' . $msg .')';


$user_group = $_SESSION["user_group"];
$getpermissions = '
SELECT * FROM `group_permissions`
WHERE `group_id` = '.$user_group;

$resultID = mysql_query($getpermissions, $linkID);
if ($msg = mysql_error())
	echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $getpermissions . '</pre><br /> (caused: ' . $msg .')';

$permissions = mysql_fetch_array($resultID);
if($permissions['pages_edit'])
{
echo "<form id=\"editthispageform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"page_id\" value=\"$current\" />
		<input type=\"hidden\" name=\"task\" value=\"editmode\" />
		<input type=\"submit\" name=\"edit\" value=\"Edit This Page\" class=\"button\" /></div>
		</form>";
}
if($permissions['pages'])
{
echo "<form id=\"editmodeform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"editmode\" />
		<input type=\"submit\" name=\"editmode\" value=\"Manage Pages\" class=\"button\" /></div>
		</form>";
}
if($permissions['users'])
{
echo "<form id=\"editusersform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"edituser\" />
		<input type=\"submit\" name=\"edit\" value=\"Manage Users\" class=\"button\" /></div>
		</form>";
}
if($permissions['pages'])
{
echo "<form id=\"editcaaform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"editcss\" />
		<input type=\"submit\" name=\"edit\" value=\"Edit CSS\" class=\"button\" /></div>
		</form>";
}
if($permissions['groups'])
{
echo "<form id=\"editgroupform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"editgroup\" />
		<input type=\"submit\" name=\"groupedit\" value=\"Manage Groups\" class=\"button\" /></div>
		</form>";
}
echo "<form id=\"userprofileform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"editprofile\" />
		<input type=\"hidden\" name=\"user_id\" value=\"$_SESSION[user_id]\" />
		<input type=\"submit\" name=\"profileedit\" value=\"Edit My Profile\" class=\"button\" /></div>
		</form>";
echo "<form name=\"logoutform\" action=\"index.php\" method=\"post\" >
		<div><input type=\"hidden\" name=\"task\" value=\"logout\" />
		<input type=\"submit\" name=\"logout\" value=\"Logout\" class=\"button\" /></div>
		</form>";

?>
</div>
<!--<input  style="border:0px;background:none;width:1px;height:1px" type="button" id="show" accesskey="o" onclick="MM_showHideLayers('admincontrols','','show')">
<input  style="border:0px;background:none;width:1px;height:1px" type="button" id="hide" accesskey="p" onclick="MM_showHideLayers('admincontrols','','hide')">-->
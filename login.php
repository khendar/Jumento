<?php
include ("db.php");
if (!isset($_POST['login']))
{
	printloginform();
}
else
{
	$username=$_POST["username"];
	$password=$_POST["password"];


	$loginquery = 'SELECT * FROM users, user_profiles WHERE user_name = \''.$username.'\' AND users.user_id = user_profiles.user_id';
	$resultid = $linkID->query($loginquery);
	if ($msg = $linkID->error)
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';

	if($resultid->num_rows!=0)
	{
	    $user = $resultid->fetch_assoc();

	    if($password == $user["password"])
	    {
			//$user = mysql_fetch_array($resultid);
			echo "<em>Logged in as $username</em>";
			$login = '
UPDATE `user_profiles` SET `online` = 1, `date_last` = NOW(), `ip_last` = \'' . $_SERVER['REMOTE_ADDR'] . '\' WHERE `user_id` = '.$user['user_id'];
//echo $login;

			$resultid = $linkID->query($login);
			if ($msg = $linkID->error)
				echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';


			$_SESSION["user"] = $user;
			$_SESSION["username"]=$username;
			$_SESSION["user_id"] = $user['user_id'];
			$_SESSION["user_group"] = $user["user_group"];
			//echo $_SERVER['REMOTE_ADDR'];
			
			include("admincontrols.php");
	    }
	    else
	    {
		echo "Login incorrect - wrong password";
		printloginform();
	    }	
	}
	else
	{
		echo "Login incorrect - No such user";
		printloginform();
	}
}
	
function printloginform()
{?>
<div id="login">
	<form name="loginform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class ="button">
		<div>*Username:<br/>
		<input name="username" type="text" size="20" maxlength="20" 
			value="<?php echo $username;?>" style="width:99%"/><br/>
		*Password:<br/>
		<input name="password" type="password" id="password" size="20" maxlength="20" style="width:99%"/><br/>
		<input name="login" type="submit" id="login" value="Login" class="button"/><br/></div>
    	</form>
	<form name="registerform" action="index.php" method="post" class="button"><div>
		<input type='hidden' name='task' value='register' />
		<input type="submit" name="register" value="Register" class="button" /><br/></div>
	</form>
</div>
<?php }

?> 
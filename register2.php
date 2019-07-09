<?php
if (!isset($_POST['submit']))
{
	printform();
}
else
{
	$user_name=$_POST["user_name"];
	$real_name = $_POST["real_name"];
	echo $username;
	$password=$_POST["password"];
	$confirm=$_POST["confirm"];
	if ($password != $confirm)
	{
		echo "Password mismatch - Please re-enter your password<br>";
		printform();
	}
	else
	{
		include("db.php");
		//$encryptedpw = md5($password);
		$checkuserquery = "SELECT user_id FROM users WHERE user_name = \"$user_name\"";
		$resultid = mysql_query($checkuserquery, $linkID);
		if(mysql_num_rows($resultid)!= 0) 
		{
			echo "Sorry this username is taken - Try again<br>";
			printform();
		}
		else
		{
			//if (!strpos($email, "@") || !strpos($email, "."))
			//{
				//echo "You have not entered a valid email address - Please try again";
				//printform();
			//}
			//else
			//{
				//echo "You have entered a (seemingly) good email address<br>";
				adduser($user_name, $real_name,$password,$linkID) ;
			//}
		}
	}
}
	
function printform()
{?>
<form name="registerform" method="post" action="index.php" style="button">
<input type="hidden" name="task" value="register" />
  <table width="56%"  border="0">
      <tr>
      <td width="32%">*Username:</td>
      <td width="68%"><input name="user_name" type="text" size	="50" maxlength="20" value="<?php echo $user_name;?>"></td>
    </tr>
    <tr>
    <tr>
      <td width="32%">*Real Name:</td>
      <td width="68%"><input name="real_name" type="text" size="50" maxlength="20" value="<?php echo $real_name;?>"></td>
    </tr>
    <tr>
      <td>*Password:</td>
      <td><input name="password" type="password" id="password" size="50" maxlength="20" ></td>
    </tr>
    <tr>
      <td>*Confirm Password : </td>
      <td><input name="confirm" type="password" id="confirm" size="50" maxlength="20"></td>
    </tr>
	<tr>
      <td></td>
      <td><input type="submit" name="submit" value="submit" class="button"></td>
    </tr>
  </table>
</form><?php }

function adduser($user_name, $real_name,$password,$linkID)
{
	$addquery = "INSERT INTO users ( user_name, real_name, password)
				VALUES ('$user_name', '$real_name', '$password')";
				//echo $addquery;
	$resultid = mysql_query($addquery, $linkID) or die(mysql_error());
	$getlast = 'select user_id from users order by user_id desc';
	$resultid = mysql_query($getlast, $linkID) or die(mysql_error());
	$lastuser = mysql_fetch_array($resultid);
	$u_id = $lastuser['user_id'];
	$addprofile = "insert into user_profiles (user_id, date_joined) values ('$u_id', NOW())";
	$resultid = mysql_query($addprofile, $linkID) or die(mysql_error());
	echo 'Thankyou for signing up - Have Fun! =D';
	
}?>

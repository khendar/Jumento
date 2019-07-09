<?php
include("nav.php");

if(!isset($_SESSION["username"]))
{
	include("login.php");
}
else
{
include("admincontrols.php");
}


?>
<?php session_start();
include("db.php");
ini_set('arg_separator.output','&amp;');
error_reporting(0);
$pageid = $_GET["l"];

$_SESSION["theme"]=$_POST["theme"];
if($_POST["theme"]=="" && $_SESSION["theme"] == "") 
{
$_POST["theme"]="cyberia";
$_SESSION["theme"] = $_POST["theme"];
}	


if($pageid==""){
	$getfirst = "
SELECT `page_id` FROM `pages` WHERE  `page_id`>0 AND `page_visibility`='public'";
	$getfirstpageresult  = mysql_query($getfirst, $linkID);
	if ($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
  	$firstpage = mysql_fetch_array($getfirstpageresult);
	$pageid=$firstpage['page_id'];

}
$task = $_REQUEST["task"];
	//echo $task;
if($task =="")
{
	$getpage = "
SELECT * FROM pages, sections 
WHERE sections.page_id=$pageid AND sections.page_id = pages.page_id
ORDER BY section_order ASC";
	
	$getpageresult  = mysql_query($getpage, $linkID);
	if ($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
    $sectioncount = mysql_num_rows($getpageresult);
	if($sectioncount!=0)
	{
		for($i=0;$i<$sectioncount;$i++)
		{
	    	$page = mysql_fetch_array($getpageresult);
	    	$pagecontents .= '<br/>'.stripslashes($page["section_content"]);
			if($_SESSION['username']!="")
			{
				//$pagecontents .='<div style="text-align:right"><img src = "images/edit.gif" width=30 height=30 /></div>';
			}
		}
	}
	else
	{
	   	$page = mysql_fetch_array($getpageresult);
		$getpage = "
SELECT * FROM pages 
WHERE pages.page_id=$pageid";
	
	$getpageresult  = mysql_query($getpage, $linkID);
	if ($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
		$page = mysql_fetch_array($getpageresult);
	}

	$pagetitle = stripslashes($page["page_title"]);
	$pagedescription = htmlentities(stripslashes($page["page_description"]));
	$pagekeywords = htmlentities(stripslashes($page["page_keywords"]));
}
else
{
    $pagetitle = $_REQUEST["task"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/2001/REC-xhtml11-20010531/DTD/xhtml11-flat.dtd">
<html xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="description" content="<?php echo $pagedescription;?>" />
		<meta name="keywords" content="<?php echo $pagekeywords;?>" />
		<style type="text/css"><!-- 
			<?php 
				$theme = 'lab';
				echo "@import \"jumento.css\";";
			?> 
		--></style>
		<link rel="stylesheet" href="skidoo_too_print.css" type="text/css" media="print" />
		<script type="text/javascript" src="javascript/ruthsarian_utilities.js"></script>
		<script type="text/javascript">
		<!--
			var font_sizes = new Array( 100, 110, 120 ); 
			var current_font_size = 0;
 			if ( ( typeof( NN_reloadPage ) ).toLowerCase() != 'undefined' ) { NN_reloadPage( true ); }
			if ( ( typeof( opacity_init  ) ).toLowerCase() != 'undefined' ) { opacity_init(); }
			if ( ( typeof( set_min_width ) ).toLowerCase() != 'undefined' ) { set_min_width( 'pageWrapper' , 600 ); }
			if ( ( typeof( loadFontSize ) ).toLowerCase() != 'undefined' ) { event_attach( 'onload' , loadFontSize ); }
		//-->
		</script>
		<script  type="text/javascript" src="javascript/cyberia_utilities.js"></script>
		<title>[Jumento] : [<?php echo $pagetitle;?>]</title>
	</head>
	<body>
		<div id="pageWrapper">
			<div id="masthead" class="inside">

<!-- masthead content begin -->

	

<!-- masthead content end -->

				<hr class="hide" />
			</div>
			<div class="hnav">

<!--
	you must preserve the (lack of) whitespace between elements when creating 
	your own horizontal navigation elements, otherwise the extra whitespace 
	will break the visual layout. although how it breaks (tiny spaces between 
	each element) is an effect that some may desire.
-->
<?php include("nav.php");?>
<!-- horizontal nav end -->

				<hr class="hide" />
			</div>
			<div id="outerColumnContainer">
				<div id="innerColumnContainer">
					<div id="SOWrap">
						<div id="middleColumn">
							<div class="inside">

<!--- middle (main content) column begin -->


<?php
if($task=='')
	echo $pagecontents;
else
{
	include($task.'.php');
	$_SESSION['task'] = $task;
}


?>

<!--- middle (main content) column end -->

								<hr class="hide" />
							</div>
						</div>
						<div id="leftColumn">
							<div class="inside">

<!--- left column begin -->

<div class="vnav">

<?php
include("map.php");
?>
</div>
<div style="width:100%">
<?php //include("jax_calendar/jax_calendar.php"); ?>
</div>

<script type="text/javascript">
<!--
	var browser = new browser_detect();
	if ( browser.versionMajor > 4 || !( browser.isIE || browser.isNS ) )
	{
		/* only offer style/font changing to version 5 and later browsers
		 * which have javascript enabled. curiously, if you print this out
		 * in NS4, NS4 breaks for some reason. 
		 */
		document.write('									\
			<p class="fontsize-set">							\
				<a href="#" onclick="setFontSize(0); return false;"			\
					><img src="images/font_small.gif" width="17" height="21"	\
						alt="Small Font" title="Small Font"			\
				/><\/a>									\
				<a href="#" onclick="setFontSize(1); return false;"			\
					><img src="images/font_medium.gif" width="17" height="21" 	\
						alt="Medium Font" title="Medium Font"			\
				/><\/a>									\
				<a href="#" onclick="setFontSize(2); return false;"			\
					><img src="images/font_large.gif" width="17" height="21"	\
						alt="Large Font" title="Large Font"			\
				/><\/a>									\
			<\/p>										\
		');
	}
//-->
</script>

<!--- left column end -->

								<hr class="hide" />
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="rightColumn">
						<div class="inside">

<!--- right column begin -->
<?php 
$getside = "SELECT * FROM pages, sections
WHERE pages.page_id = -1
AND pages.page_id = sections.page_id
ORDER BY sections.section_order ASC ";
$getsideresult = mysql_query($getside, $linkID);
	if ($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $addnew . '</pre><br /> (caused: ' . $msg . ')';
 
for($i=0;$i<mysql_num_rows($getsideresult);$i++)
{
	$side_section = mysql_fetch_array($getsideresult);
	$side_content .= $side_section["section_content"];
}
echo $side_content;

$getonline ='
SELECT user_name
FROM `users` , `user_profiles`
WHERE users.user_id = user_profiles.user_id
AND date_sub( now( ) , INTERVAL 5
MINUTE ) <= user_profiles.date_last';
$getonlineresult = mysql_query($getonline, $linkID);
	if ($msg = mysql_error())
		echo __LINE__ . ' of ' . __FILE__ . '<pre>' . $getonline . '</pre><br /> (caused: ' . $msg . ')';
$onlinecount = mysql_num_rows($getonlineresult);
if($onlinecount !=0)
{
	echo $onlinecount .' user';if($onlinecount>1) echo 's'; echo' online <br/>[ ';
	for($i=0;$i<$onlinecount;$i++)
	{
		$user = mysql_fetch_array($getonlineresult);
		echo $user['user_name'];
		if($i!=$onlinecount-1) echo ', ';		
	}
	echo ' ]';
}


$prefix='http://validator.w3.org/check?uri=';
$validate= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($task) $validate .= '?task='.$task.'&amp;page_id='.$current;
//echo $validate;
$suffix.='&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;ss=1';
$link  = $prefix.str_replace('&','&amp;',urlencode($validate)).$suffix;
//echo '<a href="'.$link.'">asd</a>';
?>
	<p>
	<a target="_blank" href="http://www.php.net">
		<img style="padding: 1px;" src="images/php.gif" alt="PHP" />
	</a> 
	<a target="_blank" href="http://validator.w3.org/check?uri=referer">
	<img style="padding: 1px;" src="images/xhtml10.png" alt="XHTML" />
	</a>
	<a target="_blank" href="http://jigsaw.w3.org/css-validator/">
	<img style="padding: 1px;" src="images/css.png" alt="CSS2" />
	</a>
	</p> 
 <p>
<--    <a href="<?php echo $link;?>"><img
        src="http://www.w3.org/Icons/valid-xhtml11"
        alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>-->

<!--- right column end -->

							<hr class="hide" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div id="footer" class="inside">

<!-- footer begin -->

<p style="margin:0;">
<?php 
if($_SESSION['username']!=NULL){
	//echo "<em>";
	//echo "<em>Logged in as $_SESSION[username]</em>";
	//echo "</em>";
	}
//print_r($_SESSION);
?>
	&copy; <a href="http://timparkinson.net">Tim Parkinson</a> 2006-2007 
</p>

<!-- footer end -->

				<hr class="hide" />
			</div>
		</div>
	</body>
</html>
<h3>CSS Editor</h3>
<p>
This will not actually affect the sites style. In order to avoid people breaking 
the site - this is editing a different style sheet</p>

<?php

//echo '<pre>';print_r($_POST);echo '</pre>';
if($_POST["subtask"]=="editcss")
{
	echo '<h4>Saving changes</h4>';
	$fh = fopen("jumento2.css", "r+");
	if(!$fh) echo "error - Failed to write - probably permissions";
	$css = $_POST['css'];
	if(!fwrite($fh, $css))
		echo 'error - Failed to write - probably permissions';
	else echo 'Write successful <br><a href="jumento2.css">View</a>';
	fclose($fh);

}
else
{

	$fh = fopen("jumento2.css", "r+");
	if(!$fh) echo "error";

	if ($fh) {
	   while (!feof($fh)) {
	       $buffer .= fgets($fh, 4096);
	       //echo $buffer;
	   }

	   echo '
	   <form id="editcss" method="post" action="index.php">
	   <input  type="hidden" name="task" value="editcss" />
	   <input  type="hidden" name="subtask" value="editcss" />

           <textarea name="css" style="width:100%;height:100" rows="20">'.$buffer.'</textarea>
	   <input type="submit" value="edit" name="edit" class="button" />
	   </form>
	   ';
	   fclose($fh);
	}
}
?>
      <br/>
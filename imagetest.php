<?php
function imageResize($src, $target) {
$mysock = getimagesize("images/add.gif");
$width=$mysock[0];
$height=$mysock[1];
if ($width > $height)
{
   $percentage = ($target / $width);
}
else
{
$percentage = ($target / $height);
}
//gets the new value and applies the percentage, then rounds the value
$width = round($width * $percentage);
$height = round($height * $percentage);
echo "<img src=\"$src\" width=\"$width\" height=\"$height\">";
}
?>
<?php imageResize("images/add.gif", 25   ); ?>

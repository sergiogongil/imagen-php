<?php /* versión básica */
$img = imagecreatefromjpeg($_GET["n"]);
header("Content-type: image/jpeg");
imagejpeg($img);
imagedestroy($img);
?>

<?php

/*
$anchura = $_GET["ancho"];
$hmax = $_GET["alto"];
$nombre = $_GET['imagen'];
*/

$anchura = 600;
$hmax = 400;
$nombre = "n91492ll45n";  //$nombre = "imagen";

$datos = getimagesize($nombre);

if($datos[2]==2){
$img = @imagecreatefromjpeg($nombre);
}
$ratio = ($datos[0] / $anchura);
$altura = ($datos[1] / $ratio);

if($altura>$hmax){
$anchura2=$hmax*$anchura/$altura;
$altura=$hmax;
$anchura=$anchura2;
}

$thumb = imagecreatetruecolor($anchura,$altura);
imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);

header("Content-type: image/jpeg");
imagejpeg($thumb);

imagedestroy($thumb);
 
 



?>

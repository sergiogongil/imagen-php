<?php
class imagen {
var $nombre;
   public function __construct($nombre){
       $this->ancho = 600;
       $this->altmax = 400;
       $this->nombre = $nombre;
   }
   
   
   
   
   public function imageJpg(){
          $datos = getimagesize($this->nombre);

          if($datos[2]==2){ $img = @imagecreatefromjpeg($this->nombre); }
             $ratio = ($datos[0] / $this->ancho);
             $this->altmax = ($datos[1] / $ratio);

             if($this->altmax>$this->altmax){
                $anchura2=$this->altmax*$this->ancho/$this->altmax;
                $this->altmax=$this->altmax;
                $this->ancho=$anchura2;
             }

$thumb = imagecreatetruecolor($this->ancho,$this->altmax);
imagecopyresampled($thumb, $img, 0, 0, 0, 0, $this->ancho, $this->altmax, $datos[0], $datos[1]);
header("Content-type: image/jpeg");
imagejpeg($thumb);
imagedestroy($thumb);

}





 
}
//$imagen = new imagen("sinextension");
$imagen = new imagen("imagen.jpg");
$imagen -> imageJpg();
?>

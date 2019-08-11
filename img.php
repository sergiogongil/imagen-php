<?php
class imagen {

   public function __construct(){
          if(isset($_GET["x"])){ $this->ancho = $_GET["x"]; }else{ $this->ancho = 600; }
          if(isset($_GET["y"])){ $this->altmax = $_GET["y"]; }else{ $this->altmax = 400; }
          if(isset($_GET["n"])){ $this->nombre = $_GET["n"]; }else{ $this->nombre = "imagen.jpg"; }
          if(!is_file($this->nombre)){ $this->nombre = "default.jpg"; }
   }
   
   public function imageJpg(){
          $datos = getimagesize($this->nombre);

          if($datos[2]==2){ $img = @imagecreatefromjpeg($this->nombre); }
             $ratio = ($datos[0] / $this->ancho);
             $this->altmax = ($datos[1] / $ratio);

             if($this->altmax>$this->altmax){
                $ancho=$this->altmax*$this->ancho/$this->altmax;
                $this->altmax=$this->altmax;
                $this->ancho=$ancho;
             }

$thumb = imagecreatetruecolor($this->ancho,$this->altmax);
imagecopyresampled($thumb, $img, 0, 0, 0, 0, $this->ancho, $this->altmax, $datos[0], $datos[1]);
header("Content-type: image/jpeg");
imagejpeg($thumb);
imagedestroy($thumb);
}

 
}
$imagen = new imagen();
$imagen -> imageJpg();
?>

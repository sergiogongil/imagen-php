<?php /* https://github.com/sergiogongil - MIT License - Copyright (c) 2019 SergioGG */
class imagen {

   public function __construct(){
          if(isset($_GET["x"])){ $this->ancho = $_GET["x"]; }else{ $this->ancho = 600; }
          if(isset($_GET["y"])){ $this->altmax = $_GET["y"]; }else{ $this->altmax = 400; }
          if(isset($_GET["n"])){ $this->nombre = $_GET["n"]; }else{ $this->nombre = ""; }
          if(!file_exists($this->nombre)){ $this->nombre = "data/default.jpg"; }
   }
   
   public function mostrar(){
          $datos = getimagesize($this->nombre);
          $formato = $datos["mime"];
                if($formato == "image/jpg"){        $img = @imagecreatefromjpeg($this->nombre);
                }elseif($formato == "image/png"){   $img = @imagecreatefrompng($this->nombre);
                }elseif($formato == "image/gif"){   $img = @imagecreatefromgif($this->nombre);
                }elseif($formato == "image/bmp"){   $img = @imagecreatefrombmp($this->nombre);
                }elseif($formato == "image/jpeg"){  $img = @imagecreatefromjpeg($this->nombre);
                }else{                              $img = @imagecreatefromjpeg($this->nombre); }

             $ratio = ($datos[0] / $this->ancho);
             $altmax = ($datos[1] / $ratio);

             if($altmax>$this->altmax){
                $ancho=$this->altmax*$this->ancho/$this->altmax;
                $this->altmax=$altmax;
                $this->ancho=$ancho;
             }

$thumb = imagecreatetruecolor($this->ancho,$this->altmax);
imagecopyresampled($thumb, $img, 0, 0, 0, 0, $this->ancho, $this->altmax, $datos[0], $datos[1]);
header("Content-type: $formato");
if($formato == "image/jpg"){          imagejpeg($thumb);
}elseif($formato == "image/png"){     imagepng($thumb);
}elseif($formato == "image/gif"){     imagegif($thumb);
}elseif($formato == "image/bmp"){     imagebmp($thumb);
}elseif($formato == "image/jpeg"){    imagejpeg($thumb);
}else{                                imagejpeg($thumb); }
imagedestroy($thumb);
}

}
$imagen = new imagen();
$imagen -> mostrar();
?>

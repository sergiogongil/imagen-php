<?php /* https://github.com/sergiogongil - MIT License - Copyright (c) 2019 SergioGG */
class imagen {
   public function __construct(){                              /* Definidos un ancho y alto máximos */
          if(isset($_GET["x"]) AND is_numeric($_GET["x"])){ if($_GET["x"]>1280){ $this->ancho = 1280; }else{ $this->ancho = $_GET["x"]; }}else{ $this->ancho = 600; }
          if(isset($_GET["y"]) AND is_numeric($_GET["y"])){ if($_GET["y"]>1024){ $this->altmax = 1024; }else{ $this->altmax = $_GET["y"]; }}else{ $this->altmax = 400; }
          if(isset($_GET["n"])){ $this->nombre = strip_tags($_GET["n"]); }else{ $this->nombre = ""; }
          if(!file_exists($this->nombre)){ $this->nombre = "data/default.jpg"; }
   }

   public function mostrar(){
          $datos = getimagesize($this->nombre);     /* Obtener el tamaño de una imagen */
          $formato = $datos["mime"];                /* Crea una nueva imagen a partir de un fichero o de una URL */
                if($formato == "image/jpg"){        $img = @imagecreatefromjpeg($this->nombre);
                }elseif($formato == "image/png"){   $img = @imagecreatefrompng($this->nombre);
                }elseif($formato == "image/gif"){   $img = @imagecreatefromgif($this->nombre);
                }elseif($formato == "image/bmp"){   $img = @imagecreatefrombmp($this->nombre);
                }elseif($formato == "image/jpeg"){  $img = @imagecreatefromjpeg($this->nombre);
                }else{                              $img = @imagecreatefromjpeg($this->nombre); }

             /* Calculamos y ajustamos las proporciones de la imagen */
          $ancho = $datos["0"]; $alto = $datos["1"];
          $x_ratio = $this->ancho / $ancho;
          $y_ratio = $this->altmax / $alto;
          if( ($ancho <= $this->ancho) && ($alto <= $this->altmax) ){ $ancho_final = $ancho; $alto_final = $alto; }
	      elseif (($x_ratio * $alto) < $this->altmax){ $alto_final = ceil($x_ratio * $alto); $ancho_final = $this->ancho; }
	      else{ $ancho_final = ceil($y_ratio * $ancho); $alto_final = $this->altmax; }

         /* Crear una nueva imagen de color verdadero */
         $thumb = imagecreatetruecolor($ancho_final,$alto_final);
         /* Copia y cambia el tamaño de parte de una imagen redimensionándola */
         imagecopyresampled($thumb, $img, 0, 0, 0, 0, $ancho_final, $alto_final, $datos[0], $datos[1]);
if(isset($_GET["nt"])){  /* Filtro de Imagen en negativo */ imagefilter($thumb, IMG_FILTER_NEGATE);}
if(isset($_GET["b"])){  /* Imagen en Blanco y Negro */ imagefilter($thumb, IMG_FILTER_GRAYSCALE); }
if(isset($_GET["t"])){  /* Texto en imagen */ $t = strip_tags($_GET["t"]); imagestring($thumb, 3, 40, 20, $t, 0xFFBA00); }
if(isset($_GET["m"])){  /* Marca de agua */ $estampa = imagecreatefrompng('data/estampa.png');
/* Copiar parte de una imagen */
imagecopy($thumb, $estampa, imagesx($thumb) - imagesx($estampa) - 25, imagesy($thumb) - imagesy($estampa) - 25, 0, 0, imagesx($estampa), imagesy($estampa)); }

/* Enviar encabezado */
header("Content-type: $formato");   /* Exportar la imagen al navegador o a un fichero */
if($formato == "image/jpg"){          imagejpeg($thumb);
}elseif($formato == "image/png"){     imagepng($thumb);
}elseif($formato == "image/gif"){     imagegif($thumb);
}elseif($formato == "image/bmp"){     imagebmp($thumb);
}elseif($formato == "image/jpeg"){    imagejpeg($thumb);
}else{                                imagejpeg($thumb); }
imagedestroy($thumb); /* Destruir una imagen */
}

}
$imagen = new imagen();
$imagen -> mostrar();
?>

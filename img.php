<?php /* https://github.com/sergiogongil - MIT License - Copyright (c) 2019 SergioGG */
class imagen {
   public function __construct(){                              /* Definidos un ancho y alto máximos */
          if(isset($_GET["x"]) AND is_numeric($_GET["x"])){ if($_GET["x"]>1280){ $this->ancho = 1280; }else{ $this->ancho = $_GET["x"]; }}else{ $this->ancho = 600; }
          if(isset($_GET["y"]) AND is_numeric($_GET["y"])){ if($_GET["y"]>1024){ $this->altmax = 1024; }else{ $this->altmax = $_GET["y"]; }}else{ $this->altmax = 400; }
          if(isset($_GET["n"])){ $this->nombre = strip_tags($_GET["n"]); }else{ $this->nombre = ""; }
          if(isset($_GET["f"]) AND is_numeric($_GET["f"])){ $this->filtro = $_GET["f"]; }else{ $this->filtro = false; }
          if(!file_exists($this->nombre)){ $this->nombre = "data/default.jpg"; }
   }

   public function mostrar(){
          $datos = getimagesize($this->nombre);     /* Obtener el tamaño de una imagen */
          $formato = $datos["mime"];                /* Crea una nueva imagen a partir de un fichero o de una URL */
                if($formato == "image/jpg"){        $img = imagecreatefromjpeg($this->nombre);
                }elseif($formato == "image/png"){   $img = imagecreatefrompng($this->nombre);
                }elseif($formato == "image/gif"){   $img = imagecreatefromgif($this->nombre);
                }elseif($formato == "image/bmp"){   $img = imagecreatefrombmp($this->nombre);
                }elseif($formato == "image/jpeg"){  $img = imagecreatefromjpeg($this->nombre);
                }else{                              $img = imagecreatefromjpeg($this->nombre); }

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
         
         /* Fondo transparente */
         if($formato == "image/png" OR $formato == "image/gif"){ imagefill($thumb, 0, 0, imagecolorallocatealpha($thumb, 255, 255, 255, 127)); /*imagealphablending($thumb, false); imagesavealpha($thumb, true);*/ }
 
         switch ($this->filtro) {
              case 1:  imagefilter($thumb, IMG_FILTER_NEGATE);                     break; /* Invierte todos los colores de la imagen. */
              case 2:  imagefilter($thumb, IMG_FILTER_GRAYSCALE);                  break; /* Convierte la imagen a escala de grises. */
              case 3:  imagefilter($thumb, IMG_FILTER_BRIGHTNESS, 80);             break; /* Cambia el brillo de la imagen. Use arg1 para establecer el nivel de brillo. El rango para el brillo es de -255 a 255. */
              case 4:  imagefilter($thumb, IMG_FILTER_CONTRAST, 40);               break; /* Cambia el contraste de la imagen. Use arg1 para establecer el nivel de contraste. */
              case 5:  imagefilter($thumb, IMG_FILTER_COLORIZE, 0, 255, 0, 127);   break; /* Como IMG_FILTER_GRAYSCALE, excepto que se puede especificar el color. Use arg1, arg2 y arg3 en la forma red, green, blue y arg4 para el canal alpha. El rango de cada color es de 0 a 255. */
              case 6:  imagefilter($thumb, IMG_FILTER_EDGEDETECT);                 break; /* Utiliza detección de borde para resaltar los bordes de la imagen. */
              case 7:  imagefilter($thumb, IMG_FILTER_EMBOSS);                     break; /* Pone en relieve la imagen. */
              case 8:  imagefilter($thumb, IMG_FILTER_GAUSSIAN_BLUR);              break; /* Pone borrosa la imagen usando el método Gaussiano. */
              case 9:  imagefilter($thumb, IMG_FILTER_SELECTIVE_BLUR);             break; /* Pone borrosa la imagen. */
              case 10: imagefilter($thumb, IMG_FILTER_MEAN_REMOVAL);               break; /* Utiliza eliminación media para lograr un efecto "superficial". */
              case 11: imagefilter($thumb, IMG_FILTER_SMOOTH, 10);                 break; /* Suaviza la imagen. Use arg1 para esteblecer el nivel de suavidad. */
              case 12: imagefilter($thumb, IMG_FILTER_PIXELATE, 10, 1);            break; /* Aplica el efecto de pixelación a la imagen, use arg1 para establecer el tamaño de bloque y arg2 para establecer el modo de efecto de pixelación. */
              //case 13: imagefilter($thumb, IMG_FILTER_SCATTER, 3, 5);              break; /* Aplique un efecto de dispersión muy suave a la imagen. */
              default: break;
         }

if(isset($_GET["t"])){  /* Texto en imagen */ $t = strip_tags($_GET["t"]); imagestring($thumb, 3, 20, 20, $t, 0xFFBA00); }
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

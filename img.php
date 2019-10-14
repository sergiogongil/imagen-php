<?php /* https://github.com/sergiogongil - MIT License - Copyright (c) 2019 SergioGG */
class imagen {
   public function __construct(){
   
          $this->ruta = "data";

          $this->imgDefault = $this->ruta."/default.jpg";

          $this->estampa = $this->ruta."/estampa.png";
          
          $this->bgcaptcha = $this->ruta."/bgcaptcha.gif";
          
          $this->ancho = 600; /* Ancho Default */
          
          $this->altmax = 400; /* Alto Default */
          
          $this->colorText = array ("255","255","255");
          
          $this->background = array ("255","255","255");
          
          
                                                                     /* Definidos un ancho y alto máximos */
          if(isset($_GET["x"]) AND is_numeric($_GET["x"])){ if($_GET["x"]>1280){ $this->ancho = 1280; }else{ $this->ancho = $_GET["x"]; }}//else{ $this->ancho = 600; }
          if(isset($_GET["y"]) AND is_numeric($_GET["y"])){ if($_GET["y"]>1024){ $this->altmax = 1024; }else{ $this->altmax = $_GET["y"]; }}//else{ $this->altmax = 400; }
          if(isset($_GET["f"]) AND is_numeric($_GET["f"])){ $this->filtro = $_GET["f"]; }else{ $this->filtro = false; }
          if(isset($_GET["e"]) AND is_numeric($_GET["e"])){ $this->efecto = $_GET["e"]; }else{ $this->efecto = false; }
          //if(isset($_GET["n"])){ $this->nombre = strip_tags($_GET["n"]); }else{ $this->nombre = ""; }
          //if(isset($_GET["t"])){ $this->texto = strip_tags($_GET["t"]); }
          //if(!file_exists($this->nombre)){ if($this->nombre == "icrear" OR $this->nombre == "captcha"){}else{ $this->nombre = $this->imgDefault; }}
          
          
          
          
          if(isset($_GET["n"])){
          $this->nombre = strip_tags($_GET["n"]);
          if($this->nombre == "icrear" OR $this->nombre == "captcha"){}else{
            $novalido = array(1 => ".php", 2 => ".html", 3 => ".css", 4 => ".txt", 5 => ".dat", 6 => ".js", 7 => ".xml", 8 => "htaccess", 9 => "../../");
          $pos = strpos($this->nombre, $this->ruta); if ($pos === false){ $this->nombre = $this->imgDefault; }else{
             if(is_file($this->nombre)){
             foreach($novalido as $val){ $pos = strpos($this->nombre, $val); if ($pos === false){}else{ $this->nombre = $this->imgDefault; } }
             }else{$this->nombre = $this->imgDefault;}
          }
          }
          }else{ $this->nombre = ""; }
          
         if(isset($_GET["t"])){ $this->texto = strip_tags($_GET["t"]); }elseif($this->nombre == ""){$this->nombre = $this->imgDefault; }
          
          
          
          
   }
   public function randomText() { $pattern = "1234567890abcdefghijklmnopqrstuvwxyz"; /* Se usa para el Captcha */
    return $pattern{rand(0,35)}.$pattern{rand(0,35)}.$pattern{rand(0,35)}.$pattern{rand(0,35)}.$pattern{rand(0,35)};
   }
   public function mostrar(){
   
                  /* Generar código Captcha */
      if($this->nombre == "captcha"){
         $_SESSION['tmptxt'] = $this->randomText();
         $formato = "image/gif";
         if(file_exists("$this->bgcaptcha")){ $thumb = imagecreatefromgif("$this->bgcaptcha"); $colText = imagecolorallocate($thumb, 0, 0, 0);}
         else{ $thumb = imagecreatetruecolor("80", "30"); $colText = imagecolorallocate($thumb, 255, 255, 255); }
         imagestring($thumb, 5, 16, 7, $_SESSION['tmptxt'], $colText);
      }else{
      
                  /* Crear una imagen apartir de un texto */
          if($this->nombre == "icrear"){
             $thumb = imagecreatetruecolor($this->ancho, $this->altmax); $formato = "image/png";
             imagerectangle($thumb, 4, 4, $this->ancho-4, $this->altmax-4, imagecolorallocate($thumb, $this->background[0], $this->background[1], $this->background[2]));  /* Puede suprimir esta linea para mostrar solo el texto. */
          }else{
          
             /* Obtenemos datos y formato de la imagen */
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
         
         }//Fin de icrear

         /* Fondo transparente */                                                                                // 255, 255, 255,
         if($formato == "image/png" OR $formato == "image/gif"){ imagefill($thumb, 0, 0, imagecolorallocatealpha($thumb, 0, 0, 0, 127)); imagealphablending($thumb, false); /**/ imagesavealpha($thumb, true); }

         /* Texto en imagen */
         $textcolor = imagecolorallocate($thumb, $this->colorText[0], $this->colorText[1], $this->colorText[2]); //0xFFBA00
         if(isset($this->texto)){ imagestring($thumb, 5, 20, 20, $this->texto, $textcolor); }

         /* Marca de agua */
         if(isset($_GET["m"])){ $estampa = imagecreatefrompng("$this->estampa");
         /* Copiar parte de una imagen */
         imagecopy($thumb, $estampa, imagesx($thumb) - imagesx($estampa) - 25, imagesy($thumb) - imagesy($estampa) - 25, 0, 0, imagesx($estampa), imagesy($estampa)); }

         }//Fin de no Captcha
         
         /* Filtros de imagen */
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
         

         /* Efectos de imagen */
         switch ($this->efecto) {
              case 1:  imageflip($thumb, IMG_FLIP_VERTICAL);                       break; /* Voltearla verticalmente */
              case 2:  imageflip($thumb, IMG_FLIP_HORIZONTAL);                     break; /* Voltearla horizontalmente */
              default: break;
         }


/* Enviar encabezado */
header("Content-type: $formato");   /* Exportar la imagen al navegador o a un fichero */
if($formato == "image/jpg"){          imagejpeg($thumb);
}elseif($formato == "image/png"){     imagepng($thumb);
}elseif($formato == "image/gif"){     imagegif($thumb);
}elseif($formato == "image/bmp"){     imagebmp($thumb);
}elseif($formato == "image/jpeg"){    imagejpeg($thumb);
}else{                                imagejpeg($thumb); }

/* Liberar memoria */
imagedestroy($thumb); /* Destruir una imagen */
}//Fin de funcion mostrar

}//Fin de clase imagen
$imagen = new imagen();
$imagen -> mostrar();
?>

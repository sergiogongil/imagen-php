<?php
session_start();
       $_SESSION['id_sesion'] = session_name();
       if(isset($_SESSION["tmptxt"])){ return $_SESSION["tmptxt"]; }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Imagen-PHP</title>
    <meta name="title" content="Imagen-PHP">
    <meta name="description" content="Imagen en PHP. Clase para manipular imagenes de distintos formatos o sin formato, aplicar configuraciones o filtros de imagen.">
  </head>
<body style="background-color:#D0D0D0;">




  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg">
     <br><i>Imagen con tama&ntilde;o predeterminado.</i>
  </div>
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen">
     <br><i>Imagen sin extensi&oacute;n.</i>
  </div>
  
  <div style="float:left; width:auto;"><br>
     <img src="img.php?n=data/noExiste&x=200&y=100">
     <br><i>Imagen no existe</i>
  </div>

  <div style="float:left; width:auto;"><br>
     <img src="img.php?x=200&y=100">
     <br><i>Imagen por defecto</i>
  </div>
  
<hr style="width:100%; float:left; margin: 10px 0px 10px 0px;">
  
<div style="width:100%; float:left;">

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=400&y=200&m=1">
     <br><i>Imagen con marca de agua</i>
  </div>
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=400&y=200&t=Parrafo de texto incrustado">
     <br><i>Imagen con texto incrustado</i>
  </div>
  
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=400&y=200&f=2&m=1&t=Parrafo de texto incrustado">
     <br><i>Propiedades combinadas</i>
  </div>
  
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=150&y=100">
     <br><i>Imagen en miniatura</i>
  </div>
  

  
  
</div>





<div style="width:100%; float:left;">
<hr style="width:100%; float:left; margin: 10px 0px 10px 0px;"><h2 style="color:blue;">FILTROS</h2>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=1">
     <br><i>Invierte colores</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=2">
     <br><i>Escala de grises</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=3">
     <br><i>Brillo</i>
  </div>
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=4">
     <br><i>Contraste</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=5">
     <br><i>Escala color</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=6">
     <br><i>Resaltar bordes</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=7">
     <br><i>Relieve</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=8">
     <br><i>Gaussiano</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=9">
     <br><i>Borrosa</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=10">
     <br><i>Superficial</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=11">
     <br><i>Suaviza</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&f=12">
     <br><i>Pixelaci&oacute;n</i>
  </div>

</div>





<div style="width:100%; float:left;">
<hr style="width:100%; float:left; margin: 10px 0px 10px 0px;"><h2 style="color:blue;">EFECTOS</h2>


  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&e=1">
     <br><i>Voltearla verticalmente</i>
  </div>
  
  

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/imagen.jpg&x=300&y=150&e=2">
     <br><i>Voltearla horizontalmente</i>
  </div>


</div>




<div style="width:100%; float:left;">
<hr style="width:100%; float:left; margin: 10px 0px 10px 0px;"><h2 style="color:blue;">OTRAS</h2>


  <div style="float:left; width:auto;">
     <img src="img.php?n=icrear&x=220&y=55&t=info@guardianweb.es">
     <br><i>Crear imagen</i>
  </div>

  <div style="float:left; width:auto;">
     <img src="img.php?n=data/php.png&x=150">
     <br><i>Fondo transparente</i>
  </div>
  
  <div style="float:left; width:auto;">
     <img src="img.php?n=captcha">
     <br><i>Imagen Captcha</i>
  </div>
  

</div>







</body>
</html>

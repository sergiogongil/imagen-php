# imagen-php
Cargar imagen con o sin extensión en PHP

En algunas ocasiones, nos encontramos con aplicaciones que gestionan sus imágenes sin la extension del formato de imagen, y no podrás usar el típico "img src..." de HTML. Para solucionar esto, bastará con hacer una llamada a esta clase, indicando el nombre de la imagen y opcionalmente definir propiedades.

<pre>&lt;img src="img.php"&gt;</pre>

<h2>Notas sobre funciones y modificaciones</h2>
<ul>
  <li>Cargar imágenes sin formato en HTML</li>
  <li>Cargar imágenes de distintos formatos</li>
  <li>Mostrar miniaturas de las imágenes originales</li>
  <li>Definido tamaño máximo de imagen (por seguridad)</li>
  <li>Aplicar marca de agua a las imágenes</li>
  <li>Texto en imágenes incrustado</li>
  <li>Transforma tus imágenes a blanco y negro</li>
  <li>Auto ajuste de proporciones del tama&ntilde;o</li>
</ul>

<h2>Ejemplos de uso</h2>
<p>Podrás aplicar filtros y ajustes a tus imágenes, directamente indicándolo en la URL con el paso de variables GET.</p>

<i>Para aplicar una marca de agua:</i>
<pre>&lt;img src="img.php?n=imagen.jpg&<b>m=1</b>"&gt;</pre>

<i>Para incrustar un texto a tu imagen:</i>
<pre>&lt;img src="img.php?n=imagen.jpg&<b>t=Hola Mundo!</b>"&gt;</pre>

<i>Para transformar tu imagen a blanco y negro:</i>
<pre>&lt;img src="img.php?n=imagen.jpg&<b>b=1</b>"&gt;</pre>

<i>Con esta lógica y de esta forma tan simple, puedes transformar tus imágenes, aplicarles filtros y otras funciones.</i>

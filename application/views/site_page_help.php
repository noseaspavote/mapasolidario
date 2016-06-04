<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
  <?php $this->load->view('site_html_head');?>
  </head>
  <body class="body body--interna">
    <div id="container">
      <div class="wrapper">
        <div class="row">
          <div class="span12">
            <article class="article">
            <div class="article__body">
            <h5><b>No veo mi institución en el mapa.</b></h5>
            <p>
              Si no ves la institución en el mapa, podes ir a <a href="<?=site_url('agregar-institucion');?>">Agregar institución</a> para facilitarnos los datos. <BR>
              Ante la menor duda podes ponerte en contacto con nosotros en la sección de <a href="<?=site_url('contacto');?>">contacto</a>.
            </p>
            <h5><b>Deseo colaborar con el <a href="http://www.mapasolidario.org.ar">MapaSolidario</a>. ¿Cómo puedo hacer?</b></h5>
            <p>
              Siempre es bienvenida una mano! Podes consultar en la sección <a href="<?=site_url('como-ayudar');?>">Como ayudar</a>. <BR>
              Pero también puedes contactarnos por todos nuestros canales (Redes sociales, correo y contacto) y te contestaremos a la brevedad.
            </p>
            <h5><b>¿Cómo solicito que modifiquen los datos de una institución?</b></h5>
            <p>
              Si los datos están incorrectos puedes ir al detalle de la institución (opción "más" de la información en el mapa) y <BR>
              hacer click en la opción "Reportar un error" al final de la página.<BR>
              El equipo de <a href="http://www.noseaspavote.org.ar" target="_blank">NoSeasPavote</a> analizará la situación y se pondrá en contacto con la Institución.
            </p>
            <h5><b>Deseo que quiten mi institución del mapa ¿Cómo hago?</b></h5>
            <p>
              Dentro del detalle de la institución (opción "más" de la información en el mapa) puedes reportar un error <BR>
              haciendo click en la opción "Reportar un error" al final de la página. <BR>
              El equipo de <a href="http://www.noseaspavote.org.ar" target="_blank">NoSeasPavote</a> analizará la situación y se pondrá en contacto con la Institución.
            </p>
            <div style="float:right">
              <a href="http://www.noseaspavote.org.ar" target="_blank" title="NoSeasPavote.org.ar"><img src="<?=site_url()?>assets/media/img/nsp-logo-small.png" title="NoSeasPavote.org.ar"/></a>
            </div>
            </div>
            </article>              
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
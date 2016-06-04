<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('site_html_head');?>
</head>
  <body class="body body--interna">
    <?php $this->load->view('site_html_analyticstracking');?>
    <div id="container">
      <?php $this->load->view('site_html_nav'); ?>
      <div class="wrapper">
        <?php if($result) { ?>
              <h1>Confirmación exitosa!</h1>
              <div class="flash flash--success"> 
                Puede que nuestro equipo se ponga en contacto con la institución durante el proceso de verificación. </br>
                Recibirás un correo cuando esté publicada en el mapa.
              </div>
        <?php }else{ ?>
              <h1>Hubo un error en la confirmación!</h1>
              <div class="flash flash--error"> 
                Ponete en contacto con nosotros para solucionar el problema.
              </div>
        <?php } ?>
		<div class="row">
			<div class="span12"> 
				  <div class="article__body">
					<p></p>
				</div>
			</div>
		</div>
      <!-- script references-->
      <?php
        $data = array('view' => 'mail_confirm'); 
        $this->load->view('site_html_footer_scripts',$data);
      ?>
      <footer class="clear">
        <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
        <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
      </footer>
    </div>
  </body>
</html>
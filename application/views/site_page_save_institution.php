<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head> 
    <?php $this->load->view('site_html_head');?>
  </head>
  <body class="body body--interna" data-site-url="<?=site_url();?>">
    <?php $this->load->view('site_html_analyticstracking');?>
    <div id="container">
      <?php $this->load->view('site_html_nav'); ?>
    <div class="wrapper">
      <?php if($result) { ?>
            <div  id="form-message" class="flash flash--success">
                Gracias por tu colaboración!<br>
                Recibirás un correo para confirmar tu correo, una vez que confirmes continuaremos el proceso. <br>
                Si no lo encuentras, revisa en tu correo no deseado. Muchas gracias.
            </div>
      <?php }else{ ?>
            <div  id="form-message" class="flash flash--error">
                Se produjo un error al enviar el formulario. <br>
                Por favor, inténtalo más tarde.
            </div>
      <?php } ?>
    </div>
    <!-- script references-->
    <?php
    $data = array('view' => 'add_institution'); 
    $this->load->view('site_html_footer_scripts',$data);
    ?>
    <footer class="clear">
      <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
      <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
    </footer>
    </div>
  </body>
</html>
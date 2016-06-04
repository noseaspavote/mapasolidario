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
            <h5><b><?=$this->mapasoli->getAnnouncementTitle();?></b></h5>
            <p>
              <?=$this->mapasoli->getAnnouncementContent();?><BR>
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
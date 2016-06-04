<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('site_html_head');?>
  </head>
  <body class="body body--interna">
    <?php $this->load->view('site_html_analyticstracking');?>
      <div id="fb-root"></div>
      <script>
        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.5&appId=1404215403177590";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>                   
      <div id="container">
        <?php $this->load->view('site_html_nav'); ?>
        <div class="wrapper">
          <div class="row">
            <div class="span7">
              <article class="article">
                <h1 class="article__title">El Mapa Solidario </h1>
                <div class="article__body"><p>El mapa surgió a partir de nuestro trabajo en <u><a target="_blank" alt="ir al sitio de No Seas Pavote" href="http://www.noseaspavote.org.ar">No Seas Pavote</a></u> con la gente en situación de calle y como respuesta a la necesidad de saber e informar aquellas instituciones que prestan servicios gratuitos orientadas a esta realidad. </p>
                <p>Se fijaron 3 condiciones para su realización: que fuese del partido de Lomas de Zamora, gratuito y de respuesta inmediata (mapa Impreso). Se relevaron más de 180 instituciones. </p>
                <p>El Mapa Solidario no tiene afiliación ni recurso político ni lucro alguno; es totalmente gratuito y su fin es socializar la información de todas las organizaciones en él plasmadas, para formar una Red de trabajo en conjunto. Todas las instituciones intervinientes manifestaron su consentimiento de participación.</p>
                <p>El Mapa Solidario también cuenta con su versión impresa, un mapa y una guía con instituciones orientadas a resolver necesidades de personas que se encuentran en situación de calle (lugares para comer - curarse - dormir - bañarse). El mapa y la guía se reparten en la calle a las personas que lo necesitan.  También podes descargarla desde aca!</p>
                </div>
                <span><a target="_blank" href="http://noseaspavote.org.ar/proyectos/27-mapa">[Conocer más]</a></span></BR></BR>
                <div class="fb-like" data-href="https://www.facebook.com/mapasolidario" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
              </article>
            </div>
            <div class="span5">
              <aside class="novedades">
                <h3 class="novedades__title">acerca del mapa</h3>
                <div class="media-box">
                <h4 class="media-box__title">AGREGA TU INSTITUCIÓN</h4>
                <p class="media-box__body">Hemos creado el proceso para que vos puedas dar de alta la institución que sos parte o conoces.</p>
                </div>
                <div class="media-box">
                <h4 class="media-box__title">MÁS CATEGORÍAS</h4>
                <p class="media-box__body">Seguimos sumando categorías para que te seá cada día más útil. </p>
                </div>
                <div class="media-box">
                <h4 class="media-box__title">EL MAPA ESTÁ ONLINE!</h4>
                <p class="media-box__body">El mapa ya se encuentra online. Igualmente, seguimos trabajando para mejorarlo.</p>
                </div>
                <h3 class="novedades__title">descargas</h3>
                <div class="media-box">
                <p class="by-center"><a class="button button--descargar" target="_blank" href="<?php echo site_url('download/mapasolidario_mapa.pdf');?>">Descargar <strong>mapa</strong></a></p>
                </div>
                <div class="media-box">
                <p class="by-center"><a class="button button--descargar" target="_blank" href="<?php echo site_url('download/mapasolidario_guia_impresa.pdf');?>">Descargar <strong>guía </strong></a></p>
                </div>
              </aside>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="span12">
              <h3 class="novedades__title">Colaboran con nosotros</h3>
              <div class="row">
                <div class="span3">
                  <center><a target="_blank" href="http://www.neolo.com.ar" title="Nos provee el hosting"><img class="img-responsive" src="<?php echo base_url('assets/media/img/logo_neolo.png');?>"></a></center>
                </div>
                <div class="span3">
                </div>
                <div class="span3">
                  <center><a target="_blank" href="http://www.camba.coop" title="Colaboró con el diseño del sitio"><img class="img-responsive" src="<?php echo base_url('assets/media/img/logo-camba.png');?>"></a></center>
                </div>
                <div class="span3">
                    <center><a target="_blank" href="http://www.cambalachecoopera.com.ar" title="Colaboró la construcción del mapa"><img class="img-responsive" src="<?php echo base_url('assets/media/img/logo-cambalache.png');?>"></a></center>
                </div>
              </div>
            </div>
          </div>
          <div id="twitter-news"></div>
      </div>
      <!-- script references-->
      <?php
        $data = array('view' => 'the_project'); 
        $this->load->view('site_html_footer_scripts',$data);
      ?>
      <footer class="clear">
        <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
        <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
      </footer>
      </div>
  </body>
</html>
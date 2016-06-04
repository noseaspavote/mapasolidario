<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('site_html_head', array('customTitle' => $institution['name'] . '(@' . $institution['alias'] . ')'));?>
  </head>
  <body class="body body--interna" data-base-url="<?=base_url();?>">
    <?php $this->load->view('site_html_analyticstracking');?>
    <div id="container">
      <?php $this->load->view('site_html_nav'); ?>
      <div class="wrapper">
        <h1><?=$institution['name'] . '(@' . $institution['alias'] . ')'?></h1>
        <div class="row">
          <div class="span7">
            <article class="article">
              <input type="hidden" id="institution-id" value="<?=$institution['id']?>">
              <h2 class="article__title"><?=$institutionTypeName?></h2>
              <div class="article__body">
                <h4><b>Detalle</b></h4>
                <p><?=$institution['description'];?></p>
                <h4><b>Categorías</b></h4>
                <p>
                  <?php
                    foreach ($categoriesLabel as $category) {
                      echo $category['name'] . '<BR>';
                    }
                  ?>
                </p>
                <h4><b>Dirección</b></h4>
                  <?php
                    $street_cross = '';
                    if($institution['between_street_1'] == '' && $institution['between_street_2'] == ''){
                      $street_cross = '';
                    }else if($institution['between_street_1'] != '' && $institution['between_street_2'] == ''){
                      $street_cross = ' (esquina ' . $institution['between_street_1'] . ')';
                    }else if($institution['between_street_1'] == '' && $institution['between_street_2'] != ''){
                      $street_cross = ' (esquina ' . $institution['between_street_2'] . ')';
                    }else{
                      $street_cross = ' (entre ' . $institution['between_street_1'] . ' y ' . $institution['between_street_2'] . ')';
                    }
                  ?>
                  <p><?=$institution['street_name'] . ' ' . $institution['street_number'] . $street_cross . ($institution['floor_dept']!=''?', Piso/depto: ' . $institution['floor_dept']:'');?></p>
                  <p>
                    <a href="<?=base_url()?>search?q=<?=$institutionCityName?>" target="blank" title="Buscar instituciones en <?=$institutionCityName?>"><?=$institutionCityName?></a>,
                    <a href="<?=base_url()?>search?q=<?=$institutionDistrictName?>" target="blank" title="Buscar instituciones en <?=$institutionDistrictName?>"><?=$institutionDistrictName?></a>,
                    <a href="<?=base_url()?>search?q=<?=$institutionProvinceName?>" target="blank" title="Buscar instituciones en <?=$institutionProvinceName?>"><?=$institutionProvinceName?></a>
                  </p>
                  <?=($institution['phone']!=''?'<p><i class="fa fa-phone-square"></i> ' . $institution['phone'] . '</p>':'')?>
                  <?=($institution['site_url']!=''?'<p><i class="fa fa-globe"></i> <a href="' . $institution['site_url'] . '" target="_blank" title="Ir al sitio"> Ir al sitio </a></p>':'')?>
                  <?=($institution['email']!=''?'<p><i class="fa icon-envelope"></i> <a href="mailto:' . $institution['email'] . '" title="Enviar correo">' . $institution['email'] . '</a></p>':'')?>
                  <?php
                    if (strlen($institution['twitter'])>0) {
                      $twitterUser = substr($institution['twitter'], strpos($institution['twitter'],"twitter.com/")+12);
                      echo '<i class="fa icon-twitter"></i> <a target="blank" href="' . $institution['twitter'] . '" title="Seguir a @' . $twitterUser . '">Seguir a @' . $twitterUser . ' en Twitter</a>';
                    }
                  ?>
                  <br>
                  <?php
                    if (strlen($institution['facebook'])>0) {
                      echo '<i class="fa icon-facebook"></i> <a target="blank" href="' . $institution['facebook'] . '" title="Ir a Facebook">Ir a la página de Facebook</a>';
                    }
                  ?>
              </div>
            </article>
          </div>
          <div class="span5">
            <?php if($institution['email']!='') { ?>
            <div id="form-message" class="flash flash--success" style="display:none;"></div>
            <form id="form-contact" class="form form--vertical">
              <input type="hidden" id="formType" name="formType" value="contact-institution">
              <input type="hidden" id="toInstitution" name="toInstitution" value="<?=$institution['alias']?>">
              <h3>Enviar mensaje a la institución</h3>
              <div class="form__group">
                <label for="name">Nombre*</label>
                <input type="text" id="name" name="name" data-validation="required" data-validation-error-msg="El nombre no puede estar vacío."/>
              </div>
              <div class="form__group">
                <div class="span6">
                  <label for="email">Email*</label>
                  <input type="email" id="email" name="email" data-validation="email required" data-validation-error-msg="Tenes que ingresar un correo electrónico válido."/>
                </div>
                <div class="span6">
                  <label for="email_check">Confirmar correo*</label>
                  <input type="email" id="email_check" name="email_check" data-validation="email check_mail required" data-validation-error-msg="Este correo debe coincidir con el ingresado."/>
                </div>
              </div>
              <div class="form__group">
                <label for="subject">Asunto*</label>
                <select id="subject" name="subject" data-validation="required" data-validation-error-msg="El asunto no puede estar vacío.">
                  <option value="">Seleccionar Asunto</option>
                  <?php
                  foreach($this->mapasoli->getInstitutionSubjects() as $key=>$val){
                  if($key==$subject){
                  echo '<option selected value="' . $key . '">' . $val . '</option>';
                  }else{
                  echo '<option value="' . $key . '">' . $val . '</option>';
                  }
                  }
                  ?>
                </select>
              </div>
              <div class="form__group">
                <label for="message">Mensaje* (Quendan <span id="maxlength">256</span> caracteres disponibles)</label>
                <textarea id="message" name="message" data-validation="required length" data-validation-length="max256" data-validation-error-msg="El mensaje no puede estar vacío."></textarea>
              </div>
              <div class="form__group">
                <input type="checkbox" id="newsletter" name="newsletter" value="true"><label for="newsletter">Deseo recibir más noticias del <a href="http://mapasolidario.org.ar">MapaSolidario.org.ar</a></label>
              </div>
              <div class="form__group">
                <div class="g-recaptcha" data-validation="required" data-sitekey="<?=$this->mapasoli->googleCaptchaSiteKey();?>"></div>
              </div>
              <div class="form__group">
                <button id="btnSubmit">Enviar mensaje</button>
              </div>
            </form>       
            <?php } else { ?>
              <h3><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se puede enviar mensajes.</h3>
              <p>La institución no tiene configurada una cuenta de correo, por ese motivo, no puedes enviarle un mensaje de contacto. Pero no te detengas! Prueba con algún otro medio de contacto =D.</p>
            <?php } ?>        
          </div>
        </div>
        <div class="row">
          <div class="span12">
            <h4><a style="color:red;" href="<?=site_url()?>contacto/reportar-error?info=<?=urlencode(json_encode(array('view'=>'institution_detail', 'institution_id'=>$institution['id'])))?>" title="Reportar un error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Reportar un error.</a></h4>
          </div>
        </div>
      </div>
      <!-- script references-->
      <?php
      $data = array('view' => 'institution_detail'); 
      $this->load->view('site_html_footer_scripts',$data);
      ?>
      <footer class="clear">
        <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
        <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
      </footer>
    </div>
  </body>
</html>
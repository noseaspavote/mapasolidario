<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('site_html_head');?>
  </head>
  <body class="body body--interna" data-base-url="<?=base_url();?>">
    <?php $this->load->view('site_html_analyticstracking');?>
    <div id="container">
      <?php $this->load->view('site_html_nav'); ?>
      <div class="wrapper">
        <h1>contacto</h1> 
        <!--div class="flash flash--success">Mensaje enviado con exito</div>
        <div class="flash flash--warning">Mensaje enviado con exito</div>
        <div class="flash flash--error">Hay errores en el formulario</div-->
        <div class="row">
          <div class="span4">
            <address>Mercedes 607, Lavallol, Lomas de Zamora.<br>Tel.+54911 3094 2425 / +54911 3757 6058<br>pcirillo@nosespavote.org.ar /  cworner@noseaspavote.org.ar</address>
          </div>
          <div class="span8">
			<div id="form-message" class="flash flash--success" style="display:none;"></div>
            <form id="form-contact" class="form form--vertical">
              <input type="hidden" id="formType" name="formType" value="contact">
              <h3>Dejanos tu consulta</h3>
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
          <?php if($subject==null){ ?>      
            <select id="subject" name="subject" data-validation="required" data-validation-error-msg="El asunto no puede estar vacío." <?=($subject!=null?'disabled':'')?>>
            <option value="">Seleccionar Asunto</option>
            <?php          
            foreach($this->mapasoli->getSubjects() as $key=>$val){
            if($key==$subject){
            echo '<option selected="selected" value="' . $key . '">' . $val . '</option>';
            }else{
            echo '<option value="' . $key . '">' . $val . '</option>';
            }
            }
            ?>
            </select>
        <?php
          }else{
            $info = $this->input->get('info', TRUE);
            echo '<input type="hidden" id="subject" name="subject" value="' . $subject  . '">' . $this->mapasoli->getSubject($subject);
            echo '<input type="hidden" id="info" name="info" value="' . urlencode($info)  . '">';
          }
        ?>
              </div>
              <div class="form__group">
                <label for="message">Mensaje*</label>
                <textarea id="message" name="message" data-validation="required" data-validation-error-msg="El mensaje no puede estar vacío."></textarea>
              </div>
              <div class="form__group">
                <input type="checkbox" id="newsletter" name="newsletter" value="true"><label for="newsletter">Deseo recibir más noticias del <a href="http://mapasolidario.org.ar">MapaSolidario.org.ar</a></label>
              </div>
              <div class="form__group">
                <div class="g-recaptcha" data-validation="required" data-sitekey="<?=$this->mapasoli->googleCaptchaSiteKey();?>"></div>
              </div>
              <div class="form__group">
                <button id="btnSubmit">Enviar formulario</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- script references-->
      <?php
        $data = array('view' => 'contact_us'); 
        $this->load->view('site_html_footer_scripts',$data);
      ?>
      <footer class="clear">
        <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
        <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
      </footer>
    </div>
  </body>
</html>
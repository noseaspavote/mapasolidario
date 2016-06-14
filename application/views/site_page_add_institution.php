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
      <h1 id="agregar-instituci-n">Agregar institución</h1>
      <h3 id="-form-parte-del-mapa-solidario-web-carg-tu-instituci-n-">¡Formá parte del Mapa Solidario Web! Cargá tu Institución.</h3>
      <p>El Mapa Solidario está conformado por instituciones que ofrecen servicios gratuitos y de respuesta inmediata a las necesidades de 
      diversos sectores de la población. Como parte de este universo de Instituciones, nuestro fin es lograr una red de 
      trabajo en conjunto con todas ellas.</p>
      <p>Luego de completar el formulario, recibirás un e-mail para continuar el proceso.</p>
      <div  id="form-message" class="flash flash--warning">Ten en cuenta que toda la información ingresada aquí será pública.</div>
      <div id="imap-canvas"></div>
      <form id="form-institution" class="form form--vertical" method="POST" action="<?=site_url();?>formulario-institucion">
        <input type="hidden" id="latitude" name="latitude"/>
        <input type="hidden" id="longitude" name="longitude"/>
        <div class="row">
          <div class="span6">
            <div class="form__group">
              <div class="span6">
                <label for="alias">Alias (Identificará a la institución) *</label>
                <input type="text" id="alias" name="alias" class="uppercase" pattern="^([a-zA-Z0-9)$" data-validation="unique_alias length" data-validation-length="min4"/>
                <input type="hidden" id="alias_check" name="alias_check"/>
              </div>
              <div class="span6">
                <label for="name">Nombre de la institución *</label>
                <input type="text" id="name" name="name" class="uppercase" data-validation="required length" data-validation-error-msg="Tenes que ingresar un nombre (Maximo 100 caracteres)." data-validation-length="max100"/>
              </div>
            </div>
            <div class="form__group">
              <div class="span6">
                <label for="institution_type_id">Tipo de institución*</label>
                <select id="institution_type_id" name="institution_type_id" data-validation="required" data-validation-error-msg="Tenes que seleccionar un tipo de organización.">
                  <option value="">---- Seleccione un Tipo ----</option>
                  <?php foreach($institution_types as $type){?>
                  <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="span6">
                <label for="province_id">Provincia*</label>
                <select id="province_id" name="province_id" class="geocode-params" data-validation="required" data-validation-error-msg="Tenes que seleccionar una provincia.">
                  <option value="">---- Seleccione una provincia ----</option>
                  <?php foreach($provinces as $province){?>
                  <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form__group row">
              <div class="span6">
                <label for="district_id">Partido*</label>
                <select disabled id="district_id" name="district_id" class="geocode-params" data-validation="required" data-validation-error-msg="Tenes que seleccionar un partido.">
                  <option value="">---- Seleccione un partido ----</option>
                </select>
              </div>
              <div class="span6">
                <label for="city_id">Ciudad*</label>
                <select disabled id="city_id" name="city_id" class="geocode-params" data-validation="required" data-validation-error-msg="Tenes que seleccionar una ciudad.">
                  <option value="">---- Seleccione una ciudad ----</option>
                </select>
              </div>
            </div>
            <div class="form__group row">
              <div class="span6">
                <label for="street">Calle*</label>
                <input type="text" id="street_name" name="street_name" class="uppercase geocode-params" data-validation="required length" data-validation-error-msg="Tenes que ingresar una calle (Maximo 100 caracteres)." data-validation-length="max100"/>
              </div>
              <div class="span2">
                <label for="street_number">Número*</label>
                <input type="text" id="street_number" name="street_number" class="geocode-params" data-validation="number required" data-validation-error-msg="Tenes que ingresar un número inválido"/>
              </div>
              <div class="span2">
                <label for="floor_dept">Piso/Depto.</label>
                <input type="text" id="floor_dept" name="floor_dept" class="uppercase" data-validation="length" data-validation-length="0-10" data-validation-error-msg="Maximo 10 caracteres."/>
              </div>
              <div class="span2">
                <label for="zip_code">C.P.</label>
                <input type="text" id="zip_code" name="zip_code" class="uppercase" data-validation="length" data-validation-length="0-15" data-validation-error-msg="Maximo 15 caracteres."/>
              </div>
            </div>
            <div class="form__group row">
              <div class="span4">
                <label for="street_name_known">Cómo se conoce la calle</label>
                <input type="text" id="street_name_known" name="street_name_known" class="uppercase" data-validation-optional="true" data-validation="length" data-validation-error-msg="Maximo 100 caracteres." data-validation-length="max100"/>
              </div>
              <div class="span4">
                <label for="between_street_1">Entre la calle</label>
                <input type="text" id="between_street_1" name="between_street_1" class="uppercase" data-validation-optional="true" data-validation="length" data-validation-error-msg="Maximo 50 caracteres." data-validation-length="max50"/>
              </div>
              <div class="span4">
                <label for="between_street_2">y la calle</label>
                <input type="text" id="between_street_2" name="between_street_2" class="uppercase" data-validation-optional="true" data-validation="length" data-validation-error-msg="Maximo 50 caracteres." data-validation-length="max50"/>
              </div>
            </div>
          </div>
          <div class="span6">
            <div class="form__group">
              <label for="description">Descripción* (¿A qué se dedica? ¿Horarios de atención?)
              <textarea id="description" name="description" data-validation="required" class="uppercase" data-validation-error-msg="El mensaje no puede estar vacío."></textarea>
            </div>
            <div class="form__group row">
              <div class="span4">
                <label for="phone">Telefono*</label>
                <input type="text" id="phone" name="phone" data-validation="length required" class="uppercase" data-validation-error-msg="Tenes que ingresar el teléfono (Maximo 15 caracteres)." data-validation-length="max15"/>
              </div>
              <div class="span8">
                <label for="phone_contact">Referencia del teléfono*</label>
                <input type="text" id="phone_contact" name="phone_contact" data-validation="length required" class="uppercase" data-validation-error-msg="Tenes que ingresar el nombre de un contacto al que podamos llamar (Maximo 100 caracteres)." data-validation-length="max100"/>
              </div>
            </div>
            <div class="form__group">
              <div class="span6">
                <label for="email">Correo de la institución*</label>
                <input type="text" id="email" name="email" data-validation="email required length" class="uppercase" data-validation-error-msg="Correo inválido (Maximo 100 caracteres)." data-validation-length="max100"/>
              </div>
              <div class="span6">
                <label for="email_check">Confirmar correo de la institución*</label>
                <input type="text" id="email_check" name="email_check" class="uppercase" data-validation="email check_email required" data-validation-error-msg="Este correo debe coincidir con el ingresado."/>
              </div>
            </div>
            <div class="form__group row">
              <div class="span4">
                <label for="site_url">Página web</label>
                <input type="text" id="site_url" name="site_url" class="uppercase" data-validation-optional="true" data-validation="url length" data-validation-length="0-150" data-validation-error-msg="La dirección del sitio es inválida (Máximo 150 caracteres)."/>
              </div>
              <div class="span4">
                <label for="facebook">Facebook</label>
                <input type="text" id="facebook" name="facebook" class="uppercase" data-validation-optional="true" data-validation="url length" data-validation-length="0-150" data-validation-error-msg="La dirección de Facebook es inválida (Máximo 150 caracteres)."/>
              </div>
              <div class="span4">
                <label for="twitter">Twitter</label>
                <input type="text" id="twitter" name="twitter" class="uppercase" data-validation-optional="true" data-validation="url length" data-validation-length="0-150" data-validation-error-msg="La dirección de Twitter es inválida (Máximo 150 caracteres)."/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span12">
            <h3 class="novedades__title">Información del suscriptor</h3>
            <div class="row">
              <div class="span3">
                <div class="form__group">
                  <label for="suscriptor_type">¿Relación con la institución?*</label>
                  <select id="suscriptor_type" name="suscriptor_type" data-validation="required" data-validation-error-msg="Tenes que seleccionar quien sos.">
                    <option value=""> ¿Quien sos? </option>
                    <option value="member">Soy miembro de la organización.</option>
                    <option value="responsible">Soy responsable de la institución.</option>
                    <option value="sponsor">Conozco la institución pero no participo en ella.</option>
                  </select>
                </div>
              </div>
              <div class="span3">
                <div class="form__group">
                  <label for="suscriptor_name">Nombre*</label>
                  <input type="text" id="suscriptor_name" class="uppercase" name="suscriptor_name" data-validation="required length" data-validation-error-msg="Tenes que ingresar tu nombre (Maximo 100 caracteres)." data-validation-length="max100"/>
                </div>
              </div>
              <div class="span3">
                <div class="form__group">
                  <label for="suscriptor_email">Correo*</label>
                  <input type="text" id="suscriptor_email" class="uppercase" name="suscriptor_email" data-validation="email required length" data-validation-error-msg="Correo inválido. (Maximo 100 caracteres)." data-validation-length="max100"/>
                </div>
              </div>
              <div class="span3">
                <div class="form__group">
                  <label for="suscriptor_email_check">Confirmar tu correo*</label>
                  <input type="text" id="suscriptor_email_check" class="uppercase" name="suscriptor_email_check" data-validation="email check_suscriptor_email required" data-validation-error-msg="Este correo debe coincidir con el ingresado."/>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="span12">
            <div class="g-recaptcha" data-sitekey="<?=$this->mapasoli->googleCaptchaSiteKey()?>"></div>
            <button id="btnSubmit">Enviar formulario</button>
          </div>
        </div>
      </form>	
    </div>
    <div id="map-institution" class="row" style="visibility:hidden"></div>
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
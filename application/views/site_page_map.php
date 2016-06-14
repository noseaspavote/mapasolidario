<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('site_html_head');?>
</head>
<body class="body" data-site-url="<?=site_url();?>">
    <?php $this->load->view('site_html_analyticstracking');?>
  <div class="loader"></div>
  <div id="container">
    <?php $this->load->view('site_html_nav'); ?>
    <div id="searchContainer"></div>
    <div id="map-canvas"></div>
  <aside class="sidebar">
    <form class="form form--search">
      <input id="showInstitution" type="hidden" <?=(isset($_GET['@'])?'value="' . $_GET['@'] . '"':'')?>>
        <input id="showll" type="hidden" <?=(isset($_GET['ll'])?'value="' . $_GET['ll'] . '"':'')?>>
      <div class="form__group">
        <input id="txtSearch" type="text" placeholder="¿Qué estás buscando?" <?=(isset($_GET['q'])?'value="' . $_GET['q'] . '"':'')?>>
        <buttom id="btnSearch">Buscar</buttom>
        <div align="right" id="posicion" ><a href="#" onclick="useCurrentLocation(); return false;"><i class="fa fa-location-arrow"></i> Usar mi posición</a></div>
      </div>
      <div class="form__list"><a class="form__close"></a>
        <ul class="form--search__result"></ul>
      </div>
    </form>
    <ul class="category-template-container">
      <li>
        <input type="hidden" value="31">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="banarse">
          <i class="fa fa-check-square"></i>
          <span>
        </a>
      </li>
      <li>
        <input type="hidden" value="2">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="comer">
        <i class="fa fa-check-square"></i>
      </li>
      <li>
        <input type="hidden" value="6">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="curarse">
        <i class="fa fa-check-square"></i>
      </li>
      <li>
        <input type="hidden" value="4">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="dormir">
        <i class="fa fa-check-square"></i>
      </li>
      <li>
        <input type="hidden" value="32">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="vestirse">
        <i class="fa fa-check-square"></i>
      </li>
      <li>
        <input type="hidden" value="5">
        <a data-selected="true" onclick="setCategoryMarkers(this); return false;" href="#" alt="practicas_comunitarias">
        <i class="fa fa-check-square"></i>
      </li>
    </ul>
    <div align="center" ><a href="#" onclick="setAllCategories(); return false;">marcar todas</a></div>

    <nav>
  		<a href="<?php echo site_url('como-ayudar');?>" class="header__donar">Como ayudar</a>
  	  <ul class="nav header__nav">
  		<li><a href="<?php echo site_url('./');?>">Mapa</a>
  		</li>
  		<li><a href="<?php echo site_url('el-proyecto');?>">El proyecto</a>
  		</li>
  		<li><a href="<?php echo site_url('agregar-institucion');?>">Agregar institución</a>
  		</li>
  		<li><a href="<?php echo site_url('contacto');?>">Contacto</a>
  		</li>
  	  </ul>
  	</nav>
  </aside>
  <!-- script templates-->
  <script id="category-template" type="text/x-jquery-tmpl">
    <li>
      <input type="hidden" data-value="id" />
      <a href="#" onclick="setCategoryMarkers(this); return false;" data-alt="class" data-selected="true"><i class="fa fa-check-square"></i> <span data-content="caption" ></span></a>
    </li>
  </script>
  <!-- script templates-->
  <script id="result-template" type="text/html">
    <li>
    <input type="hidden" data-value="id"/>
    <a href="#" onclick="showInfo(this); return false;" data-alt="cat_caption">
      <p><i class="fa fa-circle" data-alt="cat_class"></i>  <span data-content="name"></span></p>
    </a>
    </li>
  </script>
  <footer class="clear">
    <p class="legal">Un proyecto de <a href="http://www.noseaspavote.org.ar/" target="_blank" class="legal__marca">no seas pavote</a></p>
    <p class="legal">Con colaboración de <a href="http://camba.coop/" target="_blank" class="legal__marca">camba</a></p>
  </footer>
  <div class="redes">
    <a href="https://www.facebook.com/mapasolidario/" target="_blank"><i class="fa fa-facebook-square fa-3x"></i></a>
    <a href="https://www.twitter.com/mapasolidarioOK/" target="_blank"><i class="fa fa-twitter-square fa-3x"></i></a>
    <a href="http://www.noseaspavote.org.ar" target="_blank" ><img src="assets/media/img/noseaspavote_redes.png" style="height:3em; margin-bottom:-5px;"></i></a>
  </div>
  <!-- script references-->
  <?php
    $data = array('view' => 'map');
    $this->load->view('site_html_footer_scripts',$data);
  ?>
  </div>
  <div id="popup-share" class="article" style="background-color:#FFF; padding: 15px;">
    <h4><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir ubicación</h4>
      <div class="row">
        <div class="span12">
            <article class="article">
              <div class="article__body">
                <div class="form__group">
                  <input type="text" id="popup-share-input" class="uppercase" value=""/>
                </div>
                <div id="popup-share-div"></div>
              </div>
            </article>
        </div>
      </div>
      <span style="float:right;"><a href="#" title="Copiar enlace" id="popup-share-copy-link"  data-clipboard-target="#popup-share-input"><i class="fa fa-files-o" aria-hidden="true"></i></a></span>
  </div>


</body>
</html>

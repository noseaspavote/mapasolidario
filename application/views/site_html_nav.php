<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<div id="fb-root"></div>
<header class="header">
	<i class="fa fa-bars" aria-hidden="true"></i>
	<div class="header__brand"><a href="<?=site_url('./');?>">Mapa <strong>solidario</strong></a></div>
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
		<li><a target="_blank" class="various fancybox.ajax" href="<?=site_url('ayuda');?>" title="Ayuda" ><i class="fa fa-question-circle" aria-hidden="true"></i></a>
		</li>
		<?php if($this->mapasoli->showAnnouncement()) { ?>
			<li><a target="_blank" id="link-announcement" data-show-on-load="<?=($this->mapasoli->showAnnouncementOnLoad()==true?'true':'false')?>" class="various fancybox.ajax" href="<?=site_url('anuncios');?>" title="Anuncios" ><i class="fa fa-bullhorn" aria-hidden="true"></i></a>
			</li>
		<?php } ?>
		<li><a target="_blank" class="various fancybox.iframe" href="http://www.youtube.com/embed/twZ2Z_16cjU?autoplay=1" title="Ver video institucional" ><i class="fa fa-youtube-square" aria-hidden="true"></i></a>
		</li>
		<li><a target="_blank" href="https://www.twitter.com/mapasolidarioOK/"><i class="icon-twitter"></i></a>
		</li>
		<li><a target="_blank" href="https://www.facebook.com/mapasolidario/"><i class="icon-facebook"></i></a>
		</li>
	  </ul>
	</nav>
</header>

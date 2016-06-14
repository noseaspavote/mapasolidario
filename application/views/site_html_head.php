<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$htmlTitle = '#MapaSolidario (beta)';
if(isset($customTitle))
    $htmlTitle = $customTitle;

?><!DOCTYPE html>
<!--header start-->
<title><?=$htmlTitle?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="jade, node, nodejs, stylus, lesscss, jadejs, framework, css, css3, html, html5">
<meta name="description">
<link href="<?=base_url()?>assets/media/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="<?=base_url()?>assets/css/style.css?v=<?=$this->mapasoli->scriptVer()?>" rel="stylesheet" type="text/css" media="all">
<link href="<?=base_url()?>assets/css/desktop.css?v=<?=$this->mapasoli->scriptVer()?>" rel="stylesheet" type="text/css" media="screen and (min-width:600px)">
<link href="<?=base_url()?>assets/css/mobile.css?v=<?=$this->mapasoli->scriptVer()?>" rel="stylesheet" type="text/css" media="screen and (max-width:599px)">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leaflet/leaflet.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<link href="<?=base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css?v=<?=$this->mapasoli->scriptVer()?>" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/geojsonAutocomplete/geojsonautocomplete.min.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/visualclick/L.VisualClick.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/contextMenu/leaflet.contextmenu.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/jssocials/jssocials.min.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/jssocials/jssocials-theme-flat.min.css?v=<?=$this->mapasoli->scriptVer()?>" type="text/css" media="screen" />
<meta property="og:title" content="Mapa solidario">
<meta property="og:description">
<meta property="og:type" content="website">
<meta property="og:url" content="APP_URL">
<meta property="og:image" content="<?=site_url('assets/media/img/favicon.png');?>">
<meta property="og:site_name" content="Mapa solidario">
<meta property="fb:admins" content="APP_ADMIN">
<script src="<?=base_url()?>assets/js/lib.min.js?v=<?=$this->mapasoli->scriptVer()?>" type="text/javascript"></script>

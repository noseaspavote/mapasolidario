<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>';

echo '<!-- Add fancyBox -->';
echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>';

echo '<!-- Optionally add helpers - button, thumbnail and/or media -->';
echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
echo '<script type="text/javascript" src="' . site_url() . 'assets/js/general' . $this->mapasoli->scriptMin() . '.js?v=' . $this->mapasoli->scriptVer() . '"></script>';

switch($view){
    case 'map':
        echo '<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.loadtemplate/1.4.4/jquery.loadTemplate.min.js"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/leaflet/leaflet.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/visualclick/L.VisualClick.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/sidebar/leaflet-sidebar.min.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/contextMenu/leaflet.contextmenu.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/popup-overlay/jquery.popupoverlay.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/jssocials/jssocials.min.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/clipboard/clipboard.min.js?v=' . $this->mapasoli->scriptVer() .'"></script>';        
        echo '<script type="text/javascript" src="' . site_url() . 'assets/js/map' . $this->mapasoli->scriptMin() . '.js?v=' . $this->mapasoli->scriptVer() . '"></script>';
        ?>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcTKVf0fqgaUmeNKQe0W2DJR_n7bpILZg">
        </script>
        <script>
            //tengo que cargar el js para mobile
            if($(window).width()< 600){
                document.write('<script type="text/javascript" src="<?=site_url();?>assets/js/mobile_functions.js?v=<?=$this->mapasoli->scriptVer()?>"><\/script>');
            }else{
                document.write('<script type="text/javascript" src="<?=site_url();?>assets/js/functions.js?v=<?=$this->mapasoli->scriptVer()?>"><\/script>');
            }
        </script>
        <?php
        break;    
    case 'add_institution':
        echo '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.20/jquery.form-validator.min.js"></script>';
        echo '<script src="https://www.google.com/recaptcha/api.js?hl=es"></script>';
        echo '<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/geocoder/Control.Geocoder.js?v=' . $this->mapasoli->scriptVer(). '"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/js/addinstitution' . $this->mapasoli->scriptMin() . '.js?v=' . $this->mapasoli->scriptVer() . '"></script>';
        break;
        
    case 'contact_us':
        echo '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.1/jquery.form-validator.min.js"></script>';
        echo '<script src="https://www.google.com/recaptcha/api.js?hl=es"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/js/contactus' . $this->mapasoli->scriptMin() . '.js?v=' . $this->mapasoli->scriptVer() . '"></script>';
        break;
        
    case 'the_project':
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/jssocials/jssocials.min.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        break;
    case 'maintenance':
    case 'mail_confirm':
        break;
    case 'institution_detail':
        echo '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.1/jquery.form-validator.min.js"></script>';
        echo '<script src="https://www.google.com/recaptcha/api.js?hl=es"></script>';
        echo '<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/js/institution_detail' . $this->mapasoli->scriptMin() . '.js?v=' . $this->mapasoli->scriptVer() . '"></script>';
        echo '<script type="text/javascript" src="' . site_url() . 'assets/plugins/jssocials/jssocials.min.js?v=' . $this->mapasoli->scriptVer() .'"></script>';
        break; 
    case 'help_us':
    case '404':
        break;
}
?>
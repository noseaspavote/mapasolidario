<?php
//http://www.patpohler.com/codeigniter-multiple-environments/
if(! defined('ENVIRONMENT') ){
	
	$domain = strtolower($_SERVER['HTTP_HOST']);

	if ($domain == 'mapasolidario.org.ar' || $domain == 'www.mapasolidario.org.ar') {
		define('ENVIRONMENT', 'production');
	}else if($domain == 'stage.mapasolidario.org.ar'){
		define('ENVIRONMENT', 'stage');
	}else{
		define('ENVIRONMENT', 'development');
	}
}

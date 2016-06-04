<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'site';
$route['404_override'] = 'site/badrequest';
$route['translate_uri_dashes'] = TRUE;
$route['mapa'] = 'site/map';
$route['map'] = 'site/map';
$route['institucion/alias/(:any)'] = 'site/institutionByAlias/$1';
$route['institution/alias/(:any)'] = 'site/institutionByAlias/$1';
$route['institucion/codigo/(:any)'] = 'site/institutionByCode/$1';
$route['institution/code/(:any)'] = 'site/institutionByCode/$1';
$route['mapa/(:any)'] = 'site/map/$1';
$route['map/(:any)'] = 'site/map/$1';
$route['el-proyecto'] = 'site/theproject';
$route['the-proyecto'] = 'site/theproject';
$route['agregar-institucion'] = 'site/new_institution';
$route['add-institution'] = 'site/new_institution';
$route['formulario-institucion'] = 'site/save_institution';
$route['form-institution'] = 'site/save_institution';
$route['contacto'] = 'site/contactus';
$route['contactus'] = 'site/contactus';
$route['contacto/(:any)'] = 'site/contactus/$1';
$route['contactus/(:any)'] = 'site/contactus/$1';
$route['como-ayudar'] = 'site/helpus';
$route['helpus'] = 'site/helpus';
$route['ayuda'] = 'site/help';
$route['help'] = 'site/help';
$route['announcements'] = 'site/announcements';
$route['anuncios'] = 'site/announcements';
$route['sitio-offline'] = 'site/siteoffline';
$route['site-offline'] = 'site/siteoffline';
$route['confirm'] = 'site/confirm';
$route['buscar'] = 'site/search/$1';
$route['search'] = 'site/search/$1';
$route['confirm/(:any)'] = 'site/confirm/$1';
$route['download/(:any)'] = 'site/download/$1';
$route['enviar-formulario'] = 'site/sendForm';
$route['send-form'] = 'site/sendForm';


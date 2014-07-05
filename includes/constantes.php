<?php
	/* Définition des constantes */
	define('DS', 		DIRECTORY_SEPARATOR);
	define('ROOT', 		dirname(dirname(__FILE__)));
	define('INCLUDES', 	ROOT.DS."includes");
	
	/* Définition de la zone géographie (TimeZone) */
	date_default_timezone_set('Europe/Paris');
	
	define('RACINE', '/tp_rdv/');
	define('STYLES', RACINE.'styles/');
	define('ASSETS', STYLES.'assets/');
	define('JS', RACINE.'js/');
	
	/*constantes logs */
	
	define('LOGIN_ID',1);
	define('select_id',2);
	define('drop_id',3);
	define('resize_id',4);
	define('save_create_id',5);
	define('close_create_id',6);
	define('select_click_event_id',7);
	define('save_click_event_id',8);
	define('delete_click_event_id',9);
	define('close_click_event_id',10);
	define('LOGOUT_ID',11);
	define('parametres',12);
	define('profil',13);
	define('add_contact',14);
	define('add_adress',15);
	
	
	/*historique*/
	
	$historique=array(
		1 => '<i class="pull-left thumbicon icon-key btn-success no-hover"></i> Vous vous êtes connecté(e)',
		5 => '<i class="pull-left thumbicon icon-calendar btn-success no-hover"></i>Vous avez ajouté un rendez vous',
		8 =>  '<i class="pull-left thumbicon icon-calendar btn-default no-hover"></i>Vous avez mondifé un rendez vous',
		9 => '<i class="pull-left thumbicon icon-calendar btn-danger no-hover"></i>Vous avez supprimé un rendez vous',
		11 => '<i class="pull-left thumbicon icon-off btn-inverse no-hover"></i>Vous vous êtes déconnecté(e)',
		14 => '<i class="pull-left thumbicon icon-user btn-success no-hover"></i>Vous avez ajouté un contact',
		15 => '<i class="pull-left thumbicon icon-map-marker btn-success no-hover"></i>Vous avez ajouté une adreesse'
		);
?>
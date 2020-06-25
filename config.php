<?php
session_start(); //Starts session of the app

//####################################################

//Default font configuration

define('STANDART_FONT', 'Montserrat'); //Font name
define('STANDART_FONT_LINK', '<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
'); //Font link

//####################################################

//SEO settings

define('DEFAULT_SEO_TITLE', 'Hantix - 1.0');

//####################################################

//Application settings

/* --->>> IMPORTANT! */ define('INCLUDE_PATH', 'http://localhost/sites-novos/delivery/'); //URL of your site
define('BASE_DIR', __DIR__.'/');
define('BASE_DIR_API', BASE_DIR.'back/API/');

//####################################################

//Twilio settings

define('TWILO_SID', '');
define('TWILO_TOKEN', '');
define('SMS_NUMBER', '');

//####################################################

//PayPal settings

define('PAYPAL_KEY', '');
define('PAYPAL_SECRET', '');
define('PAYPAL_CURRENCY', 'BRL');
define('PAYPAL_TITLE', 'Delivery System');

//####################################################

//PagSeguro Settings

define('PAGSEGURO_EMAIL', '');
define('PAGSEGURO_TOKEN', '');
define('PAGSEGURO_CURRENCY', 'BRL');

//####################################################

//Email settings

define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_USER', '');
define('EMAIL_PASS', '');
define('EMAIL_SECURE', 'tls');
define('EMAIL_PORT', 587);
define('EMAIL_AUTHOR', 'Delivery System');
define('EMAIL_REPLY', '');

//####################################################

//Database

/*
--->>> IMPORTANT!
*/
define('DB_HOST', 'localhost'); //Your database host
define('DB_NAME', 'new_delivery'); //Your database name
define('DB_USER', 'root'); //Your database user
define('DB_PASS', ''); //Your database password

//####################################################

//Personal settings

/*
	WARNING: Vital to the application. Just change anything if you know what are doing
*/

define('INCLUDE_PATH_PAINEL', INCLUDE_PATH.'painel/');

//####################################################

//Additional variables and settings

$STANDART_ICONS = array('support'=>'<i class="fas fa-support"></i>',
						'love'=>'<i class="fas fa-heart"></i>',
						'php'=>'<i class="fas fa-php"></i>',
						'user'=>'<i class="fas fa-user"></i>',
						'users'=>'<i class="fas fa-users"></i>',
						'check'=>'<i class="fas fa-check"></i>',
						'times'=>'<i class="fas fa-times"></i>',
						'warning'=>'<i class="fas fa-exclamation-triangle"></i>',
						'angle-down'=>'<i class="fas fa-angle-down"></i>',
						'angle-up'=>'<i class="fas fa-angle-up"></i>',
						'search'=>'<i class="fas fa-search"></i>',
						'cart'=>'<i class="fas fa-shopping-cart"></i>',
						'eye'=>'<i class="fas fa-eye"></i>',
						'out'=>'<i class="fas fa-sign-out-alt"></i>');
//####################################################

//SPL Autoload

$autoload = function($load) {
	include 'back/' . str_replace('\\', '/', $load) . '.php';
};
spl_autoload_register($autoload);

?>
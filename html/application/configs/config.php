<?php

/**
 * PHP configuration
 * Enable error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Application base URL
 */
//define('URL', 'http://127.0.1.1/login/html/');
define('URL', 'http://dnd.nima-design.net/');

/**
 * Folder paths
 */
//define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
define('ROOT' , '/');
define('BASE', 'var/www/dnd/html/');
define('CONFIGS', 'application/configs/');
define('CONTROLLERS', 'application/controllers/');
define('LIBS', 'application/libs/');
define('MODELS', 'application/models/');
define('VIEWS', 'application/views/');
define('CSS', 'public/css/');
define('JS', 'public/js/');
define('PICS', 'public/media/pics/');

/**
 * Cookie configuration
 */
//set cookie runtime to 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);
define('COOKIE_DOMAIN', '.127.0.1.1');

/**
 * Charset settings
 * specifically used for html() function in libs/tools.php
 */
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | 'UTF-8');
?>

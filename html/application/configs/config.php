<?php

/**
 * set charset and replace_flags constant for the htmlspecialchars function
 * in application/models/utils.class.php
 */
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_QUOTES | 'UTF-8');

/**
 * PHP configuration
 * Enable error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Application base URL
 */
define('URL', 'http://dikult205.h.uib.no/groups/G5/dnd/html/');

?>

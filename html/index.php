<?php
/**
 * A file to serve as entry point to the DND Helper
 * DND Helper is a PHP based web application to help keep track of character sheets
 * and to facilitate sharing of relevant information between players and gamemaster
 * @author Nils Martinussen
 * @created 2014-04-16
 */
session_start();
require 'application/configs/config.php';

header('Location: application/views/index.php');

?>
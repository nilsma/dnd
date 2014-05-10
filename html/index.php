<?php
session_start();
require 'application/configs/config.php';
//$_SESSION['config'] = 'application/configs/config.php';
//$_SESSION['config'] = ROOT . BASE . CONFIGS . 'config.php';
//header('Location: ' . ROOT . VIEWS . 'index.php');
header('Location: application/views/index.php');

?>
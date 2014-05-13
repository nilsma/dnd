<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
//    header('Location: http://127.0.1.1/dnd/html/index.php');
    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/charsql.class.php';

if(isset($_POST['confirm']) && (strtolower($_POST['confirm']) == 'yes')) {
  $csql = new Charsql();
  $csql->deleteCharacter($_SESSION['sheet_id']);

  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);

  header('Location: ../views/characters.php');
} else {
  header('Location: ../views/character.php');
}


?>

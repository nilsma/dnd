<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

if(isset($_POST['confirm']) && (strtolower($_POST['confirm']) == 'yes')) {
  $csql = new Charsql();
  $characterData = $csql->getCharacter($_SESSION['sheet_id']);
  $csql->deleteCharacter($characterData);

  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);

  header('Location: ../views/characters.php');
} else {
  header('Location: ../views/character.php');
}
?>

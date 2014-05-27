<?php
/**
 * A controller file for the DND Helper which deletes a gamemaster from the database
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

$user_id = $_SESSION['user_id'];
$gm_id = $_SESSION['gm_id'];
$cmp_id = $_SESSION['gm']['campaign']['id'];

if(isset($_POST['confirm']) && (strtolower($_POST['confirm']) == 'yes')) {
  $gmsql = new Gmsql();
  $gmsql->deleteGamemaster($user_id, $gm_id, $cmp_id);

  $_SESSION['gm'] = false;
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm']);
  unset($_SESSION['gm_id']);

  header('Location: ../views/gamemasters.php');
} else {
  header('Location: ../views/edit-gamemaster.php');
}


?>

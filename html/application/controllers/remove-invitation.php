<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

$gmsql = new Gmsql();

$name = $_POST['name'];
$gm_id = $_SESSION['gm_id'];
$cmp_id = $_SESSION['gm']['campaign']['id'];

$gmsql->removeInvitation($name, $gm_id, $cmp_id);

?>
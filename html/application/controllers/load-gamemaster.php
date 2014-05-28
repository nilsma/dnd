<?php
/**
 * A controller file for the DND Helper which loads a gamemaster upon click in the gamemasters-overview page
 * and sets the view to that gamemaster's campaign
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
$alias = $_POST['alias'];

$gmsql = new Gmsql();
$gm_id = $gmsql->getGamemasterId($alias, $user_id);

if($gm_id > 0) {
  $_SESSION['gm_id'] = $gm_id;
  $_SESSION['chosen'] = true;
} else {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

?>
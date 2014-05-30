<?php
/**
 * A controller file for the DND Helper which resets the initiatives to 1 for
 * all characters in the campaign
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

$cmp_id = $_SESSION['gm']['campaign']['id'];

$gmsql = new Gmsql();
$gmsql->resetInitiatives($cmp_id);

?>

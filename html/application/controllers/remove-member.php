<?php
/**
 * A controller file for the DND Helper which removes a character's membership to a campaign from the database
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

$gmsql = new Gmsql();

$name = $_POST['name'];
$cmp_id = $_SESSION['gm']['campaign']['id'];

$gmsql->removeMember($name, $cmp_id);

?>
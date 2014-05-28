<?php
/**
 * A controller file for the DND Helper which removes an invitation from the database
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$csql = new Charsql();

$alias = $_POST['alias'];
$char_name = $_POST['char_name'];
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];

$csql->removeInvitation($alias, $char_name, $user_id, $title);
?>
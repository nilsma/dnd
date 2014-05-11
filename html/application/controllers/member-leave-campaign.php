<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/charsql.class.php';

$csql = new Charsql();

$char_name = $_POST['char_name'];
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];

$csql->leaveCampaign($char_name, $user_id, $title);
?>
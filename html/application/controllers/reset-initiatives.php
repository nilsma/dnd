<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

$cmp_id = $_SESSION['gm']['campaign']['id'];

$gmsql = new Gmsql();
$gmsql->resetInitiatives($cmp_id);

?>

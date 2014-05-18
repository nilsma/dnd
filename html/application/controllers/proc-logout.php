<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie("dnd_helper", $username, time()-(60*60*24), '/', NULL, 0);
//    setcookie("dnd_helper", $username, time()-(60*60*24), '/groups/G5/dnd/', 'dikult205.h.uib.no/', 0);
header('Location: ../views/logged-out.php');
?>
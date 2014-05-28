<?php
/**
 * A controller file for the DND Helper which processes the logout procedure
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
$_SESSION = array();
session_destroy();
setcookie("dnd_helper", $username, time()-(60*60*24), '/', NULL, 0);
//    setcookie("dnd_helper", $username, time()-(60*60*24), '/groups/G5/dnd/', 'dikult205.h.uib.no/', 0);
header('Location: ../views/logged-out.php');
?>
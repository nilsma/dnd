<?php
/**
 * A controller file for the DND Helper which processes the logout procedure
 * @author 130680
 * @created 2014-05-25
 */
session_start();
$_SESSION = array();
session_destroy();
header('Location: ../views/logged-out.php');
?>
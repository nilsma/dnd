<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

$gm_id = $_SESSION['gm_id'];
$gmsql = new Gmsql();
$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;
$inv_errors = array();

if(isset($_SESSION['inv_failed'])) {
  $inv_errors = $_SESSION['inv_errors'];
  $_SESSION['inv_failed'] = false;
  unset($_SESSION['inv_failed']);
  $_SESSION['inv_errors'] = false;
  unset($_SESSION['inv_errors']);
}

$invHTML = $gmsql->buildInvHTML($gm['invitations'], $gm['members'], $inv_errors);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/gamemaster-invitations.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-invitations">
    <div id="main-container">
      <h1>Invitations View</h1>
      <div id="inner-container">
	<?php echo $invHTML; ?>
	<p><a href="gamemaster.php">Back to Gamemaster View</a></p>
	<p>or <a href="../controllers/proc-logout.php">Logout</a></p>
      </div> <!-- end inner-container -->
    </div> <!-- end main-container -->
  </body>
</html>

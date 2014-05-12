<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/gmsql.class.php';

$gm_id = $_SESSION['gm_id'];
$gmsql = new Gmsql();
$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

$invHTML = $gmsql->buildInvHTML($gm['invitations'], $gm['members']);

if(isset($_SESSION['fail_user_existence'])) {
  $_SESSION['fail_user_existence'] = false;
  unset($_SESSION['fail_user_existence']);
}

if(isset($_SESSION['fail_invitation_existence'])) {
  $_SESSION['fail_invitation_existence'] = false;
  unset($_SESSION['fail_invitation_existence']);
}

if(isset($_SESSION['fail_membership_existence'])) {
  $_SESSION['fail_membership_existence'] = false;
  unset($_SESSION['fail_membership_existence']);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/gamemaster-invitations.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="invitations">
    <div id="main-container">
      <div id="inner-container">
	<h1>Invitations View</h1>
	<?php echo $invHTML; ?>
	<p><a href="gamemaster.php">Back to Gamemaster View</a></p>
	<p>or <a href="../controllers/proc-logout.php">Logout</a></p>
      </div> <!-- end inner-container -->
    </div> <!-- end main-container -->
  </body>
</html>
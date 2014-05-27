<?php
/**
 * A file representing the view for the DND Helper gamemaster invitations page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
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
    <link rel="stylesheet" href="../../public/css/gamemaster-invitations.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/gamemaster-invitations.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-invitations">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><a href="gamemaster.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="gamemaster.php">Back to gamemaster</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Invitations View</h1>
      <div id="inner-container">
	<?php echo $invHTML; ?>
      </div> <!-- end inner-container -->
    </div> <!-- end main-container -->
  </body>
</html>

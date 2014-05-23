<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$csql = new Charsql();

$invitations = $csql->getInvitations($_SESSION['sheet_id']);
$memberships = $csql->getMemberships($_SESSION['sheet_id']);
$invHTML = $csql->buildInvHTML($invitations, $memberships);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/member-invitations.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/member-invitations.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="characters-invitations">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="character.php">Back to character</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Invitations View</h1>
      <div id="inner-container">
	<?php echo $invHTML; ?>
<!--	<p><a href="characters.php">Back to Characters View</a></p>
	<p>or <a href="../controllers/proc-logout.php">Logout</a></p> -->
      </div> <!-- end inner-container -->
    </div> <!-- end main-container -->
  </body>
</html>

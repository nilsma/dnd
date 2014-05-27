<?php
/**
 * A file representing the view for the DND Helper gamemaster campaign page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

if(!isset($_SESSION['gm_id'])) {
  header('Location: gamemasters.php');
}

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();

$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

$gamemasterHTML = $gmsql->buildGamemasterHTML($gm);

if(isset($_SESSION['chosen'])) {
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <link rel="stylesheet" href="../../public/css/gamemaster.css"/>
    <script type="text/javascript" src="../../public/js/gamemaster.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-screen">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="edit-gamemaster.php">Edit gamemaster</a></li>
	  <li><a href="gamemaster-invitations.php">Manage Invitations</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Gamemaster View</h1>
      <div id="inner-container">
	<?php echo $gamemasterHTML; ?>
	<section class="sec-nav-container">
	  <p class="nav-paragraph"><a href="gamemaster-invitations.php">Manage Invitations</a></p>
	  <p class="nav-paragraph"><a href="gamemasters.php">Back to Gamemasters View</a></p>
          <p id="delete-gamemaster" class="nav-paragraph"><a href="confirm-delete-gamemaster.php">Delete Gamemaster</a></p>
	  <p class="nav-paragraph">Or <a href="../controllers/proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

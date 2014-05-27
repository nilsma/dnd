<?php
/**
 * A file representing the view for the DND Helper gamemasters' overview page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/membersql.class.php';
require_once '../models/gmsql.class.php';

$db = new Membersql();

$gamemasters = $db->getGamemasters($_SESSION['user_id']);

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

if(isset($_SESSION['chosen'])) {
  header('Location: gamemaster.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/gamemasters.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/gamemasters.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemasters-overview">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><img src="../../public/images/gamemaster_icon32px.jpg"></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="create-gamemaster.php">Create Gamemaster</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Gamemasters view</h1>
      <div id="inner-container">
<?php
if(count($gamemasters) > 0) {
  $gmsql = new Gmsql();
  $html = $gmsql->buildGamemasterList($gamemasters);
} else {
  $html = '<p>You have not created any gamemasters yet!</p>' . "\n";
}
echo $html;
?>
	<section class="sec-nav-container">
	  <p class="nav-paragraph"><a href="member.php">Back to Member View</a></p>
	  <p class="nav-paragraph"><a href="create-gamemaster.php">Create Gamemaster</a></p>
	  <p>or <a href="../controllers/proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

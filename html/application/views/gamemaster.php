<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/gmsql.class.php';

if(!isset($_SESSION['gm_id'])) {
  header('Location: gamemasters.php');
}

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();
$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

$gamemasterHTML = $gmsql->buildGamemasterHTML($gm);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/main.js"></script>
    <script type="text/javascript" src="../../public/js/gm.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-screen">
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

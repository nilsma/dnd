<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
//    header('Location: http://127.0.1.1/dnd/html/index.php');
    header('Location: http://dnd.nima-design.net');
}

//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'gmsql.class.php';
require_once '../configs/config.php';
require_once '../models/gmsql.class.php';

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();
$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

$gamemasterHTML = $gmsql->buildGamemasterHTML($gm);

//require_once ROOT . BASE . VIEWS . 'head.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/main.js"></script>
    <script type="text/javascript" src="../../public/js/gm.js"></script>
    <title>DND Helper</title>
  </head>
  <body>
    <div id="main-container">
      <div id="inner-container">
	<h1>Gamemaster View</h1>
	<?php echo $gamemasterHTML; ?>
	<section class="sec-nav-container">
<!--	  <p class="nav-paragraph"><a href="<?php echo BASE . VIEWS . 'invitations.php'; ?>">Manage Invitations</a></p>
	  <p class="nav-paragraph"><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Back to Gamemasters View</a></p>
	  <p class="nav-paragraph"><a href="<?php echo BASE . CONTROLLERS . 'delete-gamemaster.php'; ?>">Delete Gamemaster</a></p>
	  <p class="nav-paragraph">Or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p> -->
	  <p class="nav-paragraph"><a href="invitations.php">Manage Invitations</a></p>
	  <p class="nav-paragraph"><a href="gamemasters.php">Back to Gamemasters View</a></p>
	  <p class="nav-paragraph"><a href="../controllers/delete-gamemaster.php">Delete Gamemaster</a></p>
	  <p class="nav-paragraph">Or <a href="proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

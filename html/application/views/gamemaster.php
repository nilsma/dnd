<?php
/**
 * A file representing the view for the DND Helper gamemaster campaign page
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';
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

$site = new Site();
$entries = array(
		 'edit-gamemaster.php' => 'Edit Gamemaster',
		 'gamemaster-invitations.php' => 'Manage Invitations',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('gamemaster', 'DND Helper', $entries);

echo $header;

?>

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

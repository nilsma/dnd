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
require_once '../models/site.class.php';

$db = new Membersql();

$gamemasters = $db->getGamemasters($_SESSION['user_id']);

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

if(isset($_SESSION['chosen'])) {
  header('Location: gamemaster.php');
}

$site = new Site();
$entries = array(
		 'create-gamemaster.php' => 'Create Gamemaster',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('gamemasters-overview', 'DND Helper', $entries);

echo $header;

?>
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

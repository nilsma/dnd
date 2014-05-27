<?php
/**
 * A file representing the view for the DND Helper character sheet page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';
require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$char = $csql->getCharacter($sheet_id);
$characterHTML = $csql->buildCharacterHTML($char);

if(isset($_SESSION['chosen'])) {
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

$site = new Site();
$entries = array(
		 'confirm-delete-character.php' => 'Delete Character',
		 'member-invitations.php' => 'Manage Invitations',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('character', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Character View</h1>
      <div id="inner-container">
	<?php echo $characterHTML; ?>
	<section class="sec-nav-container">
	  <p><a href="characters.php">Back to Characters View</a></p>
	  <p><a href="../views/confirm-delete-character.php">Delete Character</a></p>
	  <p>or <a href="../controllers/proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

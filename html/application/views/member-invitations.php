<?php
/**
 * A file representing the view for the DND Helper character invitations page
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

$csql = new Charsql();

$invitations = $csql->getInvitations($_SESSION['sheet_id']);
$memberships = $csql->getMemberships($_SESSION['sheet_id']);
$invHTML = $csql->buildInvHTML($invitations, $memberships);

$site = new Site();
$entries = array(
		 'character.php' => 'Back to Character',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('character-invitations', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Invitations View</h1>
      <div id="inner-container">
	<?php echo $invHTML; ?>
      </div> <!-- end inner-container -->
    </div> <!-- end main-container -->
  </body>
</html>

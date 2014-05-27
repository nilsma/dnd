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

require_once '../models/site.class.php';
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

$site = new Site();
$entries = array(
		 'gamemaster.php' => 'Back to Gamemaster',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('gamemaster-invitations', 'DND Helper', $entries);

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

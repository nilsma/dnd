<?php
/**
 * A file representing the view for the DND Helper gamemaster delete confirmation page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';

$site = new Site();
$entries = array(
		 'edit-gamemaster.php' => 'Back to Edit Gamemaster',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('confirm-delete-gamemaster', 'DND Helper', $entries);

echo $header;


?>
    <div id="main-container">
      <h1>Gamemaster View</h1>
      <div id="inner-container">
	<div class="gui">
	  <p class="gui">Are you sure you want to delete <span class="char-name"><?php echo ucwords($_SESSION['gm']['details']['alias']); ?></span> the gamemaster?</p>
	  <form name="confirm-delete" action="../controllers/delete-gamemaster.php" method="POST">
	    <p class="gui"><label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes"></p>
	    <p class="gui"><label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked></p>
	    <p class="gui"><input type="submit" value="Respond"></p>
	  </form>
	</div> <!-- end .gui -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


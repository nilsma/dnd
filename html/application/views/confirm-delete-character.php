<?php
/**
 * A file representing the view for the DND Helper character sheet delete confirmation page
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';
require_once '../models/charsql.class.php';

if(!isset($_SESSION['sheet_id'])) {
    header('Location: characters.php');
}

$csql = new Charsql();

$sheet = $csql->getSheet($_SESSION['sheet_id']);

$site = new Site();
$entries = array(
		 'character.php' => 'Back to Character',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('confirm-delete-character', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Confirm Delete Character View</h1>
      <div id="inner-container">
	<div class="gui">
	<form name="confirm-delete" action="../controllers/delete-character.php" method="POST">
	  <p class="gui"><label>Are you sure you want to delete <span class="char-name"><?php echo ucwords($sheet['name']); ?></span> the <span class="char-class"><?php echo ucwords($sheet['class']); ?></span>?</label></p>
	  <p class="gui"><label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes"><br/>
	  <label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked></p>
	  <p><input type="submit" value="Respond"></p>
	</form>
	</div> <!-- end .gui -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


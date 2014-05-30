<?php
/**
 * A file representing the view for the DND Helper gamemaster creation page
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

$site = new Site();
$entries = array(
		 'gamemasters.php' => 'Back to Gamemasters',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('create-gamemaster', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Create Gamemaster View</h1>
      <div id="inner-container">
	<div class="form-entry">
	    <form name="gamemaster" action="../controllers/insert-gamemaster.php" method="POST">
	      <p><label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" required></p>
	      <p><label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlength="30" required></p>
	      <p><input type="submit" value="Create Gamemaster"></p>
	    </form>
	</div> <!-- end .form-entry -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

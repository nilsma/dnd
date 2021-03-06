<?php
/**
 * A file representing the view for the DND Helper members' landing page after logging in
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';
require_once '../models/site.class.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

if(isset($_SESSION['gm'])) {
  $_SESSION['gm'] = false;
  unset($_SESSION['gm']);
}

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

$site = new Site();
$entries = array(
		 'edit-member.php' => 'Edit User',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('member-landing', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Member view</h1>
      <div id="inner-container">
	<section class="sec-nav-container">
	  <div class="gui">
	    <p class="gui clickable"><a href="characters.php">Character Mode</a></p>
	  </div>
	  <div class="gui">
	    <p class="gui clickable"><a href="gamemasters.php">Gamemaster Mode</a></p>
	  </div>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

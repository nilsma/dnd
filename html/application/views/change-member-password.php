<?php
/**
 * A file representing the view for the DND Helper change user password page
 * @author 130680
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
		 'edit-member.php' => 'Back to Edit User',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('change-member-email', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Edit Member View</h1>
      <div id="inner-container">
	<div id="member-entries" class="gui">
	  <form name="change-member-name" action="../controllers/update-member-password.php" method="POST">
	    <p class="gui"><label for="password-current">Current password: </label><input id="password-current" name="password-current" type="password" maxlength="16" required></p>
	    <p class="gui"><label for="password-first">New password: </label><input id="password-first" name="password-first" type="password" maxlength="16" required></p>
	    <p class="gui"><label for="password-first">Repeat password: </label><input id="password-repeat" name="password-repeat" type="password" maxlength="16" required></p>
	    <p class="gui"><input type="submit" value="Submit" name="submit"></p>
	  </form>
<?php
if(isset($_SESSION['errors'])) {
   $html = '';
   $html .= '<div id="change-errors" class="error-report">' . "\n";
   $html .= '<ul class="error-list">' . "\n";
   if(count($_SESSION['errors']) >= 1) {
     foreach($_SESSION['errors'] as $error) {
       $html .= '<li>' . $error . '</li>' . "\n";
     }
  }
  $html .= '</ul>' . "\n";
  $html .= '</div> <!-- end #change-errors -->' . "\n";

  echo $html;

  $_SESSION['errors'] = false;
  unset($_SESSION['errors']);
}
?>
	</div> <!-- end #member-entries -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

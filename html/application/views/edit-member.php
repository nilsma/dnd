<?php
/**
 * A file representing the view for the DND Helper edit user (member) information page
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
		 'member.php' => 'Back to Member',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('edit-member', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Edit Member View</h1>
      <div id="inner-container">
	<div id="member-entries" class="gui">
	  <form name="change-member-name" action="../views/change-member-name.php" method="POST">
	    <p><span class="member-label">Username: </span><span id="member-name" class="member-value"><?php echo $_SESSION['username']; ?></span><input type="submit" value="Change ..." name="submit-name"></p>
	  </form>
	  <form name="change-member-email" action="../views/change-member-email" method="POST">
	    <p><span class="member-label">Email: </span><span id="member-email" class="member-value"><?php echo $_SESSION['email']; ?></span><input type="submit" value="Change ..." name="submit-email"></p>
	  </form>
	  <form name="change-member-password" action="../views/change-member-password" method="POST">
	    <p><span class="member-label">Password: </span><span id="member-password" class="member-value"> ... </span><input type="submit" value="Change ..." name="submit-password"></p>
	  </form>
<?php
if(isset($_SESSION['success'])) {
  $html = '';
  $html .= '<div id="update-success" class="success-report">' . "\n";
  $html .= '<ul class="success-list">' . "\n";
  if(count($_SESSION['success'] >= 1)) {
    foreach($_SESSION['success'] as $success) {
      $html .= '<li>' . $success . '</li>' . "\n";
    }
  }
  $html .= '</ul>' . "\n";
  $html .= '</div> <!-- end #update-success -->' . "\n";

  $_SESSION['success'] = false;
  unset($_SESSION['success']);  
  echo $html;
}
?>
	</div> <!-- end #member-entries -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

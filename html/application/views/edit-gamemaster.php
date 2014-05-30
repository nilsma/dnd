<?php
/**
 * A file representing the view for the DND Helper edit gamemaster information page
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';
require_once '../models/gmsql.class.php';

if(!isset($_SESSION['gm_id'])) {
  header('Location: gamemasters.php');
}

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();

$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

if(isset($_SESSION['chosen'])) {
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

$site = new Site();
$entries = array(
		 'confirm-delete-gamemaster.php' => 'Delete Gamemaster',
		 'gamemaster.php' => 'Back to Gamemaster',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('edit-gamemaster', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Edit Gamemaster View</h1>
      <div id="inner-container">
        <div class="form-entry">
          <form name="gamemaster" action="../controllers/update-gamemaster.php" method="POST">
            <p><label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" value="<?php echo ucwords($_SESSION['gm']['details']['alias']); ?>" required></p>
            <p><label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlength="30" value="<?php echo ucfirst($_SESSION['gm']['campaign']['title']); ?>" required></p>
            <p><input type="submit" value="Update Gamemaster"></p>
          </form>
<?php
$html = '';

if(isset($_SESSION['errors'])) {
   if(count($_SESSION['errors']) >= 1) {
     $html .= '<div id="edited" class="error-report">' . "\n";
     $html .= '<ul class="error-list">' . "\n";

     foreach($_SESSION['errors'] as $error) {
       $html .= '<li>' . $error . '</li>' . "\n";
     }

    $html .= '</ul>' . "\n";
    $html .= '</div> <!-- end #edited -->' . "\n";
  } else {
    $html .= '<div id="edited" class="success-report">' . "\n";
    $html .= '<p>Gamemaster edited!</p>' . "\n";
    $html .= '</div> <!-- end #edited -->' . "\n";
  }

$_SESSION['errors'] = false;
unset($_SESSION['errors']);
}

echo $html;

?>
        </div> <!-- end .form-entry -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

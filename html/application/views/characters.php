<?php
/**
 * A file representing the view for the DND Helper characters' overview page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';
require_once '../models/membersql.class.php';
require_once '../models/charsql.class.php';

$db = new Membersql();
$characters = $db->getCharacters($_SESSION['user_id']);

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['chosen'])) {
  header('Location: character.php');
}

$site = new Site();
$entries = array(
		 'create-character.php' => 'Create Character',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('characters-overview', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Characters view</h1>
      <div id="inner-container">
<?php
if(count($characters) > 0) {
  $csql = new Charsql();
  $html = $csql->buildCharactersList($characters);
  echo $html;
} else {
  echo '<p>You have not created any characters yet!</p>';
}
?>
        <section class="sec-nav-container">
          <p class="nav-paragraph"><a href="member-invitations.php">Manage Invitations</a></p>
	  <p class="nav-paragraph"><a href="member.php">Back to Member View</a></p>
	  <p class="nav-paragraph"><a href="create-character.php">Create Character</a></p>
	  <p class="nav-paragraph">or <a href="../controllers/proc-logout.php">Logout</a></p>
        </section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-contianer -->
  </body>
</html>

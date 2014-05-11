<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/membersql.class.php';
require_once '../models/charsql.class.php';

$db = new Membersql();
$characters = $db->getCharacters($_SESSION['user_id']);

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

require_once 'head.php';

?>
  <body>
    <div id="main-container">
      <h1>Characters view</h1>
      <div id="outer-form-container">
	<div class="form-entry">
<?php
if(count($characters) > 0) {
  $csql = new Charsql();
  $html = $csql->buildCharacterSelect($characters);
  echo $html;
} else {
  echo '<p>You have not created any characters yet!</p>';
}
?>
	</div> <!-- end .form-entry -->
      </div> <!-- end #outer-form-container -->
      <section class="sec-nav-container">
        <p class="nav-paragraph"><a href="member-invitations.php">Manage Invitations</a></p>
	<p class="nav-paragraph"><a href="member.php">Back to Member View</a></p>
	<p class="nav-paragraph"><a href="create-character.php">Create Character</a></p>
	<p class="nav-paragraph">or <a href="proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-contianer -->
  </body>
</html>

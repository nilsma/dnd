<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'membersql.class.php';
require_once ROOT . BASE . MODELS . 'charsql.class.php';

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

var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Characters view</h1>
    <section id="characters">
<?php
if(count($characters) > 0) {
  $csql = new Charsql();
  $html = $csql->buildCharacterSelect($characters);
  echo $html;
} else {
  echo '<p>You have not created any characters yet!</p>';
}
?>
      <p><a href="<?php echo BASE . VIEWS . 'member.php'; ?>">Back to Member View</a></p>
      <p><a href="<?php echo BASE . VIEWS . 'create-character.php';?>">Create Character</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
    </section> <!-- end #characters -->
  </body>
</html>

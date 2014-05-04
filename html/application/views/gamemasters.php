<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'membersql.class.php';
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

$db = new Membersql();
$gamemasters = $db->getGamemasters($_SESSION['user_id']);

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['gm'])) {
  $_SESSION['gm'] = false;
  unset($_SESSION['gm']);
}

var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Gamemasters view</h1>
    <section id="gamemasters">
<?php
if(count($gamemasters) > 0) {
  $gmsql = new Gmsql();
  $html = $gmsql->buildGamemasterSelect($gamemasters);
  echo $html;
} else {
  echo '<p>You have not created any gamemasters yet!</p>';
}
?>
      <p><a href="<?php echo BASE . VIEWS . 'member.php'; ?>">Back to Member View</a></p>
      <p><a href="<?php echo BASE . VIEWS . 'create-gamemaster.php';?>">Create Gamemaster</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
    </section> <!-- end #characters -->
  </body>
</html>

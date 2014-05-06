<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$char = $csql->getCharacter($sheet_id);
$characterHTML = $csql->buildCharacterHTML($char);

var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
  <body>
    <h1>Character View</h1>
    <?php echo $characterHTML; ?>
      <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Characters View</a></p>
      <p><a href="<?php echo BASE . CONTROLLERS . 'delete-character.php'; ?>">Delete Character</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

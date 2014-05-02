<?php
session_start();
require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$character = array();
$character = $csql->getCharacter($sheet_id);

$characterHTML = $csql->buildCharacter($character);

?>
<!DOCTYPE html>
<html>
  <body>
    <h1>Character View</h1>
    <?php echo $characterHTML; ?>
      <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Member View</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

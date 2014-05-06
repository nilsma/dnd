<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

require_once $_SESSION['config'];

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

var_dump($_SESSION);

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Member view</h1>
    <h2>Choose a role:</h2>
    <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Player Characters</a></p>
    <p><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Gamemasters</a></p>
    <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

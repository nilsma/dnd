<?php
session_start();
require_once $_SESSION['config'];

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Member view</h1>
    <h2>Choose a role:</h2>
    <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Player Character</a></p>
    <p><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Gamemaster</a></p>
    <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

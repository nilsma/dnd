<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();
$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

$gamemasterHTML = $gmsql->buildGamemasterHTML($gm);

var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
  <body>
    <h1>Gamemaster View</h1>
    <?php echo $gamemasterHTML; ?>
    <p><a href="<?php echo BASE . VIEWS . 'invitations.php'; ?>">Manage Invitations</a></p>
    <p><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Back to Gamemasters View</a></p>
    <p><a href="<?php echo BASE . CONTROLLERS . 'delete-gamemaster.php'; ?>">Delete Gamemaster</a></p>
    <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

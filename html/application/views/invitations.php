<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

var_dump($_SESSION);

$gmsql = new Gmsql();

$gm = $_SESSION['gm'];
$invHTML = $gmsql->buildInvHTML($gm['invitations']);
?>
<html>
  <body>
    <h1>Invitations</h1>
    <?php echo $invHTML; ?>
    <p><a href="<?php echo BASE . VIEWS . 'gamemaster.php'; ?>">Back to Gamemaster View</a></p>
    <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
  </body>
</html>

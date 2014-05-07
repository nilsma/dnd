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

require_once ROOT . BASE . VIEWS . 'head.php';

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <div id="main-container">
      <h1>Member view</h1>
      <section class="sec-nav-container">
	<p class="nav-paragraph"><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Slay Some Dwagons!</a></p>
	<p class="nav-paragraph"><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Rule Ze World!</a></p>
	<p class="nav-paragraph">or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

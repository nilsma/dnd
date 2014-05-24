<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/confirm-delete.css"/>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-delete">
    <div id="main-container">
      <h1>Gamemaster View</h1>
      <div id="inner-container">
	<div class="gui">
	  <p class="gui">Are you sure you want to delete <span class="char-name"><?php echo ucwords($_SESSION['gm']['details']['alias']); ?></span> the gamemaster?</p>
	  <form name="confirm-delete" action="../controllers/delete-gamemaster.php" method="POST">
	    <p class="gui"><label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes"></p>
	    <p class="gui"><label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked></p>
	    <p class="gui"><input type="submit" value="Respond"></p>
	  </form>
	</div> <!-- end .gui -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


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
	<p>Are you sure you want to delete <?php echo ucwords($_SESSION['gm']['details']['alias']); ?> the gamemaster?</p>
	<form name="confirm-delete" action="../controllers/delete-gamemaster.php" method="POST">
	  <p><label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes"></p>
	  <p><label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked></p>
	  <p><input type="submit" value="Respond"></p>
	</form>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


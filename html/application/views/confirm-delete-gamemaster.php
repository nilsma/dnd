<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-delete">
    <div id="main-container">
      <h1>Gamemaster View</h1>
      <div id="inner-container">
	<p>Are you sure you want to delete <?php echo ucwords($_SESSION['gm']['details']['alias']); ?> the gamemaster?</p>
	<form name="confirm-delete" action="../controllers/delete-gamemaster.php" method="POST">
	  <label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes">
	  <label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked><br/>
	  <input type="submit" value="Respond">
	</form>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


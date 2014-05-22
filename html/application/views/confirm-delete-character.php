<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$csql = new Charsql();

$sheet = $csql->getSheet($_SESSION['sheet_id']);
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
      <h1>Confirm Delete Character View</h1>
      <div id="inner-container">
	<form name="confirm-delete" action="../controllers/delete-character.php" method="POST">
	  <p><label for="confirmation">Are you sure you want to delete <?php echo ucwords($sheet['name']); ?> the <?php echo ucwords($sheet['class']); ?>?</label></p>
	  <p><label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes"></br>
	  <label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked></p>
	  <p><input type="submit" value="Respond"></p>
	</form>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>


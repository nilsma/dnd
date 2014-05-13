<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
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
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-delete">
    <div id="main-container">
      <div id="inner-container">
	<h1>Confirm Delete Character View</h1>
	<section id="gm-details">
	<form name="confirm-delete" action="../controllers/delete-character.php" method="POST">
	  <label for="confirmation">Are you sure you want to delete <?php echo ucwords($sheet['name']); ?> the <?php echo ucwords($sheet['class']); ?>?</label></br>
	  <label for="confirm">Yes</label><input name="confirm" id="confirm" type="radio" value="Yes">
	  <label for="cancel">No</label><input name="confirm" id="cancel" type="radio" value="No" checked><br/>
	  <input type="submit" value="Respond">
	</form>
	</section>
      </div>
    </div>
  </body>
</html>


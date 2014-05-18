<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-create">
    <div id="main-container">
      <h1>Create Gamemaster View</h1>
      <div id="inner-container">
	<div class="form-entry">
	  <fieldset>
	    <form name="gamemaster" action="../controllers/insert-gamemaster.php" method="POST">
	      <label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" required><br/>
	      <label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlenght="30" required><br/>
	      <input type="submit" value="Create Gamemaster">
	    </form>
	  </fieldset>
	</div> <!-- end .form-entry -->
        <section class="sec-nav-container">
	  <p class="nav-paragraph"><a href="gamemasters.php">Back to Gamemasters View</a></p>
	  <p class="nav-paragraph">or <a href="proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

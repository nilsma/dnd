<?php
/**
 * A file representing the view for the DND Helper gamemaster creation page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
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
    <link rel="stylesheet" href="../../public/css/create-gamemaster.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/create-gamemaster.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-create">
    <header>
      <nav>
	<ul>
	  <li><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="active-nav"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="gamemasters.php">Back to Gamemasters</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Create Gamemaster View</h1>
      <div id="inner-container">
	<div class="form-entry">
	    <form name="gamemaster" action="../controllers/insert-gamemaster.php" method="POST">
	      <p><label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" required></p>
	      <p><label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlenght="30" required></p>
	      <p><input type="submit" value="Create Gamemaster"></p>
	    </form>
	</div> <!-- end .form-entry -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

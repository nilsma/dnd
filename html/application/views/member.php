<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

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

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/member.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/member.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="member-landing">
    <header>
      <nav>
	<ul>
	  <li class="active-nav"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
	  <li><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
 	  <li><a href="characters.php"><img src="../../public/images/player_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="create-character.php">Create Character</a></li>
	  <li><a href="member-settings.php">Edit User</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Member view</h1>
      <div id="inner-container">
	<section class="sec-nav-container">
	  <a class="sec-nav-entry" href="characters.php">Slay Some Dwagons!</a>
	  <a class="sec-nav-entry" href="gamemasters.php">Rule Ze World!</a>
<!--	  <p class="nav-paragraph"><a href="characters.php">Slay Some Dwagons!</a></p>
	  <p class="nav-paragraph"><a href="gamemasters.php">Rule Ze World!</a></p> -->
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

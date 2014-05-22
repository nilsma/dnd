<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/create-character.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/create-character.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="character-create">
    <header>
      <nav>
	<ul>
	  <li><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
	  <li><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
 	  <li class="active-nav"><a href="characters.php"><img src="../../public/images/player_icon32px-alt.jpg"></a></li>
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
      <h1>Create Character View</h1>
      <div id="inner-container">
	<form name="personalia" action="../controllers/insert-character.php" method="POST">
<!--	  <fieldset> -->
	    <legend>Personalia</legend>
	    <p><label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" required></p>
	    <p><label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" required></p>
	    <p><label for="level">Level:</label><input name="level" id="level" type="number" value="1" required>
	    <p><label for="experience_points">XP:</label><input name="xp" id="experience_points" type="number" value="1" required></p>
	    <p><label for="hitpoints">Hitpoints:</label><input name="hp" id="hitpoints" type="number" value="1" required></p>
	    <p><label for="initiative_modifier">Init Mod:</label><input name="init_mod" id="initiative_modifier" type="number" value="0" required>
<!--	  </fieldset> -->
<!-- 	  <fieldset> -->
	    <legend>Attributes</legend>
	    <p class="attr-paragraph" id="first-attribute"><label for="strength">STR:</label><input name="str" id="strength" type="number" value="1" required><label for="strength_modifier">MOD:</label><input name="strMod" id="strength_modifier" type="number" value="0" required></p>
	    <p class="attr-paragraph"><label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="1" required><label for="constitution_modifier">MOD:</label><input name="conMod" id="constitution_modifier" type="number" value="0" required></p>
	    <p class="attr-paragraph"><label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="1" required><label for="dexterity_modifier">MOD:</label><input name="dexMod" id="dexterity_modifier" type="number" value="0" required></p>
	    <p class="attr-paragraph"><label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="1" required><label for="intelligence_modifier">MOD:</label><input name="intelMod" id="intelligence_modifier" type="number" value="0" required></p>
	    <p class="attr-paragraph"><label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="1" required><label for="wisdom_modifier">MOD:</label><input name="wisMod" id="wisdom_modifier" type="number" value="0" required></p>
	    <p class="attr-paragraph"><label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="1" required><label for="charisma_modifier">MOD:</label><input name="chaMod" id="charisma_modifier" type="number" value="0" required></p>
<!--	  </fieldset> -->
<!--	  <fieldset> -->
	    <legend>Purse</legend>
	    <p id="first-purse"><label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="0"></p>
	    <p><label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="0"></p>
	    <p><label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="0"></p>
<!--	  </fieldset> -->
	  <input id="submit" type="submit" value="Create Character">
	</form>
	<section class="sec-nav-container">
	  <p class="nav-paragraph"><a href="characters.php">Back to Characters View</a></p>
	  <p class="nav-paragraph">or <a href="../controllers/proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

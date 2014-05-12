<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';

require_once 'head.php';
?>
  <body id="create-character">
    <div id="main-container">
      <h1>Create Character View</h1>
      <div id="outer-form-container">
	<div id="top-entries">
	  <div class="form-entry">
	    <form name="personalia" action="../controllers/insert-character.php" method="POST">
	      <fieldset>
		<legend>Personalia</legend>
		<label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" required><br/>
		<label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" required><br/>
		<label for="level">Level:</label><input name="level" id="level" type="number" value="1" required>
		<label for="experience_points">XP:</label><input name="xp" id="experience_points" type="number" value="1" required><br/>
		<label for="hitpoints">Hitpoints:</label><input name="hp" id="hitpoints" type="number" value="1" required><br/>
		<label for="initiativeModifier">Initiative Modifier:</label><input name="init_mod" id="initiativeModifier" type="number" value="0" required>
	      </fieldset>
	      <fieldset>
		<legend>Attributes</legend>
		<label for="strength">STR:</label><input name="str" id="strength" type="number" value="1" required>
		<label for="strengthModifier">MOD:</label><input name="strMod" id="strenght_modifier" type="number" value="0" required><br/>
		<label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="1" required>
		<label for="constitutionModifier">MOD:</label><input name="conMod" id="constitution_modifier" type="number" value="0" required><br/>
		<label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="1" required>
		<label for="dexterityModifier">MOD:</label><input name="dexMod" id="dexterity_modifier" type="number" value="0" required><br/>
		<label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="1" required>
		<label for="intelligenceModifier">MOD:</label><input name="intelMod" id="intelligence_modifier" type="number" value="0" required><br/>
		<label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="1" required>
		<label for="wisdomModifier">MOD:</label><input name="wisMod" id="wisdom_modifier" type="number" value="0" required><br/>
		<label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="1" required>
		<label for="charismaModifier">MOD:</label><input name="chaMod" id="charisma_modifier" type="number" value="0" required><br/>
	      </fieldset>
	      <fieldset>
		<legend>Purse</legend>
		<label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="0"><br/>
		<label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="0"><br/>
		<label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="0"><br/>
	      </fieldset>
	      <input type="submit" value="Create Character">
	    </form>
	  </div> <!-- end .form-entry -->
	</div> <!-- end #top-entries -->
      </div> <!-- end #outer-form-container -->
      <section class="sec-nav-container">
	<p class="nav-paragraph"><a href="characters.php">Back to Member View</a></p>
	<p class="nav-paragraph">or <a href="../controllers/proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>
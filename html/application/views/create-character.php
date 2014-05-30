<?php
/**
 * A file representing the view for the DND Helper character creation page
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/site.class.php';

$site = new Site();
$entries = array(
		 'characters.php' => 'Back to Characters',
		 '../controllers/proc-logout.php' => 'Logout'
		 );
$header = $site->buildHeader('create-character', 'DND Helper', $entries);

echo $header;

?>
    <div id="main-container">
      <h1>Create Character View</h1>
      <div id="inner-container">
	<div class="character-form-entry">
	  <form name="personalia" action="../controllers/insert-character.php" method="POST">
	    <div id="personalia">
	      <p id="char-name"><label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" required></p>
	      <p id="char-class"><label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" required></p>
	      <p id="char-level"><label for="level">Level:</label><input name="level" id="level" type="number" value="1" required>
	      <p id="char-xp"><label for="experience_points">XP:</label><input name="xp" id="experience_points" type="text" value="1" required></p>
	      <p id="char-hp"><label for="hitpoints">Hitpoints:</label><input name="hp" id="hitpoints" type="number" value="1" required></p>
	      <p id="char-init-mod"><label for="initiative_modifier">Init Mod:</label><input name="init_mod" id="initiative_modifier" type="number" value="0" required>
	    </div> <!-- end #personalia -->
	    <div id="bottom-wrapper">
	      <div id="attributes">
		<p id="char-str" class="attr-par"><label for="strength">STR:</label><input name="str" id="strength" type="number" value="1" required><label class="modifier" for="strength_modifier">MOD:</label><input name="strMod" id="strength_modifier" type="number" value="0" required></p>
		<p id="char-con" class="attr-par"><label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="1" required><label class="modifier" for="constitution_modifier">MOD:</label><input name="conMod" id="constitution_modifier" type="number" value="0" required></p>
		<p id="char-dex" class="attr-par"><label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="1" required><label class="modifier" for="dexterity_modifier">MOD:</label><input name="dexMod" id="dexterity_modifier" type="number" value="0" required></p>
		<p id="char-int" class="attr-par"><label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="1" required><label class="modifier" for="intelligence_modifier">MOD:</label><input name="intelMod" id="intelligence_modifier" type="number" value="0" required></p>
		<p id="char-wis" class="attr-par"><label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="1" required><label class="modifier" for="wisdom_modifier">MOD:</label><input name="wisMod" id="wisdom_modifier" type="number" value="0" required></p>
		<p id="char-cha" class="attr-par"><label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="1" required><label class="modifier" for="charisma_modifier">MOD:</label><input name="chaMod" id="charisma_modifier" type="number" value="0" required></p>
	      </div> <!-- end #attributes -->
	      <div id="purse">
		<p id="first-purse"><label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="0"></p>
		<p><label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="0"></p>
		<p><label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="0"></p>
	      </div> <!-- end #purse -->
	    </div> <!-- end #bottom-wrapper -->
	    <input id="submit" type="submit" value="Create Character">
	  </form>
	</div> <!-- end .character-entry-form -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

<?php
   session_start();

   require_once $_SESSION['config'];
   ?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Create New Character View</h1>
    <section id="char-create">
      <form name="personalia" action="<?php echo BASE . CONTROLLERS . 'insert-character.php'; ?>" method="POST">
	<fieldset>
	  <legend>Character Personalia</legend>
	  <label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" required>
	  <label for="level">Level:</label><input name="level" id="level" type="number" value="1" required>
	  <label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" required>
	  <label for="hitpoints">HP:</label><input name="hp" id="hitpoints" type="number" value="1" required>
	  <label for="initiativeModifier">Initiative Modifier:</label><input name="init_mod" id="initiativeModifier" type="number" value="0" required>
	</fieldset>
	<fieldset>
	  <legend>Attributes</legend>
	  <label for="strength">STR:</label><input name="str" id="strength" type="number" value="1" required>
	  <label for="strengthModifier">MOD:</label><input name="strMod" id="strenghtModifier" type="number" value="0" required><br/>
	  <label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="1" required>
	  <label for="constitutionModifier">MOD:</label><input name="conMod" id="constitutionModifier" type="number" value="0" required><br/>
	  <label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="1" required>
	  <label for="dexterityModifier">MOD:</label><input name="dexMod" id="dexterityModifier" type="number" value="0" required><br/>
	  <label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="1" required>
	  <label for="intelligenceModifier">MOD:</label><input name="intelMod" id="intelligenceModifier" type="number" value="0" required><br/>
	  <label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="1" required>
	  <label for="wisdomModifier">MOD:</label><input name="wisMod" id="wisdomModifier" type="number" value="0" required><br/>
	  <label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="1" required>
	  <label for="charismaModifier">MOD:</label><input name="chaMod" id="charismaModifier" type="number" value="0" required><br/>
	</fieldset>
	<fieldset>
	  <legend>Purse</legend>
	  <label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="0">
	  <label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="0">
	  <label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="0">
	</fieldset>
	<input type="submit" value="Create Character">
      </form>
    </section> <!-- end #char-create -->
    <section id="navigation">
      <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Member View</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
    </section id="navigation">
  </body>
</html>

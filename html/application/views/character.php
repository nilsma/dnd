<html>
  <head>
    <script type="text/javascript" src="../../js/utils.js"></script>
  </head>

  <body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include '../libs/db_connect.php';
include '../libs/tools.php';

$myid = 3;

$character = array();
$character = getCharacter($mysqli, $myid);
$attrs = $character['attrs'];
$purse = $character['purse'];

?>


<h1>Character view</h1>
    <form name="character">
      Name: <input type="text" name="name" size="10" maxlength="10" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['name']?>"><br/>
      Level: <input type="text" name="level" size="1" maxlength="2" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['level']?>">
      Class: <input type="text" name="cls" size="5" maxlength="5" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['cls']?>"><br/>
      Hitpoints: <input type="text" name="injury" size="1" maxlength="4" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['dmg']?>"> / <input type="text" name="hp" size="1" maxlength="4" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['hp'] ?>"</input><br/><br/>
      Initiative: <input id="init_roll" type="text" name="init_roll" size="1" maxlength="2" onblur="javascript:updateCharacter(forms.character)" value="<?php echo $character['init_roll']?>"><br/><br/>
    </form>

<h1>Attributes</h1>
<form name="attributes">
  Strength: <input type="text" name="str" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['str'] ?>"><br/>
  Constitution: <input type="text" name="con" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['con'] ?>"><br/>
  Dexterity: <input type="text" name="dex" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['dex'] ?>"><br/>
  Intelligence: <input type="text" name="intel" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['intel'] ?>"><br/>
  Wisdom: <input type="text" name="wis" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['wis'] ?>"><br/>
  Charisma: <input type="text" name="cha" size="2" maxlength="5" onblur="javascript:updateAttributes(forms.attributes)" value="<?php echo $attrs['cha'] ?>"><br/>
</form>

<h1>Purse</h1>
<form name="purse">
  Gold: <input type="text" name="gold" size="2" maxlength="5" onblur="javascript:updatePurse(forms.purse)" value="<?php echo $purse['gold'] ?>"><br/>
  Silver: <input type="text" name="silver" size="2" maxlength="5" onblur="javascript:updatePurse(forms.purse)" value="<?php echo $purse['silver'] ?>"><br/>
  Copper: <input type="text" name="copper" size="2" maxlength="5" onblur="javascript:updatePurse(forms.purse)" value="<?php echo $purse['copper'] ?>"><br/>
</form>

  </body>
</html>

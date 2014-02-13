<html>
  <head>
    <script type="text/javascript" src="js/utils.js"></script>
  </head>

  <body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'db_connect.php';
include 'tools.php';

$myid = 3;

$character = array();
$character = getCharacter($mysqli, $myid);

?>

<h1>Character</h1>
    <form name="character" action="javascript:updateCharacter(this['character'])" method="POST">
      Name: <input type="text" name="name" size="10" maxlength="10" value="<?php echo $character['name']?>"><br/>
      Level: <input type="text" name="level" size="1" maxlength="2" value="<?php echo $character['level']?>">
      Class: <input type="text" name="cls" size="5" maxlength="5" value="<?php echo $character['cls']?>"><br/>
      Hitpoints: <input type="text" name="injury" size="1" maxlength="2" value="<?php echo $character['damage_taken']?>"> / <?php echo $character['max_hitpoints']?><br/><br/>
      <input type="submit" value="update">
    </form>

<h1>Attributes</h1>

<h1>Inventory</h1>

<h1>Purse</h1>


  </body>
</html>

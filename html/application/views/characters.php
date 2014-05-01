<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'membersql.class.php';

$db = new Membersql();
$characters = $db->getCharacters($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Characters view</h1>
    <section id="characters">
<?php
if(count($characters) > 0) {
   foreach($characters as $key => $val) {
     echo $val[0] . ' ' . $val[2] . ' ' . $val[1] . '<br/>';
   }
} else {
  echo 'You have not created any characters yet!';
}
?>
      <p><a href="<?php echo BASE . VIEWS . 'create-character.php';?>">Create Character</a></p>
      <p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Member View</a></p>
      <p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>

    </section> <!-- end #characters -->
  </body>
</html>

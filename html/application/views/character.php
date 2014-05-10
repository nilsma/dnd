<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'charsql.class.php';
require_once '../configs/config.php';
require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$char = $csql->getCharacter($sheet_id);
$characterHTML = $csql->buildCharacterHTML($char);

//require_once ROOT . BASE . VIEWS . 'head.php';

?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/char.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="character">
    <div id="main-container">
      <h1>Character View</h1>
      <div id="outer-form-container">
	<?php echo $characterHTML; ?>
      </div> <!-- end #outer-form-container -->
      <section class="sec-nav-container">
<!--	<p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Characters View</a></p>
	<p><a href="<?php echo BASE . CONTROLLERS . 'delete-character.php'; ?>">Delete Character</a></p>
	<p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p> -->
	<p><a href="characters.php">Back to Characters View</a></p>
	<p><a href="../controllers/delete-character.php">Delete Character</a></p>
	<p>or <a href="../controllers/proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

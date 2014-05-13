<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$char = $csql->getCharacter($sheet_id);
$characterHTML = $csql->buildCharacterHTML($char);

if(isset($_SESSION['chosen'])) {
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <script type="text/javascript" src="../../public/js/char.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="character-sheet">
    <div id="main-container">
      <h1>Character View</h1>
      <div id="outer-form-container">
	<?php echo $characterHTML; ?>
      </div> <!-- end #outer-form-container -->
      <section class="sec-nav-container">
	<p><a href="characters.php">Back to Characters View</a></p>
	<p><a href="../views/confirm-delete-character.php">Delete Character</a></p>
	<p>or <a href="../controllers/proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

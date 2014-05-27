<?php
/**
 * A file representing the view for the DND Helper character sheet page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/character.css">
    <link rel="stylesheet" href="../../public/css/navigation.css">
    <script type="text/javascript" src="../../public/js/character.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="character-sheet">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="active-nav main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="confirm-delete-character.php">Delete Character</a></li>
	  <li><a href="member-invitations.php">Manage Invitations</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Character View</h1>
      <div id="inner-container">
	<?php echo $characterHTML; ?>
	<section class="sec-nav-container">
	  <p><a href="characters.php">Back to Characters View</a></p>
	  <p><a href="../views/confirm-delete-character.php">Delete Character</a></p>
	  <p>or <a href="../controllers/proc-logout.php">Logout</a></p>
	</section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

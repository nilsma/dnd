<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/membersql.class.php';
require_once '../models/charsql.class.php';

$db = new Membersql();
$characters = $db->getCharacters($_SESSION['user_id']);

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['chosen'])) {
  header('Location: character.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/characters.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <script type="text/javascript" src="../../public/js/characters.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="characters-overview">
    <header>
      <nav id="nav">
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="create-character.php">Create Character</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Characters view</h1>
      <div id="inner-container">
<?php
if(count($characters) > 0) {
  $csql = new Charsql();
  $html = $csql->buildCharactersList($characters);
  echo $html;
} else {
  echo '<p>You have not created any characters yet!</p>';
}
?>
        <section class="sec-nav-container">
          <p class="nav-paragraph"><a href="member-invitations.php">Manage Invitations</a></p>
	  <p class="nav-paragraph"><a href="member.php">Back to Member View</a></p>
	  <p class="nav-paragraph"><a href="create-character.php">Create Character</a></p>
	  <p class="nav-paragraph">or <a href="../controllers/proc-logout.php">Logout</a></p>
        </section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-contianer -->
  </body>
</html>

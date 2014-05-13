<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
//    header('Location: http://dnd.nima-design.net');
}

require_once '../configs/config.php';
require_once '../models/membersql.class.php';
require_once '../models/gmsql.class.php';

$db = new Membersql();
$gamemasters = $db->getGamemasters($_SESSION['user_id']);

if(isset($_SESSION['sheet_id'])) {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
}

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

if(isset($_SESSION['gm'])) {
  $_SESSION['gm'] = false;
  unset($_SESSION['gm']);
}

//require_once 'head.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
<!--    <script type="text/javascript" src="../../public/js/main.js"></script> -->
<!--    <script type="text/javascript" src="../../public/js/gm.js"></script> -->
    <title>DND Helper</title>
  </head>
  <body id="gamemasters-overview">
    <h1>Gamemasters view</h1>
    <div id="main-container">
      <div id="outer-form-container">
	<div class="form-entry">
<?php
if(count($gamemasters) > 0) {
  $gmsql = new Gmsql();
  $html = $gmsql->buildGamemasterSelect($gamemasters);
  echo $html;
} else {
  echo '<p>You have not created any gamemasters yet!</p>';
}
?>
	</div> <!-- end .form-entry -->
      </div> <!-- end #outer-form-container -->
    <section class="sec-nav-container">
      <p class="nav-paragraph"><a href="member.php">Back to Member View</a></p>
      <p class="nav-paragraph"><a href="create-gamemaster.php">Create Gamemaster</a></p>
      <p>or <a href="../controllers/proc-logout.php">Logout</a></p>
    </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

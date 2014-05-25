<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';

if(!isset($_SESSION['gm_id'])) {
  header('Location: gamemasters.php');
}

$gm_id = $_SESSION['gm_id'];

$gmsql = new Gmsql();

$gm = $gmsql->getGamemaster($gm_id);
$_SESSION['gm'] = $gm;

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
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <link rel="stylesheet" href="../../public/css/edit-gamemaster.css"/>
    <script type="text/javascript" src="../../public/js/edit-gamemaster.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-screen">
    <header>
      <nav>
	<ul>
	  <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="active-nav main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="confirm-delete-gamemaster.php">Delete gamemaster</a></li>
	  <li><a href="gamemaster.php">Back to Gamemaster</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Edit Gamemaster View</h1>
      <div id="inner-container">
        <div class="form-entry">
          <form name="gamemaster" action="../controllers/update-gamemaster.php" method="POST">
            <p><label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" value="<?php echo ucwords($_SESSION['gm']['details']['alias']); ?>" required></p>
            <p><label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlengthx="30" value="<?php echo ucfirst($_SESSION['gm']['campaign']['title']); ?>" required></p>
            <p><input type="submit" value="Update Gamemaster"></p>
          </form>
<?php
$html = '';

if(isset($_SESSION['errors'])) {
   if(count($_SESSION['errors']) >= 1) {
     $html .= '<div id="edited" class="error-report">' . "\n";
     $html .= '<ul class="error-list">' . "\n";

     foreach($_SESSION['errors'] as $error) {
       $html .= '<li>' . $error . '</li>' . "\n";
     }

    $html .= '</ul>' . "\n";
    $html .= '</div> <!-- end #edited -->' . "\n";
  } else {
    $html .= '<div id="edited" class="success-report">' . "\n";
    $html .= '<p>Gamemaster edited!</p>' . "\n";
    $html .= '</div> <!-- end #edited -->' . "\n";
  }

$_SESSION['errors'] = false;
unset($_SESSION['errors']);
}

echo $html;

?>
        </div> <!-- end .form-entry -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

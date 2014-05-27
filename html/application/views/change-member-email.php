<?php
/**
 * A file representing the view for the DND Helper change user email page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/navigation.css"/>
    <link rel="stylesheet" href="../../public/css/change-member.css"/>
    <script type="text/javascript" src="../../public/js/change-member-email.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="change-member-email">
    <header>
      <nav>
	<ul>
	  <li class="active-nav main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg"></a></li>
 	  <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg"></a></li>
	  <li class="main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg"></a></li>
	  <li id="sub-nav-init"><img src="../../public/images/settings_icon32px.jpg"></li>
	</ul>
      </nav>
      <div id="sub-nav-wrapper">
	<ul>
	  <li><a href="edit-member.php">Back to Edit User</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Edit Member View</h1>
      <div id="inner-container">
	<div id="member-entries" class="gui">
	  <form name="change-member-name" action="../controllers/update-member-email.php" method="POST">
	    <p class="gui">Current email: <span id="current-name"><?php echo $_SESSION['email']; ?></span></p>
	    <p class="gui"><label for="new-email-first">New email: </label><input id="new-email-first" name="new-email-first" type="email" maxlength="30" required></p>
	    <p class="gui"><label for="new-email-second">Repeat email: </label><input id="new-email-second" name="new-email-second" type="email" maxlength="30" required></p>
	    <p class="gui"><input type="submit" value="Submit" name="submit"></p>
	  </form>
<?php
if(isset($_SESSION['errors'])) {
   $html = '';
   $html .= '<div id="change-errors" class="error-report">' . "\n";
   $html .= '<ul class="error-list">' . "\n";
   if(count($_SESSION['errors']) >= 1) {
     foreach($_SESSION['errors'] as $error) {
       $html .= '<li>' . $error . '</li>' . "\n";
     }
  }
  $html .= '</ul>' . "\n";
  $html .= '</div> <!-- end #change-errors -->' . "\n";

  echo $html;

  $_SESSION['errors'] = false;
  unset($_SESSION['errors']);
}
?>
	</div> <!-- end #member-entries -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

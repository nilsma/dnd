<?php
/**
 * A file representing the view for the DND Helper edit user information page
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
    <link rel="stylesheet" href="../../public/css/edit-member.css"/>
    <script type="text/javascript" src="../../public/js/edit-member.js"></script>
    <title>DND Helper</title>
  </head>
  <body id="gamemaster-screen">
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
	  <li><a href="member.php">Back to Member</a></li>
	  <li><a href="../controllers/proc-logout.php">Logout</a></li>
	</ul>
      </div>
    </header>
    <div id="main-container">
      <h1>Edit Member View</h1>
      <div id="inner-container">
	<div id="member-entries" class="gui">
	  <form name="change-member-name" action="../views/change-member-name.php" method="POST">
	    <p><span class="member-label">Username: </span><span id="member-name" class="member-value"><?php echo $_SESSION['username']; ?></span><input type="submit" value="Change ..." name="submit-name"></p>
	  </form>
	  <form name="change-member-email" action="../views/change-member-email" method="POST">
	    <p><span class="member-label">Email: </span><span id="member-email" class="member-value"><?php echo $_SESSION['email']; ?></span><input type="submit" value="Change ..." name="submit-email"></p>
	  </form>
	  <form name="change-member-password" action="../views/change-member-password" method="POST">
	    <p><span class="member-label">Password: </span><span id="member-password" class="member-value"> ... </span><input type="submit" value="Change ..." name="submit-password"></p>
	  </form>
<?php
if(isset($_SESSION['success'])) {
  $html = '';
  $html .= '<div id="update-success" class="success-report">' . "\n";
  $html .= '<ul class="success-list">' . "\n";
  if(count($_SESSION['success'] >= 1)) {
    foreach($_SESSION['success'] as $success) {
      $html .= '<li>' . $success . '</li>' . "\n";
    }
  }
  $html .= '</ul>' . "\n";
  $html .= '</div> <!-- end #update-success -->' . "\n";

  $_SESSION['success'] = false;
  unset($_SESSION['success']);  
  echo $html;
}
?>
	</div> <!-- end #member-entries -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

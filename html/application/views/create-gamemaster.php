<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
//    header('Location: http://127.0.1.1/dnd/html/index.php');
    header('Location: http://dnd.nima-design.net');
}

//require_once $_SESSION['config'];
require_once '../configs/config.php';

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

//require_once ROOT . BASE . VIEWS . 'head.php';
require_once 'head.php';

?>
  <body>
    <h1>Create Gamemaster View</h1>
    <div id="main-container">
      <div id="outer-form-container">
	<div class="form-entry">
	  <fieldset>
<!--	    <form name="gamemaster" action="<?php echo BASE . CONTROLLERS . 'insert-gamemaster.php'; ?>" method="POST"> -->
	    <form name="gamemaster" action="../controllers/insert-gamemaster.php" method="POST">
	      <label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" required><br/>
	      <label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlenght="30" required><br/>
	      <input type="submit" value="Create Gamemaster">
	    </form>
	  </fieldset>
	</div> <!-- end .form-entry -->
      </div> <!-- end #outer-form-container -->
        <section class="sec-nav-container">
<!--	<p class="nav-paragraph"><a href="<?php echo BASE . VIEWS . 'gamemasters.php'; ?>">Back to Member View</a></p>
	<p class="nav-paragraph">or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p> -->
	<p class="nav-paragraph"><a href="gamemasters.php">Back to Member View</a></p>
	<p class="nav-paragraph">or <a href="proc-logout.php">Logout</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

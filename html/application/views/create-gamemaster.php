<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

require_once $_SESSION['config'];

if(isset($_SESSION['gm_id'])) {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
}

var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Create New Gamemaster View</h1>
    <section id="gm-create">
      <fieldset>
	<form name="gamemaster" action="<?php echo BASE . CONTROLLERS . 'insert-gamemaster.php'; ?>" method="POST">
	  <label for="alias">Gamemaster Alias:</label><input name="alias" id="alias" type="text" maxlength="30" required>
	  <label for="campaign_name">Campaign Name:</label><input name="campaign_name" id="campaign_name" type="text" maxlenght="30" required>
	  <input type="submit" value="Create Gamemaster">
	</form>
      </fieldset>
    </section>
  </body>
</html>

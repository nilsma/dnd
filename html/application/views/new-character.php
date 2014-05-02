<?php
session_start();
require_once $_SESSION['config'];


?>
<!DOCTYPE html>
<html>
<body>
<h1>New Character View</h1>
<p><a href="<?php echo BASE . VIEWS . 'create-character.php';?>">Create Character</a></p>
<p><a href="<?php echo BASE . VIEWS . 'characters.php'; ?>">Back to Member View</a></p>
<p>or <?php echo '<a href="' . BASE . CONTROLLERS . 'proc-logout.php">Logout</a>' ?></p>
</body>
</html>

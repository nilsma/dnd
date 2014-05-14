<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/logged-out.css">
    <title>DND Helper</title>
  </head>
  <body id="logged-out">
    <div id="main-container">
      <h1>Logged out view</h1>
      <div id="inner-container">
<?php
$html = '';

$html = $html . '        <p>You have been logged out!</p>' . "\n";
$html = $html . '        <p>Visit <a href="http://127.0.1.1/dnd/html/index.php">The Frontpage</a> to log back in.</p>' . "\n";

echo $html;

?>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>

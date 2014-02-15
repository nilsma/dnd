<?php

   include 'db_connect.php';
   include 'tools.php';

   $gm_id = 1;
   $party_id = 1;
?>

<html>
  <head>
    <meta charset="ISO8859-1">
    <link rel="stylesheet" type="text/css" href="style/general.css">
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/functionality.js"></script>
    <script type="text/javascript" src="js/gamemaster.js"></script>
  </head>
  <body>
    <nav>
      <button onclick="javascript:resetInitiative('<?php echo $party_id ?>')">Clear Initiative</button>
    </nav>
    <div id="party_members">
    <?php

       $ids = getPartyMembersId($mysqli, $party_id);

       $members = buildGMScreen($mysqli, $ids);

       echo $members;

       ?>
    </div>
  </body>
</html>

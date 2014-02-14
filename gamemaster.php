<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/general.css">
  </head>
  <body>
    <?php
       include 'db_connect.php';
       include 'tools.php';

       $party_id = 1;
       $ids = getPartyMembersId($mysqli, $party_id);

       $members = buildGMScreen($mysqli, $ids);

       echo $members;

       ?>
  </body>
</html>

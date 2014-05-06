<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
    header('Location: http://127.0.1.1/dnd/html/index.php');
}

include '../libs/db_connect.php';
include '../libs/tools.php';

$gm_id = 1;
$campaign_id = 1;
?>

<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style/general.css">
    <script type="text/javascript" src="../../js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../../js/functionality.js"></script>
    <script type="text/javascript" src="../../js/gamemaster.js"></script>
  </head>
  <body>
    <header>
      <h1>Gamemaster view</h1>
    </header>
    <nav>
      <button onclick="javascript:resetInitiative('<?php echo $campaign_id ?>')">Clear Initiative</button>
    </nav>
    <div id="campaign_members">
    <?php

       $ids = getCampaignMembersIds($mysqli, $campaign_id);

       buildGMScreen($mysqli, $ids);

//       $members = buildGMScreen($mysqli, $ids);

//       echo $members;

       ?>
    </div>
  </body>
</html>

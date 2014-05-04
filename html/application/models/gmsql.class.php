<?php
require_once 'database.class.php';
require_once 'charsql.class.php';
require_once 'mysql.class.php';

if(!class_exists('Gmsql')) {

  class Gmsql extends Database {
    
    public function __construct() { }

    /**
     * A function to build a HTML representation of the given campaigns invitations
     * @param $inv array - an array holding the sheet ids invited to the campaign
     * @param $html string - the HTML representation of the invitations
     */
    public function buildInvHTML($inv) {
      $csql = new Charsql();
      $mysql = new Mysql();

      $html = '';
      $html = $html . '<section id="invitations">' . "\n";
      
      if(count($inv) > 0) {
	foreach($inv as $i) {
	  $invited = $csql->getCharacter($i);
	  $char_name = $invited['sheet']['name'];
	  $username = $mysql->getUsername($invited['sheet']['owner']);

	  $html = $html . '<p>' . ucfirst($username) . 's character ' . $char_name . ' has been invited.</p>' . "\n";
	}
      } else {
	$html = $html . '<p>There are no invitations yet.</p>' . "\n";
      }

      $html = $html . '</section>' . "\n";

      return $html;
    }

    /**
     * A function to build a HTML representation of the given gamemaster's data
     * @param $gm array - an assoc array holding the gamemaster's data
     * @return $gmHTML string - a string representation of the gamemaster's data as HTML
     */
    public function buildGamemasterHTML($gm) {
      $csql = new Charsql();

      $det = $gm['details'];
      $cmp = $gm['campaign'];
      $inv = $gm['invitations'];
      $mbs = $gm['members'];

      $cnt = count($gm['invitations']);
      $noun = null;
      $sbj = null;

      if($cnt <= 1) {
	$noun = 'is';
	$sbj = 'invitation';
      } else {
	$noun = 'are';
	$sbj = 'invitations';
      }

      $html = '';
      
      $html = $html . '<h1>' . $det['alias'] . ' - ' . $cmp['title'] . '</h1>' . "\n";
      $html = $html . '<h2>(There ' . $noun . ' ' . $cnt . ' ' . $sbj . ')</h2>' . "\n";
      $html = $html . '<section id="members">' . "\n";
      $html = $html . '<h2>Members:</h2>' . "\n";
      
      foreach($mbs as $m) {
	$mb = $csql->getCharacter($m);
	//	$mb_html = $csql->buildCharacterHTML($mb);
	$mb_html = $this->buildCharacterHTML($mb);
	$html = $html . $mb_html;
      }
      
      $html = $html . '</section> <!-- end #members -->' . "\n";

      return $html;
    }

    /**
     * A function to build a HTML representation of the character for the gamemaster view
     * @param $characterData array - a multidimensional array holding the character data
     * @return $characterHTML string - a string representation of the characters as HTML
     */
    public function buildCharacterHTML($characterData) {
      $sheet = $characterData['sheet'];
      $attrs = $characterData['attrs'];
      $purse = $characterData['purse'];

      $attrsHTML = $this->buildAttrsHTML($attrs);
      $sheetHTML = $this->buildSheetHTML($sheet, $attrsHTML);
      $purseHTML = $this->buildPurseHTML($purse);

      $html = '';
      $html = $html . '<section class="member">' . "\n";
      $html = $html . $sheetHTML . "\n";
      $html = $html . $attrsHTML . "\n";
      $html = $html . $purseHTML . "\n";
      $html = $html . '</section> <!-- end .member -->' . "\n";

      return $html;

    }

    /**
     * A function to build a HTML representation of the characters sheet for the gamemaster view
     * @param $sheet array - an assoc array holding the sheet data
     * @param $attrsHTML string - a string representation of the characters attributes as HTML
     * @return $html string - a string representation of the characters sheet as HTML
     */
    public function buildSheetHTML($sheet) {
      $sheetHTML = '';
      $sheetHTML = $sheetHTML . '<h3>' . ucfirst($sheet['name']) . ' <span class="initative">Initiative: ' . $sheet['init_roll'] . '</span></h3>' . "\n";
      $sheetHTML = $sheetHTML . '<p>Level: ' . $sheet['level'] . ' ' . ucfirst($sheet['class']) . ' <span class="xp">(xp: ' . $sheet['xp'] . ')</span></p>' . "\n";
      $sheetHTML = $sheetHTML . '<p>Dmg/HP: ' . $sheet['dmg'] . ' / ' . $sheet['hp'] . '</p>';

      $html = '';
      $html = $html . '<section class="personalia">' . "\n";
      $html = $html . $sheetHTML . "\n";
      $html = $html . '</section> <!-- end .personlia -->';
      
      return $html;
    }

    /**
     * A function to build a HTML representation of the characters attributes for the gamemaster view
     * @param $attrs array - an assoc array holding the attributes data
     * @return $html string - a string representation of the characters attributes as HTML
     */
    public function buildAttrsHTML($attrs) {
      $table = '';
      $table = $table . '<table>' . "\n";
      $table = $table . '<caption>Attributes</caption>' . "\n";
      $table = $table . '<thead>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<th scope="col">Ability</th>' . "\n";
      $table = $table . '<th scope="col">Score</th>' . "\n";
      $table = $table . '<th scope="col">Modifier</th>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</thead>' . "\n";
      $table = $table . '<tbody>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>STR</td><td>' . $attrs['str'] . '</td><td>' . $attrs['strMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>CON</td><td>' . $attrs['str'] . '</td><td>' . $attrs['strMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>DEX</td><td>' . $attrs['dex'] . '</td><td>' . $attrs['dexMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>INT</td><td>' . $attrs['intel'] . '</td><td>' . $attrs['intelMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>WIS</td><td>' . $attrs['wis'] . '</td><td>' . $attrs['wis'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>CHA</td><td>' . $attrs['cha'] . '</td><td>' . $attrs['chaMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</tbody>' . "\n";
      $table = $table . '</table>';

      $html = '';
      $html = $html . '<section class="attributes">' . "\n";
      $html = $html . $table . "\n";
      $html = $html . '</section> <!-- end .attributes -->';

      return $html;
    }

    /**
     * A function to build a HTML representation of the characters purse for the gamemaster view
     * @param $purse array - an assoc array holding the purse data
     * @return $html string - a string representation of the characters purse as HTML
     */
    public function buildPurseHTML($purse) {
      $table = '';
      $table = $table . '<table>' . "\n";
      $table = $table . '<caption>Purse</caption>' . "\n";
      $table = $table . '<thead>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<th scope="col">Currency</th>' . "\n";
      $table = $table . '<th scope="col">Amount</th>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</thead>' . "\n";
      $table = $table . '<tbody>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Gold:</td><td>' . $purse['gold'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Silver:</td><td>' . $purse['silver'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Copper:</td><td>' . $purse['copper'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</tbody>' . "\n";
      $table = $table . '</table>';


      $html = '';
      $html = $html . '<section class="purse">' . "\n";
      $html = $html . $table . "\n";
      $html = $html . '</section> <!-- end .purse -->';

      return $html;
    }

    /**
     * A function to get gamemaster details as a multidimensional array
     * @param $gm_id int - the gamemaster id
     * @return $gm array - a multidimensional array holding assoc arrays for the gamemaster
     */
    public function getGamemaster($gm_id) {
      $details = array();
      $campaign = array();
      $invitations = array();
      $members = array();

      $details = $this->getGamemasterDetails($gm_id);
      $campaign = $this->getGamemasterCampaign($gm_id);
      $invitations = $this->getCampaignInvitations($campaign['id']);
      $members = $this->getCampaignMembers($campaign['id']);

      $gm = array(
		  'details' => $details,
		  'campaign' => $campaign,
		  'invitations' => $invitations,
		  'members' => $members
		  );

      return $gm;
    }

    /**
     * A function to get the campaigns members
     * @param $campaign_id int - the campaign's id
     * @return $members array - an array holding id of the campaings members
     */
    public function getCampaignMembers($campaign_id) {
      $mysqli = $this->connect();

      $members = array();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT sheet FROM members WHERE campaign=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $campaign_id);
	$stmt->execute();
	$stmt->bind_result($sheet_id);

	while($stmt->fetch()) {
	  $members[] = $sheet_id;
	}
	
	$stmt->close();
      }

      $mysqli->close();
      return $members;

    }    

    /**
     * A function to get the campaigns pending invitations
     * @param $campaign_id int - the campaign's id
     * @return $invitations array - an array holding id of the invited sheets
     */
    public function getCampaignInvitations($campaign_id) {
      $mysqli = $this->connect();

      $invitations = array();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT sheet FROM invitations WHERE campaign=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $campaign_id);
	$stmt->execute();
	$stmt->bind_result($sheet_id);

	while($stmt->fetch()) {
	  $invitations[] = $sheet_id;
	}
	
	$stmt->close();
      }

      $mysqli->close();
      return $invitations;

    }
      

    /**
     * A function to get the gamemaster's campaign details
     * @param $gm_id int - the gamemaster's id
     * @return $campaign array - an assoc array holding the campaing details
     */
    public function getGamemasterCampaign($gm_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT id, title FROM campaigns WHERE gamemaster=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $gm_id);
	$stmt->execute();
	$stmt->bind_result($id, $title);
	$stmt->fetch();

	$campaign = array(
			  'id' => $id,
			  'title' => $title
			  );
	
	$stmt->close();
      }

      $mysqli->close();
      return $campaign;

    }

    /**
     * A function to get the gamemasters details
     * @param $gm_id int - the id of the gamemaster to get the details for
     * @result $gm array - an assoc array holding the gamemaster details
     */
    public function getGamemasterDetails($gm_id) {
      $mysqli = $this->connect();
      
      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT owner, alias FROM gamemasters WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $gm_id);
	$stmt->execute();
	$stmt->bind_result($owner, $alias);
	$stmt->fetch();
	
	$gm = array(
		    'owner' => $owner,
		    'alias' => $alias
		    );
	
	$stmt->close();
      }

      $mysqli->close();
      return $gm;

    }

    /**
     * A function to get the id of a given gamemaster based on the gamemasters alias
     * @param $alias string - the alias of the gamemaster to get the id for
     * @param $user_id int - the id of the user fetching the character
     * @return $gm_id int - the id of the gamemaster
     */
    public function getGamemasterId($alias, $user_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT id FROM gamemasters WHERE alias=? AND owner=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('si', $alias, $user_id);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();

	$stmt->close();
	
	return $id;
      }
      
      $mysqli->close();
    }

    /**
     * A function to build the form for character selection
     * @param $characters array - an array holding the characters to list in the form
     */
    public function buildGamemasterSelect($gms) {
      $html = '';

      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Select Gamemaster</legend>' . "\n";
      $html = $html . '<form name="gm-select" action="' . BASE . CONTROLLERS . 'load-gamemaster.php" method="POST">' . "\n";
      $html = $html . '<select name="gamemaster">' . "\n";
      foreach($gms as $gm) {
        $html = $html . '<option value="' . $gm . '">' . ucfirst($gm) . '</option>' . "\n";
      }
      $html = $html . '</select>' . "\n";
      $html = $html . '<input type="submit" value="Play">' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;
    }
    
    /**
     * A function to insert a new gamemaster in the database
     * @param $gm array - an array holding the gamemasters' entries
     * @return $gm_id int - the id of the inserted gamemaster entry
     */
    public function insertGamemaster($gm) {
      $gm_id = null;
      $alias = $gm['alias'];
      $owner = $gm['owner'];
      $title = $gm['campaign'];

      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      try {
	$mysqli->autocommit(FALSE);

	//begin insert gamemasters table
	$query = "INSERT INTO gamemasters(id, owner, alias) VALUES(null, ?, ?)";
	$query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error . ' || ' . $mysqli->errno);
        }
	
	$stmt->bind_param('is', $owner, $alias);
	$stmt->execute();
	$gm_id = $mysqli->insert_id;
	$stmt->close();

	//begin insert campaigns table
	$query = "INSERT INTO campaigns(id, gamemaster, title) VALUES(null, ?, ?)";
	$query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }
	
	$stmt->bind_param('is', $gm_id, $title);
	$stmt->execute();
	$stmt->close();

	$mysqli->commit();

      } catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
	echo 'Caught exception: ' . $e->getMessage();

      }

      $mysqli->close();
      return $gm_id;
    }
  }

}


?>
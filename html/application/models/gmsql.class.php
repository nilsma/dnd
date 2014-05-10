<?php
require_once 'database.class.php';
require_once 'charsql.class.php';
require_once 'mysql.class.php';

if(!class_exists('Gmsql')) {

  class Gmsql extends Database {
    
    public function __construct() { }

    /**
     * A function to remove a member participation in a campaign from the database members table
     * @param name string - the name of the character to remove from invitations
     * @param $cmp_id int - the campaign id
     */
    public function removeMember($name, $cmp_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "DELETE FROM members USING members, sheets WHERE members.sheet=sheets.id AND sheets.name=? AND members.campaign=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('si', $name, $cmp_id);
	$stmt->execute();
	
	$stmt->close();
      }

      $mysqli->close();
      
    }

    /**
     * A function to remove an invitation from the database
     * @param name string - the name of the character to remove from invitations
     * @param gm_id int - the id of the gamemaster who owns the given campaign id
     * @param $cmp_id int - the campaign id
     */
    public function removeInvitation($name, $gm_id, $cmp_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "DELETE FROM invitations USING invitations, sheets WHERE sheets.id=invitations.sheet AND invitations.gamemaster=? AND invitations.campaign=? AND sheets.name=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('iis', $gm_id, $cmp_id, $name);
	$stmt->execute();
	
	$stmt->close();
      }

      $mysqli->close();
      
    }

    /**
     * A function to set the inititives to 1 for all members of a given campaign
     * @param $cmp_id int - the campaign id
     */
    public function resetInitiatives($cmp_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "UPDATE sheets s, members m, campaigns c SET s.init_roll=1 WHERE s.id=m.sheet AND m.campaign=c.id AND c.id=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $cmp_id);
	$stmt->execute();
	
	$stmt->close();
      }

      $mysqli->close();
      
    }

    /**
     *	A function to build a HTML representation of the invtations
     * and a members overview for the invitations page
     * @param $inv array - an array holding the id's of the sheets that are invited
     * @return $html string - the HTML representation of the invitations
     */
    public function buildInvHTML($inv, $members) {
      $invite = $this->buildInvite(); 
      $invitations = $this->buildInvitations($inv);
      $members = $this->buildMembers($members);

      $html = '';
      $html = $html . $invite;
      $html = $html . $invitations;
      $html = $html . $members;
      
      return $html;
      
    }

    /**
    * A function to build an HTML representation of the create invite form for the gamemaster
    * @return $html string - the HTML representation of the form
    */
    public function buildInvite() {
      $html = '';
      $html = $html . '<section id="invite">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>Create Invitation</h2>' . "\n";
      $html = $html . '</div>' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Create Invitation</legend>' . "\n";
      $html = $html . '<form name="create-invite" action="../controllers/invite-character.php" method="POST">' . "\n";
      $html = $html . '<label for="users-name">Users Name</label><input name="users-name" id="users-name" type="text" maxlength="30" required><br/>' . "\n";
      $html = $html . '<label for="characters-name">Characters Name</label><input name="characters-name" id="characters-name" type="text" maxlength="30" required><br/>' . "\n";
      $html = $html . '<input type="submit" value="submit">' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";
      $html = $html . '</div>' . "\n";
      $html = $html . '</section> <!-- end #invite -->' . "\n";

      return $html;
    }

     /**
     * A function to build a HTML representation of the given campaigns invitations
     * @param $inv array - an array holding the sheet ids invited to the campaign
     * @param $html string - the HTML representation of the invitations
     */
     public function buildMembers($members) {
       $csql = new Charsql();

       $html = '';
       $html = $html . '<section id="current-members">' . "\n";
       $html = $html . '<div>' . "\n";
       $html = $html . '<h2>Current Members</h2>' . "\n";
       $html = $html . '</div>' . "\n";

      if(count($members) > 0) {
       foreach($members as $member) {
         $name = $csql->getCharacterName($member);
	 
	 $html = $html . '<section class="current-member">' . "\n";
	 $html = $html . '<p><span class="char-name">' . ucwords($name) . '</span></p><button class="remove-member">Remove Member</button>' . "\n";
	 $html = $html . '</section> <!-- end .current-member -->' . "\n";
	 
       }

      } else {
        $html = $html . '<section class="current-member">' . "\n";
	$html = $html . '<p>There are no members yet.</p>' . "\n";
	$html = $html . '</section> <!-- end .member -->' . "\n";

      }

       $html = $html . '</section> <!-- end #current-members -->' . "\n";

       return $html;
     }


    /**
     * A function to build a HTML representation of the given campaigns invitations
     * @param $inv array - an array holding the sheet ids invited to the campaign
     * @param $html string - the HTML representation of the invitations
     */
    public function buildInvitations($inv) {
      $csql = new Charsql();
      $mysql = new Mysql();

      $html = '';
      $html = $html . '<section id="invitations">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>Pending Invitations</h2>' . "\n";
      $html = $html . '</div>' . "\n";
      
      if(count($inv) > 0) {
	foreach($inv as $i) {
	  $invited = $csql->getCharacter($i);
	  $char_name = $invited['sheet']['name'];
	  $username = $mysql->getUsername($invited['sheet']['owner']);
	  
	  $html = $html . '<section class="invitation">' . "\n";
	  $html = $html . '<p><span class="user-name">' . ucfirst($username) . 's</span> character <span class="char-name">' . $char_name . '</span> has been invited.</p>';
	  $html = $html . '<button class="remove-inv">Remove Invitation</button>' . "\n";
	  $html = $html . '</section> <!-- end .invitation -->' . "\n";
	}
      } else {
        $html = $html . '<section class="invitation">' . "\n";
	$html = $html . '<p>There are no invitations yet.</p>' . "\n";
	$html = $html . '</section> <!-- end .invitation -->' . "\n";
      }

      $html = $html . '</section> <!-- end invitations -->' . "\n";

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
      $members = $gm['members'];

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
      
      $html = $html . '<section id="gm-details">' . "\n";
      $html = $html . '<h2>' . ucfirst($det['alias']) . ' - ' . ucfirst($cmp['title']) . '</h2>' . "\n";
      //      $html = $html . '<h3>(There ' . $noun . ' ' . $cnt . ' ' . $sbj . ')</h3>' . "\n";
      $html = $html . '</section> <!-- end #gm-details -->' . "\n";
      $html = $html . '<section id="tools">' . "\n";
      $html = $html . '<button id="reset-init">Reset Initiatives</button>' . "\n";
      $html = $html . '<button id="close-all">Close All</button>' . "\n";
      $html = $html . '</section>' . "\n";
      $html = $html . '<section id="members">' . "\n";
      $html = $html . '<h3>Members:</h3>' . "\n";
      
      foreach($members as $m) {
	$mb = $csql->getCharacter($m);
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
      $sheetHTML = $sheetHTML . '<p>Level: <span class="level">' . $sheet['level'] . '</span> <span class="class">' . ucwords($sheet['class']) . '</span> (XP: <span class="xp">' . $sheet['xp'] . '</span>)</p>' . "\n";

      $html = '';
      $html = $html . '<div class="trigger">' . "\n";
      $html = $html . '<div class="name">' . "\n";
      $html = $html . '<h4 class="char_name">' . ucwords($sheet['name']) . '</h4>' . "\n";
      $html = $html . '</div> <!-- end .name -->' . "\n";
      $html = $html . '<div class="inner-head-wrapper">' . "\n";
      $html = $html . '<div class="initiative">' . "\n";
      $html = $html . '<h4><span class="label">Initiative: </span><span class="init_roll">' . $sheet['init_roll'] . '</span></h4>' . "\n";
      $html = $html . '</div> <!-- end .initiative -->' . "\n";
      $html = $html . '<div class="health">' . "\n";
      $html = $html . '<h4><span class="label">HP:</span><span class="remainder"><span class="dmg">' . $sheet['dmg'] . '</span> / <span class="hitpoints">' . $sheet['hp'] . '</span></span></h4>' . "\n";
      $html = $html . '</div> <!-- end .health -->' . "\n";
      $html = $html . '</div> <!-- end .inner-head-wrap -->' . "\n";
      $html = $html . '</div> <!-- end .trigger -->' . "\n";
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
      $table = $table . '<table class="char-table">' . "\n";
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
      $table = $table . '<td>STR</td><td class="str">' . $attrs['str'] . '</td><td class="str_mod">' . $attrs['strMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>CON</td><td class="con">' . $attrs['con'] . '</td><td class="con_mod">' . $attrs['conMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>DEX</td><td class="dex">' . $attrs['dex'] . '</td><td class="dex_mod">' . $attrs['dexMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>INT</td><td class="intel">' . $attrs['intel'] . '</td><td class="intel_mod">' . $attrs['intelMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>WIS</td><td class="wis">' . $attrs['wis'] . '</td><td class="wis_mod">' . $attrs['wisMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>CHA</td><td class="cha">' . $attrs['cha'] . '</td><td class="cha_mod">' . $attrs['chaMod'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</tbody>' . "\n";
      $table = $table . '</table>';

      $html = '';
      $html = $html . '<section class="attributes">' . "\n";
      $html = $html . '<h5>Attributes</h5>' . "\n";
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
      $table = $table . '<table class="char-table">' . "\n";
      $table = $table . '<caption>Purse</caption>' . "\n";
      $table = $table . '<thead>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<th scope="col">Currency</th>' . "\n";
      $table = $table . '<th scope="col">Amount</th>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</thead>' . "\n";
      $table = $table . '<tbody>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Gold:</td><td class="gold">' . $purse['gold'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Silver:</td><td class="silver">' . $purse['silver'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '<tr>' . "\n";
      $table = $table . '<td>Copper:</td><td class="copper">' . $purse['copper'] . '</td>' . "\n";
      $table = $table . '</tr>' . "\n";
      $table = $table . '</tbody>' . "\n";
      $table = $table . '</table>';


      $html = '';
      $html = $html . '<section class="purse">' . "\n";
      $html = $html . '<h5>Purse</h5>' . "\n";
      $html = $html . $table . "\n";
      $html = $html . '</section> <!-- end .purse -->';

      return $html;
    }

    /**
     * A function to get a character's stats
     * @param $char_id int - the character's id
     * @return $character array - a multidimensional array holding the character's stats
     */
    public function getCharacterStats($char_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $sheet_data = array();
      $attrs_data = array();
      $purse_data = array();
      $return_data = array();

      $query = "SELECT s.name, s.level, s.xp, s.class, s.init_mod, s.init_roll, s.hp, s.dmg, a.str, a.str_mod, a.con, a.con_mod, a.dex, a.dex_mod, a.intel, a.intel_mod, a.wis, a.wis_mod, a.cha, a.cha_mod, p.gold, p.silver, p.copper FROM sheets as s, attrs as a, purse as p WHERE s.id=? AND s.purse=p.id AND s.attr=a.id";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $char_id);
	$stmt->execute();
	$stmt->bind_result($name, $level, $xp, $class, $init_mod, $init_roll, $hp, $dmg, $str, $str_mod, $con, $con_mod, $dex, $dex_mod, $intel, $intel_mod, $wis, $wis_mod, $cha, $cha_mod, $gold, $silver, $copper);

	while($stmt->fetch()) {
	  $sheet_data = array(
			      'name' => ucwords($name),
			      'level' => $level,
			      'xp' => $xp,
			      'class' => ucfirst($class),
			      'init_mod' => $init_mod,
			      'init_roll' => $init_roll,
			      'hp' => $hp,
			      'dmg' => $dmg
			      );

	  $attrs_data = array(
			      'str' => $str,
			      'str_mod' => $str_mod,
			      'con' => $con,
			      'con_mod' => $con_mod,
			      'dex' => $dex,
			      'dex_mod' => $dex_mod,
			      'intel' => $intel,
			      'intel_mod' => $intel_mod,
			      'wis' => $wis,
			      'wis_mod' => $wis_mod,
			      'cha' => $cha,
			      'cha_mod' => $cha_mod
			      );

	  $purse_data = array(
			      'gold' => $gold,
			      'silver' => $silver,
			      'copper' => $copper
			      );

	  $return_data = array(
			       'sheet' => $sheet_data,
			       'attrs' => $attrs_data,
			       'purse' => $purse_data
			       );

	}
	
	$stmt->close();
      }

      $mysqli->close();
      return $return_data;

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
      $html = $html . '<form name="gm-select" action="../controllers/load-gamemaster.php" method="POST">' . "\n";
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

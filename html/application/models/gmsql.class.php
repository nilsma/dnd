<?php
/**
 * A models file for the DND Helper that defines and handles functions related to 
 * operation on and by the application's gamemasters
 * @author Nils Martinussen
 * @created 2014-05-25
 */
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html/');
}

require_once 'database.class.php';
require_once 'charsql.class.php';
require_once 'mysql.class.php';

if(!class_exists('Gmsql')) {

  class Gmsql extends Database {
    
    public function __construct() { }

    /**
     * A function to delete a gamemaster and subsequently it's campaigns
     * and all invitations and memberships related to that campaing - this
     * will not delete the actual sheets (characters) from the application database
     * @param $user_id int - the id of the gamemaster's owner
     * @param $gm_id int - the id of the gamemaster
     * @param $cmp_id int - the id of the gamemaster's related campaign
     * @return int - the number of affected rows in the database
     */
    public function deleteGamemaster($user_id, $gm_id, $cmp_id) {
      $mysqli = $this->connect();

      try {
        $mysqli->autocommit(FALSE);

        //begin delete memberships
	$query = "DELETE FROM members USING members, campaigns, gamemasters, users WHERE members.campaign=campaigns.id AND campaigns.id=? AND campaigns.gamemaster=gamemasters.id AND gamemasters.id=? AND gamemasters.owner=users.id AND users.id=?";
        $query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }

        $stmt->bind_param('iii', $cmp_id, $gm_id, $user_id);
        $stmt->execute();
        $stmt->close();

       //begin delete invitations
	$query = "DELETE FROM invitations USING invitations, campaigns, gamemasters, users WHERE invitations.campaign=campaigns.id AND campaigns.id=? AND campaigns.gamemaster=gamemasters.id AND gamemasters.id=? AND gamemasters.owner=users.id AND users.id=?";
        $query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }

	$stmt->bind_param('iii', $cmp_id, $gm_id, $user_id);
        $stmt->execute();
        $stmt->close();

       //begin delete campaigns
        $query = "DELETE FROM campaigns USING campaigns, gamemasters, users WHERE campaigns.id=? AND campaigns.gamemaster=gamemasters.id AND gamemasters.id=? AND gamemasters.owner=users.id AND users.id=?";
        $query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }

        $stmt->bind_param('iii', $cmp_id, $gm_id, $user_id);
        $stmt->execute();
        $stmt->close();

       //begin delete gamemasters
        $query = "DELETE FROM gamemasters USING gamemasters, users WHERE gamemasters.id=? AND gamemasters.owner=users.id AND users.id=?";
        $query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }

        $stmt->bind_param('ii', $gm_id, $user_id);
        $stmt->execute();
        $stmt->close();

        $mysqli->commit();

      } catch(Exception $e) {
        $mysqli->rollback();
        $mysqli->autocommit(TRUE);
        echo 'Caught exception: ' . $e->getMessage();
      }

      $mysqli->close();
    }

    /**
     * A function to check if a given gamemaster alias already exists
     * @param $user_id int - the user's id
     * @param $alias string - the gamemaster alias
     * @return boolean - returns true if the alias exists, false otherwise
     */
     public function aliasExists($user_id, $alias) {
      $mysqli = $this->connect();
      
      $query = "SELECT * FROM users as u, gamemasters as g WHERE u.id=? AND u.id=g.owner AND g.alias=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('is', $user_id, $alias);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$num_rows = $stmt->num_rows;

	if($num_rows >= 1) {
	  return true;
	} else {
	  return false;
	}
      }
      $stmt->close();
      $mysqli->close();
     }

    /**
     * A function to check if a given membership already exists
     * @param $sheet_id int - the sheet id
     * @param $cmp_id int - the campaign id
     * @return boolean - returns true if the invitation exists, false otherwise
     */
     public function membershipExists($sheet_id, $cmp_id) {
      $mysqli = $this->connect();
      
      $query = "SELECT * FROM members WHERE sheet=? AND campaign=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('ii', $sheet_id, $cmp_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$num_rows = $stmt->num_rows;

	if($num_rows >= 1) {
	  return true;
	} else {
	  return false;
	}
      }
      $stmt->close();
      $mysqli->close();
     }

    /**
     * A function to check if a given invite already exists
     * @param $gm_id int - the gamemaster id
     * @param $sheet_id int - the sheet id
     * @param $cmp_id int - the campaign id
     * @return boolean - returns true if the invitation exists, false otherwise
     */
     public function invitationExists($gm_id, $sheet_id, $cmp_id) {
      $mysqli = $this->connect();
      
      $query = "SELECT * FROM invitations WHERE gamemaster=? AND sheet=? AND campaign=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('iii', $gm_id, $sheet_id, $cmp_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$num_rows = $stmt->num_rows;

	if($num_rows >= 1) {
	  return true;
	} else {
	  return false;
	}
      }
      $stmt->close();
      $mysqli->close();
     }

    /**
     * A function to add an entry to the invitations table of the database
     * @param $gm_id int - the gamemaster id of the owner of the campaign
     * @param $sheet_id int - the sheet id of the character to invite
     * @param $cmp_id int - the id of the campaign to invite to
     */
    public function createInvite($gm_id, $sheet_id, $cmp_id) {
      $mysqli = $this->connect();

      $query = "INSERT INTO invitations (gamemaster, sheet, campaign) VALUES(?, ?, ?)";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('iii', $gm_id, $sheet_id, $cmp_id);
	$stmt->execute();
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to remove a member participation in a campaign from the database members table
     * @param name string - the name of the character to remove from invitations
     * @param $cmp_id int - the campaign id
     */
    public function removeMember($name, $cmp_id) {
      $mysqli = $this->connect();

      $query = "DELETE FROM members USING members, sheets WHERE members.sheet=sheets.id AND sheets.name=? AND members.campaign=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('si', $name, $cmp_id);
	$stmt->execute();
      }

      $stmt->close();
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

      $query = "DELETE FROM invitations USING invitations, sheets WHERE sheets.id=invitations.sheet AND invitations.gamemaster=? AND invitations.campaign=? AND sheets.name=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('iis', $gm_id, $cmp_id, $name);
	$stmt->execute();
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to update a gamemaster's alias and a campaign's title
     * @param $gm_id int - the gamemaster id
     * @param $cmp_id int - the campaign id
     * @param $alias string - the gamemaster's new alias
     * @param $title string - the campaign's new title
     */
    public function updateGamemaster($gm_id, $cmp_id, $alias, $title) {
      $mysqli = $this->connect();

      $query = "UPDATE gamemasters, campaigns SET gamemasters.alias=?, campaigns.title=? WHERE gamemasters.id=? AND campaigns.id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('ssii', $alias, $title, $gm_id, $cmp_id);
	$stmt->execute();
      }
	
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to set the inititives to 1 for all members of a given campaign
     * @param $cmp_id int - the campaign id
     */
    public function resetInitiatives($cmp_id) {
      $mysqli = $this->connect();

      $query = "UPDATE sheets s JOIN members m ON s.id=m.sheet AND m.campaign=? SET s.init_roll=1;";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $cmp_id);
	$stmt->execute();
      }
	
      $stmt->close();
      $mysqli->close();
    }

    /**
     *	A function to build a HTML representation of the invtations
     * and a members overview for the invitations page
     * @param $inv array - an array holding the id's of the sheets that are invited
     * @param $members array - an array holding the id's of the sheets already member of the gamemaster's campaign
     * @param $inv_errors array - an array holding the errors reported while trying to add invitation as strings
     * @return $html string - the HTML representation of the invitations
     */
    public function buildInvHTML($inv, $members, $inv_errors) {
      $invite = $this->buildInvite($inv_errors); 
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
    * @param $inv_errors array - an array holding the errors reported while trying to add invitation as strings
    * @return $html string - the HTML representation of the form
    */
    public function buildInvite($inv_errors) {
      $html = '';

      $html = $html . '<section id="invite">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>Create Invitation</h2>' . "\n";
      $html = $html . '</div>' . "\n";
      $html = $html . '<div class="gui">' . "\n";
      $html = $html . '<legend>Create Invitation</legend>' . "\n";
      $html = $html . '<form name="create-invite" action="../controllers/invite-character.php" method="POST">' . "\n";
      $html = $html . '<p><label for="users-name">Users Name: </label><input name="users-name" id="users-name" type="text" maxlength="30" required></p>' . "\n";
      $html = $html . '<p><label for="characters-name">Characters Name: </label><input name="characters-name" id="characters-name" type="text" maxlength="30" required></p>' . "\n";
      $html = $html . '<p><input type="submit" value="Invite"></p>' . "\n";
      $html = $html . '</form>' . "\n";

      if(!empty($inv_errors)) {
	$html = $html . '<div id="inv-failed" class="error-report">' . "\n";
	$html = $html . '<p>The invitation failed:</p>' . "\n";
	$html = $html . '<ul class="error-list">' . "\n";

	foreach($inv_errors as $error) {
	  $html = $html . '<li>' . $error . '</li>' . "\n";
	}

	$html = $html . '</ul>' . "\n";
	$html = $html . '</div> <!-- end #inv-failed -->' . "\n";
      }

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
       $html = '';

       $html = $html . '<section id="current-members" class="gui">' . "\n";
       $html = $html . '<div>' . "\n";
       $html = $html . '<h2>Current Members</h2>' . "\n";
       $html = $html . '</div>' . "\n";

       if(count($members) > 0) {
	 $csql = new Charsql();
	 foreach($members as $member) {
	   $name = $csql->getCharacterName($member);
	 
	   $html = $html . '<section class="current-member">' . "\n";
	   $html = $html . '<p class="gui"><span class="char-name">' . ucwords($name) . '</span></p>' . "\n";
	   $html = $html . '<p class="gui"><button class="remove-member">Remove Member</button></p>' . "\n";
	   $html = $html . '</section> <!-- end .current-member -->' . "\n";
	 }
       } else {
	 $html = $html . '<section class="current-member">' . "\n";
	 $html = $html . '<p class="gui">There are no members yet.</p>' . "\n";
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
      $html = '';

      $html = $html . '<section class="gui" id="invitations">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>Pending Invitations</h2>' . "\n";
      $html = $html . '</div>' . "\n";
      
      if(count($inv) > 0) {
	$csql = new Charsql();
	$mysql = new Mysql();
	foreach($inv as $i) {
	  $invited = $csql->getCharacter($i);
	  $char_name = $invited['sheet']['name'];
	  $username = $mysql->getUsername($invited['sheet']['owner']);
	  
	  $html = $html . '<section class="invitation">' . "\n";
	  $html = $html . '<p class="gui"><span class="user-name">' . ucfirst($username) . '</span>\'s character <span class="char-name">' . $char_name . '</span> has been invited.</p>';
	  $html = $html . '<p class="gui"><button class="remove-inv">Remove Invitation</button></p>' . "\n";
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
      $det = $gm['details'];
      $cmp = $gm['campaign'];
      $inv = $gm['invitations'];
      $members = $gm['members'];

      $html = '';
      
      $html = $html . '<section id="gamemaster-details">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>' . ucfirst($det['alias']) . ' - ' . ucfirst($cmp['title']) . '</h2>' . "\n";
      $html = $html . '</div>' . "\n";
      $html = $html . '</section> <!-- end #gamemaster-details -->' . "\n";
      $html = $html . '<section id="gamemaster-tools">' . "\n";
      $html = $html . '<button id="reset-init">Reset Initiatives</button>' . "\n";
      $html = $html . '<button id="close-all">Close All</button>' . "\n";
      $html = $html . '</section> <!-- end #gamemaster-tools -->' . "\n";
      $html = $html . '<section id="campaign-members">' . "\n";
      $html = $html . '<h3>Members:</h3>' . "\n";
      
      if(count($members) > 0) {
	$csql = new Charsql();
	foreach($members as $m) {
	  $member = $csql->getCharacter($m);
	  $member_html = $this->buildCharacterHTML($member);
	  $html = $html . $member_html;
	}
      } else {
	$html = $html . '<section class="campaign-member">' . "\n";
	$html = $html . '<p>There are no members of this campaign yet!</p>' . "\n";
	$html = $html . '</section> <!-- end .campaign-member -->' . "\n";
      }
      
      $html = $html . '</section> <!-- end #campaign-members -->' . "\n";

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

      $html = $html . '<section class="campaign-member">' . "\n";
      $html = $html . $sheetHTML . "\n";
      $html = $html . $attrsHTML . "\n";
      $html = $html . $purseHTML . "\n";
      $html = $html . '</section> <!-- end .campaign-member -->' . "\n";

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
      $html = $html . '<div class="name">' . "\n";
      $html = $html . '<h4 class="char_name">' . ucwords($sheet['name']) . '</h4>' . "\n";
      $html = $html . '</div> <!-- end .name -->' . "\n";
      $html = $html . '<div class="details-wrapper">' . "\n";
      $html = $html . '<h4><span class="label">Initiative: </span><span class="init_roll">' . $sheet['init_roll'] . '</span></h4>' . "\n";
      $html = $html . '<h4><span class="label">HP: </span><span class="remainder"><span class="dmg">' . $sheet['dmg'] . '</span> / <span class="hitpoints">' . $sheet['hp'] . '</span></span></h4>' . "\n";
      $html = $html . '</div> <!-- end .details-wrapper -->' . "\n";
      $html = $html . '<section class="personalia">' . "\n";
      $html = $html . $sheetHTML;
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
      $table = $table . '<th scope="col">Mod</th>' . "\n";
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
      $html = $html . '<div class="char-table">' . "\n";
      $html = $html . $table . "\n";
      $html = $html . '</div>' . "\n";
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
      $html = $html . '<div class="char-table">' . "\n";
      $html = $html . $table . "\n";
      $html = $html . '</div>' . "\n";
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

      $sheet_data = array();
      $attrs_data = array();
      $purse_data = array();
      $return_data = array();

      $query = "SELECT s.name, s.level, s.xp, s.class, s.init_mod, s.init_roll, s.hp, s.dmg, a.str, a.str_mod, a.con, a.con_mod, a.dex, a.dex_mod, a.intel, a.intel_mod, a.wis, a.wis_mod, a.cha, a.cha_mod, p.gold, p.silver, p.copper FROM sheets as s, attrs as a, purse as p WHERE s.id=? AND s.purse=p.id AND s.attr=a.id";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
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
      }
      $stmt->close();
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

      $query = "SELECT sheet FROM members WHERE campaign=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
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

      $query = "SELECT sheet FROM invitations WHERE campaign=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
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

      $query = "SELECT id, title FROM campaigns WHERE gamemaster=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $gm_id);
	$stmt->execute();
	$stmt->bind_result($id, $title);
	$stmt->fetch();

	$campaign = array(
			  'id' => $id,
			  'title' => $title
			  );
      }
      $stmt->close();
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

      $query = "SELECT owner, alias FROM gamemasters WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $gm_id);
	$stmt->execute();
	$stmt->bind_result($owner, $alias);
	$stmt->fetch();
	
	$gm = array(
		    'owner' => $owner,
		    'alias' => $alias
		    );
      }

      $stmt->close();
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

      $query = "SELECT id FROM gamemasters WHERE alias=? AND owner=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('si', $alias, $user_id);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();
	
	return $id;
      }
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to build an HTML representation of the gamemasters overview list
     * @param $gamemasters array - an array holding the gamemaster's details
     */
    public function buildGamemasterList($gamemasters) {
      $html = '';

      $html = $html . '<section id="gamemasters">' . "\n";
      $html = $html . '<div>' . "\n";
      $html = $html . '<h2>Gamemasters</h2>' . "\n";
      $html = $html . '</div>' . "\n";

      if(count($gamemasters) > 0) {
	foreach($gamemasters as $gm) {
	  $html = $html . '<section class="gamemaster-entry">' . "\n";
	  $html = $html . '<p><span class="gamemaster-entry-alias">' . ucwords($gm['alias']) . '</span> with the "<span class="gamemaster-entry-campaign">' . ucwords($gm['title']) . '"</span> campaign</p>' . "\n";
	  $html = $html . '</section> <!-- end .gamemaster-entry -->' . "\n";
	}
      } else {
	$html = $html . '<section class="gamemaster-entry">' . "\n";
	$html = $html . '<p>You have not made any gamemasters yet!</p>' . "\n";
	$html = $html . '</section> <!-- end .gamemaster-entry -->' . "\n";
      }

      $html = $html . '</section> <!-- end #gamemasters -->' . "\n";

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

    /**
     * A function to get the campaign id of a campaign from the database
     * @param $alias string - the alias of the campaign's owning gm
     * @param $title string - the title of the campaign
     * @return $cmp_id int - the campaign id
     */
    public function getCampaignId($alias, $title) {
      $mysqli = $this->connect();

      $query = "SELECT c.id FROM campaigns as c, gamemasters as g WHERE c.gamemaster=g.id AND g.alias=? AND c.title=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('ss', $alias, $title);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();
	
	return $id;
      }

      $stmt->close();
      $mysqli->close();
    }

  }
}
?>
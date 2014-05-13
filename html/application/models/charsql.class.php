<?php

require_once 'database.class.php';
require_once 'gmsql.class.php';

if(!class_exists('Charsql')) {

  class Charsql extends Database {
    
    public function __construct() { }

    /**
     * A function to check whether a given user already has a character of a given name
     * @param $user_id int - the user id of the sheet owner
     * @param $char_name string - the name of the character to check for
     * @return boolean - returns true if the given user already owns a character of that name, false otherwise
     */
    public function alreadyOwnsName($user_id, $char_name) {
      $mysqli = $this->connect();

      if($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error());
        exit();
      }

      $query = "SELECT * FROM sheets as s, users as u WHERE s.name=? AND s.owner=u.id AND u.id=?";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
         $stmt->bind_param('si', $char_name, $user_id);
         $stmt->execute();
         $stmt->store_result();
         $stmt->fetch();
         $num_rows = $stmt->num_rows;

         $stmt->close();

         if($num_rows >= 1) {
           return true;
         } else {
          return false;
         }
     }

      $mysqli->close();

    }


    /**
     * A function to have a character leave a given campaign
     * @param $char_name string - the invitation's character name
     * @param $user_id int - the character's owning user id
     * @param $title string - the campaign's title
     */
     public function leaveCampaign($char_name, $user_id, $title) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "DELETE FROM members USING members, sheets, users, campaigns WHERE members.sheet=sheets.id AND sheets.name=? AND sheets.owner=users.id AND users.id=? AND members.campaign=campaigns.id AND campaigns.title=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('sis', $char_name, $user_id, $title);
	$stmt->execute();

	$stmt->close();
      }

      $mysqli->close();
     
     }

    /**
     * A function to accept an invite from the member's invitations view
     * @param $alias string - the invitation's gamemaster alias
     * @param $char_name string - the invitation's character name
     * @param $title string - the invitation's campaign title
     */
     public function acceptInvitation($alias, $char_name, $user_id, $title) {
      $sheet_id = $this->getSheetId($char_name, $user_id);

      $gmsql = new Gmsql();
      $cmp_id = $gmsql->getCampaignId($alias, $title);

      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      try {
	$mysqli->autocommit(FALSE);

	//begin remove invitation
        $query = "DELETE FROM invitations USING invitations, gamemasters, sheets, users, campaigns WHERE invitations.gamemaster=gamemasters.id AND gamemasters.alias=? AND invitations.sheet=sheets.id AND sheets.name=? AND sheets.owner=users.id AND users.id=? AND invitations.campaign=campaigns.id AND campaigns.title=?";
	$query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error . ' || ' . $mysqli->errno);
        }
	
	$stmt->bind_param('ssis', $alias, $char_name, $user_id, $title);
	$stmt->execute();
	$stmt->close();

	//begin insert membership
	$query = "INSERT INTO members(sheet, campaign) VALUES(?, ?)";
	$query = $mysqli->real_escape_string($query);

        if(!$stmt = $mysqli->prepare($query)) {
          throw new Exception($mysqli->error);
        }
	
	$stmt->bind_param('ii', $sheet_id, $cmp_id);
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
     * A function to remove an invite from the member's invitations view
     * @param $alias string - the invitation's gamemaster alias
     * @param $char_name string - the invitation's character name
     * @param $title string - the invitation's campaign title
     */
     public function removeInvitation($alias, $char_name, $user_id, $title) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "DELETE FROM invitations USING invitations, gamemasters, sheets, users, campaigns WHERE invitations.gamemaster=gamemasters.id AND gamemasters.alias=? AND invitations.sheet=sheets.id AND sheets.name=? AND sheets.owner=users.id AND users.id=? AND invitations.campaign=campaigns.id AND campaigns.title=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('ssis', $alias, $char_name, $user_id, $title);
	$stmt->execute();

	$stmt->close();
      }

      $mysqli->close();
     
     }

    /**
     * A function to get the given user's characters memberships
     * @param $user_id int - the given user
     * @return $memberships array - and array holding the memberships' details
     */
    public function getMemberships($user_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $memberships = array();

      $query = "SELECT s.name, g.alias, c.title FROM users as u, sheets as s, gamemasters as g, campaigns as c, members as m WHERE m.sheet=s.id AND s.owner=u.id AND u.id=? AND m.campaign=c.id AND c.gamemaster=g.id";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($name, $alias, $title);
	while($stmt->fetch()) {
	  $membership = array(
				'name' => $name,
				'alias' => $alias,
				'title' => $title
			     );

          $memberships[] = $membership;
	}
	
	return $memberships;

	$stmt->close();
      }

      $mysqli->close();

    }

    /**
     * A function to get the given user's characters invitations
     * @param $user_id int - the given user
     * @return $invitations array - and array holding the invitations' details
     */
    public function getInvitations($user_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $invitations = array();

      $query = "SELECT g.alias, s.name, c.title FROM gamemasters as g, sheets as s, campaigns as c, invitations as i, users as u WHERE g.id=i.gamemaster AND i.sheet=s.id AND s.owner=u.id AND i.campaign=c.id AND u.id=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($alias, $name, $title);
	while($stmt->fetch()) {
	  $invitation = array(
				'alias' => $alias,
				'name' => $name,
				'title' => $title
			     );

          $invitations[] = $invitation;
	}
	
	return $invitations;

	$stmt->close();
      }

      $mysqli->close();

    }
    
    /**
     * A function to build an HTML representation of a given user's characters invitations and memberships
     * @param $invitations array - an array holding the invitations to represent
     * @param $memberships array - an array hoding the current user's characters memberships
     * @return $html string - the HTML representation of the invitations and memberships
     */
     public function buildInvHTML($invitations, $memberships) {
       $html = '';
       $html = $html . $this->buildInvitations($invitations);
       $html = $html . $this->buildMemberships($memberships);

       return $html;

     }

     /**
     * A function to build HTML representation of the active memberships for a given user's characters
     * @param $memberships array - an array holding the memberships for the user
     * @return $html string - a string representation of the HTML
     */
     public function buildMemberships($memberships) {
       $html = '';

       $html = $html . '<section id="memberships">' . "\n";
       $html = $html . '<div>' . "\n";
       $html = $html . '<h2>Memberships</h2>' . "\n";
       $html = $html . '</div>' . "\n";
       
       if(count($memberships) > 0) {
         foreach($memberships as $mbr) {
	   $html = $html . '<section class="membership">' . "\n";
	   $html = $html . '<p>Your character <span class="char-name">' . ucwords($mbr['name']) . '</span> is currently a member of <span class="alias">' . ucwords($mbr['alias']) . '</span>s campaign: <span class="title">' . ucwords($mbr['title']) . '</span></p>' . "\n";
	   $html = $html . '<div>' . "\n";
	   $html = $html . '<button class="leave-campaign">Leave</button>' . "\n";
	   $html = $html . '</div>' . "\n";
	   $html = $html . '</section> <!-- end .membership -->' . "\n";
	 }
       } else {
       
         $html = $html . '<section class="membership">' . "\n";
	 $html = $html . '<p>You are not member of any campaigns yet.</p>' . "\n";
	 $html = $html . '</section> <!-- end .membership -->' . "\n";
       }

       $html = $html . '</section> <!-- end #memberships -->' . "\n";

       return $html;
     }

     /**
     * A function to build HTML representation of the active invitations for a given user's characters
     * @param $invitations array - an array holding the invitations for the user
     * @return $html string - a string representation of the HTML
     */
     public function buildInvitations($invitations) {
       $html = '';

       $html = $html . '<section id="invitations">' . "\n";
       $html = $html . '<div>' . "\n";
       $html = $html . '<h2>Invitations</h2>' . "\n";
       $html = $html . '</div>' . "\n";
       
       if(count($invitations) > 0) {
         foreach($invitations as $inv) {
	   $html = $html . '<section class="invitation">' . "\n";
	   $html = $html . '<p><span class="alias">' . ucwords($inv['alias']) . '</span> has invited your character <span class="char-name">' . ucwords($inv['name']) . '</span> to join his campaign: <span class="title">' . ucwords($inv['title']) . '</span></p><br/>' . "\n";
	   $html = $html . '<div>' . "\n";
	   $html = $html . '<button class="accept-inv">Accept</button><button class="remove-inv">Remove</button>' . "\n";
	   $html = $html . '</div>' . "\n";
	   $html = $html . '</section> <!-- end .invitation -->' . "\n";
	 }
       } else {
       
         $html = $html . '<section class="invitation">' . "\n";
	 $html = $html . '<p>There are no invitations yet</p>' . "\n";
	 $html = $html . '</section> <!-- end .invitation -->' . "\n";
       }

       $html = $html . '</section> <!-- end #invitations -->' . "\n";

       return $html;
     }

    /**
     * A function to get the given character sheets initiative roll
     */
    public function getInitiative($sheet_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT init_roll FROM sheets WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->bind_result($initiative);
	$stmt->fetch();	
	
	return $initiative;

	$stmt->close();
      }

      $mysqli->close();

    }

    /**
     * A function to update the given characters sheets purse
     */
    public function updatePurse($sheet_id, $params) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "UPDATE purse as p, sheets as s SET p.gold=?, p.silver=?, p.copper=? WHERE s.id=? AND s.purse=p.id";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('iiii', $params['gold'], $params['silver'],$params['copper'], $sheet_id);
	$stmt->execute();

	$stmt->close();
      }

      $mysqli->close();

    }

    /**
     * A function to update the given characters sheets attributes
     */
    public function updateAttrs($sheet_id, $params) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "UPDATE attrs as a, sheets as s SET a.str=?, a.str_mod=?, a.con=?, a.con_mod=?, a.dex=?, a.dex_mod=?, a.intel=?, a.intel_mod=?, a.wis=?, a.wis_mod=?, a.cha=?, a.cha_mod=? WHERE s.id=? AND s.attr=a.id";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('iiiiiiiiiiiii', $params['str'], $params['str_mod'],$params['con'], $params['con_mod'],$params['dex'], $params['dex_mod'],$params['intel'], $params['intel_mod'],$params['wis'], $params['wis_mod'],$params['cha'], $params['cha_mod'], $sheet_id);
	$stmt->execute();

	$stmt->close();
      }

      $mysqli->close();

    }

    /**
     * A function to update the given characters sheets personalia
     */
    public function updatePersonalia($sheet_id, $params) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "UPDATE sheets set name=?, class=?, level=?, xp=?, dmg=?, hp=?, init_roll=?, init_mod=? WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('ssiiiiiii', $params['name'], $params['class'], $params['level'], $params['xp'], $params['dmg'], $params['hp'], $params['init_roll'], $params['init_mod'], $sheet_id);
	$stmt->execute();

	$stmt->close();
      }

      $mysqli->close();

    }

    /**
     * A function to get the sheet id of a given character based on the character name
     * @param $char_name string - the name of the character to get the sheet id for
     * @param $user_id int - the id of the user fetching the character
     * @return $sheet_id int - the sheet id of the character
     */
    public function getSheetId($char_name, $user_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT id FROM sheets WHERE name=? AND owner=?";
      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('si', $char_name, $user_id);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();

	$stmt->close();
	
	return $id;
      }
      
      $mysqli->close();
    }

    /**
     * A function to build an HTML representation of the characters overview list
     * @param $characters array - an array holding the characters' details
     */
    public function buildCharactersList($characters) {
      $html = '';

      $html = $html . '        <section id="characters">' . "\n";
      $html = $html . '          <div>' . "\n";
      $html = $html . '            <h2>Characters</h2>' . "\n";
      $html = $html . '          </div>' . "\n";
      
      if(count($characters) > 0) {
	foreach($characters as $c) {
	  $html = $html . '          <section class="character">' . "\n";
	  $html = $html . '            <p><span class="char-name">' . ucwords($c['name']) . '</span> Level <span class="level">' . $c['level'] . '</span> <span class="cls">' . ucwords($c['class']) . '</span></p>' . "\n";
	  $html = $html . '          </section> <!-- end .character -->' . "\n";
	}
      } else {
	$html = $html . '          <section class="character">' . "\n";
	$html = $html . '            <p>You have not made any characters yet.</p>' . "\n";
	$html = $html . '          </section> <!-- end .character -->' . "\n";
      }

      $html = $html . '        </section> <!-- end #characters -->' . "\n";
      
      return $html;
    }

    /**
     * A function to build the form for character selection
     * @param $characters array - an array holding the characters to list in the form
     */
    /*
    public function buildCharacterSelect($characters) {
      $html = '';

      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Select Character</legend>' . "\n";
      $html = $html . '<form name="char-select" action="../controllers/load-character.php" method="POST">' . "\n";
      $html = $html . '<select name="character">' . "\n";
      foreach($characters as $key => $val) {
	$html = $html . '<option value="' . $val[0] . '">' . ucfirst($val[0]) . ', level ' . $val[2] . ' ' . ucfirst($val[1]) . '</option>' . "\n";
      }
      $html = $html . '</select>' . "\n";
      $html = $html . '<input type="submit" value="Play">' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;

    }
    */

    /**
     * A function to delete the given character sheet, and the
     * related attribute and purse tables, from the database
     * @param $sheet_id int - the sheet id to delete
     */
    public function deleteCharacter($sheet_id) {

      $sheet = array();
      $sheet = $this->getCharacter($sheet_id);
      $purse_id = $sheet['purse'];
      $attrs_id = $sheet['attrs'];

      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      try {
	$mysqli->autocommit(FALSE);

	$query = 'DELETE FROM  purse WHERE id=?';
       	$query = $mysqli->real_escape_string($query);

	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}

	$stmt->bind_param('i', $purse_id);
	$stmt->execute();
	$stmt->close();

	//begin attrs
	$query = 'DELETE FROM attrs WHERE id=?';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('i', $attrs_id);
	$stmt->execute();
	$attrs_id = $mysqli->insert_id;
	$stmt->close();

	//begin invitations
	$query = 'DELETE FROM members WHERE sheet=?';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->close();

	//begin invitations
	$query = 'DELETE FROM invitations WHERE sheet=?';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->close();

	//begin sheet
	$query = 'DELETE FROM sheets WHERE id=?';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->close();

	$mysqli->commit();
	
      }   

      catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
	echo 'Caught exception: ' . $e->getMessage();
      }

      $mysqli->close();

    }

    /**
     * A function to build a HTML representation of the given character's data
     * @param $characterData array - a multidimensional assoc array holding the character's data
     * @return $characterHTML string - a string representation of the character's data as HTML
     */
    public function buildCharacterHTML($characterData) {
      $sheet = $characterData['sheet'];
      $attrs = $characterData['attrs'];
      $purse = $characterData['purse'];

      $sheetHTML = $this->buildSheet($sheet);
      $attrsHTML = $this->buildAttrs($attrs);
      $purseHTML = $this->buildPurse($purse);

      $html = '';
      $html = $html . '<section id="character-overview">' . "\n";
      $html = $html . '<section id="personalia">' . "\n";
      $html = $html . '<h2>Personalia</h2>' . "\n";
      $html = $html . '<div class="character-form-entry">' . "\n";
      $html = $html . $sheetHTML;
      $html = $html . '</div> <!-- end .character-form-entry -->' . "\n";
      $html = $html . '</section> <!-- end #personalia -->' . "\n";
      $html = $html . '<section id="attributes">' . "\n";
      $html = $html . '<h2>Attributes</h2>' . "\n";
      $html = $html . '<div class="character-form-entry">' . "\n";
      $html = $html . $attrsHTML;
      $html = $html . '</div> <!-- end .character-form-entry -->' . "\n";
      $html = $html . '</section> <!-- end #attributes -->' . "\n";
      $html = $html . '<section id="purse">' . "\n";
      $html = $html . '<h2>Purse</h2>' . "\n";
      $html = $html . '<div class="character-form-entry">' . "\n";
      $html = $html . $purseHTML;
      $html = $html . '</div> <!-- end .character-form-entry -->' . "\n";
      $html = $html . '</section> <!-- end #purse -->' . "\n";
      $html = $html . '</section> <!-- end #character-overview -->' . "\n";
      
      return $html;

    }

    /**
     * A function to build a HTML representation of the given character's personalia-sheet data
     * @param $sheet array - an assoc array holding the personalia-sheet data
     * @return $html string - a string representation of the personalia-sheet data
     */
    public function buildSheet($sheet) {

      $html = '';
      
      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Personalia</legend>' . "\n";
      $html = $html . '<form name="character" action="" method="POST">' . "\n";
      $html = $html . '<label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" value="' . ucfirst($sheet['name']) . '" required><br/>' . "\n";
      $html = $html . '<label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" value="' . ucfirst($sheet['class']) . '" required><br/>' . "\n";
      $html = $html . '<label for="level">Level:</label><input name="level" id="level" type="number" value="' . $sheet['level'] . '" required>' . "\n";
      $html = $html . '<label for="experience_points">XP:</label><input name="xp" id="experience_points" type="number" value="' . $sheet['xp'] . '" required><br/>' . "\n";
      $html = $html . '<label for="damage">Dmg:</label><input name="dmg" id="damage" type="number" value="' . $sheet['dmg'] . '" required><br/>' . "\n";
      $html = $html . '<label for="hitpoints">Hitpoints:</label><input name="hp" id="hitpoints" type="number" value="' . $sheet['hp'] . '" required><br/>' . "\n";
      $html = $html . '<label for="initiativeRoll">Initiative Roll:</label><input name="init_roll" id="initiativeRoll" type="number" value="' . $sheet['init_roll'] . '" required><br/>' . "\n";
      $html = $html . '<label for="modifier">Initiative Mod:</label><input name="init_mod" id="modifier" type="number" value="' . $sheet['init_mod'] . '" required>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;
      
    }
    
    /**
     * A function to build a HTML representation of the given character's attributes data
     * @param $attrs array - an assoc array holding the attributes data
     * @return $html string - a string representation of the attributes data
     */
    public function buildAttrs($attrs) {
      $html = '';
      
      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Attributes</legend>' . "\n";
      $html = $html . '<form name="attrs" action="" method="POST">' . "\n";
      $html = $html . '<label for="strength">STR:</label><input name="str" id="strength" type="number" value="' . $attrs['str'] . '" required>' . "\n";
      $html = $html . '<label for="strength_modifier">MOD:</label><input name="str_mod" id="strength_modifier" type="number" value="' . $attrs['strMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="' . $attrs['con'] . '" required>' . "\n";
      $html = $html . '<label for="constitution_modifier">MOD:</label><input name="con_mod" id="constitution_modifier" type="number" value="' . $attrs['conMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="' . $attrs['dex'] . '" required>' . "\n";
      $html = $html . '<label for="dexterity_modifier">MOD:</label><input name="dex_mod" id="dexterity_modifier" type="number" value="' . $attrs['dexMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="' . $attrs['intel'] . '" required>' . "\n";
      $html = $html . '<label for="intelligence_modifier">MOD:</label><input name="intel_mod" id="intelligence_modifier" type="number" value="' . $attrs['intelMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="' . $attrs['wis'] . '" required>' . "\n";
      $html = $html . '<label for="wisdom_modifier">MOD:</label><input name="wis_mod" id="wisdom_modifier" type="number" value="' . $attrs['wisMod'] . '" required>' . "\n" . '<br/>';
            $html = $html . '<label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="' . $attrs['cha'] . '" required>' . "\n";
      $html = $html . '<label for="charisma_modifier">MOD:</label><input name="cha_mod" id="charisma_modifier" type="number" value="' . $attrs['chaMod'] . '" required>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";
      
      return $html;
    }

    /**
     * A function to build a HTML representation of the given character's purse data
     * @param $purse array - an assoc array holding the purse data
     * @return $html string - a string representation of the purse data
     */
    public function buildPurse($purse) {
      $html = '';

      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Purse</legend>' . "\n";
      $html = $html . '<form name="purse" action="" method="POST">' . "\n";
      $html = $html . '<label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="' . $purse['gold'] . '" required><br/>' . "\n";
      $html = $html . '<label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="' . $purse['silver'] . '" required><br/>' . "\n";
      $html = $html . '<label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="' . $purse['copper'] . '" required><br/>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;

    }

    /**
     * A function to get the name of a given character
     * @param $sheet_id int - the id of the character's sheet
     * @return $name string - the characters name
     */
    public function getCharacterName($sheet_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT name FROM sheets WHERE id=?";
      $query = $mysqli->real_escape_string($query);
      
      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->bind_result($name);
	$stmt->fetch();

	$stmt->close();

	return $name;

      }
      
      $mysqli->close();

    }

    /**
     * A function to get a given characters sheet, attributes, and purse
     * from the given sheet id
     * @param $sheet_id int - the sheet id for the given character
     * @return $character array - a multidimensional assoc array holding 
     *                          - the characters data in subsequent arrays
     */
    public function getCharacter($sheet_id) {
      $character = array();
      $sheet = array();
      $attrs = array();
      $purse = array();
      
      $sheet = $this->getSheet($sheet_id);
      $attrs = $this->getAttrs($sheet['attr']);
      $purse = $this->getPurse($sheet['purse']);

      $character['sheet'] = $sheet;
      $character['attrs'] = $attrs;
      $character['purse'] = $purse;
      
      return $character;
    }

    /**
     * A function to get the given sheets purse contents
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $purse array - an assoc array holding the attributes
     */
    public function getSheet($sheet_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT s.owner, s.name, s.level, s.xp, s.class, s. attr, s.purse, s.hp, s.dmg, s.init_mod, s.init_roll FROM sheets as s WHERE s.id=?";

      //      $result = array();

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->bind_result($owner, $name, $level, $xp, $class, $attr, $purse, $hp, $dmg, $init_mod, $init_roll);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'owner' => $owner,
			'name' => $name,
			'level' => $level,
			'xp' => $xp,
			'class' => $class,
			'attr' => $attr,
			'purse' => $purse,
			'hp' => $hp,
			'dmg' => $dmg,
			'init_mod' => $init_mod,
			'init_roll' => $init_roll
			);
			
          return $result;

          $stmt->close();
      }
      
      $mysqli->close();
    }

    /**
     * A function to get the given sheets attributes
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $attrs array - an assoc array holding the attributes
     */
    public function getAttrs($id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT str, str_mod, con, con_mod, dex, dex_mod, intel, intel_mod, wis, wis_mod, cha, cha_mod FROM attrs WHERE id=?";

      //      $result = array();

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($str, $strMod, $con, $conMod, $dex, $dexMod, $intel, $intelMod, $wis, $wisMod, $cha, $chaMod);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'str' => $str,
			'strMod' => $strMod,
			'con' => $con,
			'conMod' => $conMod,
			'dex' => $dex,
			'dexMod' => $dexMod,
			'intel' => $intel,
			'intelMod' => $intelMod,
			'wis' => $wis,
			'wisMod' => $wisMod,
			'cha' => $cha,
			'chaMod' => $chaMod
			);

      }
      
      $mysqli->close();
      return $result;
      
    }

    /**
     * A function to get the given sheets purse contents
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $purse array - an assoc array holding the attributes
     */
    public function getPurse($id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT gold, silver, copper FROM purse WHERE id=?";

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($gold, $silver, $copper);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'gold' => $gold,
			'silver' => $silver,
			'copper' => $copper
			);

      }
      
      $mysqli->close();
      return $result;
    }

    /**
     * A function to insert a new row of attributes, purse, and sheet in the database
     * via transactions due to key constraints in the database
     * @param $sheet array - an array holding the sheet entries
     * @param $attrs array - an array holding the attributes entries
     * @param $purse array - an array holding the purse entries
     * @return $sheet_id int - the sheet id of the inserted character sheet
     */
    public function insertSheet($sheet, $attrs, $purse) {

      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $sheet_id = null;

      try {
	$mysqli->autocommit(FALSE);

	//begin purse
	$gold = Utils::html(trim($purse['gold']));
	$silver = Utils::html(trim($purse['silver']));
	$copper = Utils::html(trim($purse['copper']));
	$query = 'INSERT INTO purse VALUES(null,?,?,?)';
       	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('iii', $gold, $silver, $copper);
	$stmt->execute();
	$purse_id = $mysqli->insert_id;
	$stmt->close();

	//begin attrs
	$str = Utils::html(trim($attrs['str']));
	$strMod = Utils::html(trim($attrs['strMod']));
	$con = Utils::html(trim($attrs['con']));
	$conMod = Utils::html(trim($attrs['conMod']));
	$dex = Utils::html(trim($attrs['dex']));
	$dexMod = Utils::html(trim($attrs['dexMod']));
	$intel = Utils::html(trim($attrs['intel']));
	$intelMod = Utils::html(trim($attrs['intelMod']));
	$wis = Utils::html(trim($attrs['wis']));
	$wisMod = Utils::html(trim($attrs['wisMod']));
	$cha = Utils::html(trim($attrs['cha']));
	$chaMod = Utils::html(trim($attrs['chaMod']));
	$query = 'INSERT INTO attrs VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?)';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('iiiiiiiiiiii', $str, $strMod, $con, $conMod, $dex, $dexMod, $intel, $intelMod, $wis, $wisMod, $cha, $chaMod);
	$stmt->execute();
	$attrs_id = $mysqli->insert_id;
	$stmt->close();

	//begin sheet
	$owner = $_SESSION['user_id'];
	$name = Utils::html(trim($sheet['name']));
	$level = Utils::html(trim($sheet['level']));
	$xp = Utils::html(trim($sheet['xp']));
	$class = Utils::html(trim($sheet['class']));
	$hp = Utils::html(trim($sheet['hp']));
	$dmg = Utils::html(trim($sheet['dmg']));
	$init_mod = Utils::html(trim($sheet['init_mod']));
	$init_roll = Utils::html(trim($sheet['init_roll']));
	$query = 'INSERT INTO sheets VALUES(null,?,?,?,?,?,?,?,?,?,?,?)';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('isiisiiiiii', $owner, $name, $level, $xp, $class, $attrs_id, $purse_id, $hp, $dmg, $init_mod, $init_roll);
	$stmt->execute();
	$sheet_id = $mysqli->insert_id;
	$stmt->close();

	$mysqli->commit();
	
      }   

      catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
	echo 'Caught exception: ' . $e->getMessage();
      }

      $mysqli->close();
      return $sheet_id;
    }
    

  }

}
?>

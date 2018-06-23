<?php

class TibiaCharacter {

	public $characterName;
	public $characterNamePlus;
	public $world;
	public $sex;
	public $vocation;
	public $residence;
	public $achievementPoints;
	public $lastLogin;
	public $accountStatus;
	public $guild;
	public $onlineStatus;
	
	public function __construct($characterName){
		
		// Make sure the name has capitalized first character
		$this->setName(ucwords($characterName));
		// Sets the character info available from the "character search" page on tibia.com
		$this->setCharacterInfo();
		// Checks the worlds online list for character online status
		$this->setOnlineStatus();

	}

	public function setName($characterName){

		// Escape character name input
		$characterName = htmlentities($characterName, ENT_QUOTES);
		// Set character name var
		$this->characterName = $characterName;
		// Replace space with + to support tibia.com's search query
		$this->characterNamePlus = str_replace(" ", "+", $characterName);
		
	}

	public function setCharacterInfo(){

		// The URL to character search
		$characterUrl = "https://secure.tibia.com/community/?subtopic=characters&name=$this->characterNamePlus";

		// cURL
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $characterUrl);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		// Close last cURL
		curl_close($curl);

		// Check if character exists
		if($this->characterExists($result)){

			// Set world
			$this->setWorld($result);
			// Set sex
			$this->setSex($result);
			// Set vocation
			$this->setVocation($result);
			// Set residence
			$this->setResidence($result);
			// Set achievement points
			$this->setAchievementPoints($result);
			// Set last login
			$this->setLastlogin($result);
			// Set account status
			$this->setAccountStatus($result);			
			// Set guild
			$this->setGuild($result);

		}
		// What to do when character does not exsist
		else {

			$this->characterName = '';
			$this->characterNamePlus = '';
			$this->onlineStatus = '';
			$this->vocation = '';

		}


	}
	
	public function characterExists($result){

		// If the page contains the word "does not exist" the function will return false
		if(strpos($result, 'does not exist')){

			return false;

		}
		else return true;

	}

	public function setWorld($result){

		// Find the row which reveals the server name
		preg_match("!<td>World:</td><td>[^\s]*?</td>!", $result, $world);
		
		if(isset($world) && is_array($world) && !empty($world)){

			// Remove html tags
			$world= htmlentities($world[0], ENT_QUOTES);
			// Remove the first bit of html
			$world= substr($world, 37);
			// Remove the last bit of hmtl
			$world= substr($world, 0, -11);
			// Set world
			$this->world = $world;

		}
	}

	public function setSex($result){

		// Find the row which reveals the server name
		preg_match("!<td>Sex:</td><td>[^\s]*?</td>!", $result, $sex);

		if(isset($sex) && is_array($sex) && !empty($sex)){

			// Remove html tags
			$sex = htmlentities($sex[0], ENT_QUOTES);
			// Remove the first bit of html
			$sex = substr($sex, 35);
			// Remove the last bit of hmtl
			$sex= substr($sex, 0, -11);
			// Set world
			$this->sex = ucwords($sex);

		}
	}


	public function setVocation($result){

		preg_match('!<td>Vocation:</td><td>.*?</td>!', $result, $voc);

		if(isset($voc) && is_array($voc) && !empty($voc)){

			// Remove html tags
			$voc= htmlentities($voc[0], ENT_QUOTES);
			// Remove the first bit of html
			$voc= substr($voc,40);
			// Remove the last bit of hmtl
			$voc= substr($voc, 0, -11);
			// Set residence
			$this->vocation= ucwords($voc);

		}
	}

	public function setResidence($result){

		// Find the row which reveals the server name
		preg_match("!<td>Residence:</td><td>[^\s]*?</td>!", $result, $residence);

		if(isset($residence) && is_array($residence) && !empty($residence)){

			// Remove html tags
			$residence = htmlentities($residence[0], ENT_QUOTES);
			// Remove the first bit of html
			$residence = substr($residence, 41);
			// Remove the last bit of hmtl
			$residence= substr($residence, 0, -11);
			// Set residence
			$this->residence= ucwords($residence);

		}
	}

	public function setAchievementPoints($result){

		// Find the row which reveals the server name
		preg_match("!<td><nobr>Achievement Points:</nobr></td><td>[^\s]*?</td>!", $result, $ap);

		if(isset($ap) && is_array($ap) && !empty($ap)){

			// Remove html tags
			$ap= htmlentities($ap[0], ENT_QUOTES);
			// Remove the first bit of html
			$ap= substr($ap, 75);
			// Remove the last bit of hmtl
			$ap= substr($ap, 0, -11);
			// Set residence
			$this->achievementPoints= ucwords($ap);

		}
	}

	public function setLastLogin($result){

		preg_match("!<td>Last Login:</td><td>.*?</td></tr>!", $result, $lastLogin);

		if(isset($lastLogin) && is_array($lastLogin) && !empty($lastLogin)){

			// Remove html tags
			//$lastLogin = htmlentities($lastLogin[0], ENT_QUOTES);
			// Remove the first bit of html
			$lastLogin = substr($lastLogin[0],15);
			// Remove the last bit of hmtl
			$lastLogin = substr($lastLogin, 0, -11);
			// Set residence
			$this->lastLogin= ucwords($lastLogin);

		}

	}

	public function setAccountStatus($result){
		
		// Find the row which reveals the account status
		preg_match("!<td>Account&#160;Status:</td><td>.*?</td></tr>!", $result, $as);

		if(isset($as) && is_array($as) && !empty($as)){

			// Remove html tags
			$as= htmlentities($as[0], ENT_QUOTES);
			// Remove the first bit of html
			$as= substr($as, 55);
			// Remove the last bit of hmtl
			$as= substr($as, 0, -22);
			// Set residence
			$this->accountStatus= ucwords($as);

		}
	}
	
	public function setGuild($result){

		// Find the row which reveals the guild
		preg_match("!<td>Guild&#160;Membership:</td><td>.*?</td></tr>!", $result, $guild);

		if(isset($guild) && is_array($guild) && !empty($guild)){

			// Remove html tags
			//$guild = htmlentities($guild[0], ENT_QUOTES);
			// Remove the first bit of html
			$guild= substr($guild[0], 35);
			// Remove the last bit of hmtl
			$guild = substr($guild, 0, -10);
			// Add target BLANK to link
			$guild = str_replace('<a href', '<a target="_BLANK" href', $guild);
			// Set residence
			$this->guild = $guild;

		}
	}
		

	public function setOnlineStatus(){

		// The URL to world online list
		$worldUrl = "https://secure.tibia.com/community/?subtopic=worlds&world=";


		// Start new cURL to parse world online list to see if character is online
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $worldUrl.$this->world);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);


		// Search for character in world online list
		if(stripos($result, $this->characterNamePlus)){
			// Return onlinestatus 1 if character is online
			$this->onlineStatus = 'Online';
		}
		else{
			// Return onlinestatus 0 if character is offline
			$this->onlineStatus = 'Offline';
		}

		// Close last cURL
		curl_close($curl);


	}
}

 <?php

class Character extends Base {

	protected $name;
	// $craft is my sneaky way of getting the class of each player, the way I want
	protected $craft;
	protected $success = 50;
	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public $mytools = array();

	public function __construct($name, $craft) {
    	$this->name = $name;
    	$this->craft = $craft;
	}
	
	// Methods we will use
	public function winTool($tools) { 
		if (count($this->mytools) < 3) { 
			$random_index = rand(0, count($tools)-1); 
			$random_tool = $tools[$random_index]; 
			// push tool to players tools array 
			$this->mytools[] = $random_tool; 
			return $random_tool->description;
		}
		else {
			return NULL;
		}
	}

	public function looseTool() {
		if (count($this->mytools) > 0) {
			array_splice($this->mytools, 0, 1);    
		}
	}

	public function acceptChallenge($challenge, $tools) { 
   	$new_tool = $this->winTool($tools);
   	if ($new_tool == NULL) {
   		return $challenge->title." challenge accepted! Your tool bag is full";
   	}
   	else { 
   		return $challenge->title." challenge accepted! Here's a tool to help with your challenge: ".$new_tool; 
   	}
	}

	public function changeChallenge() {
		return $this->name." changes challenge, loses 5 success points!";
	}

	public function carryOutChallenge($challenge, $contestants) {
		// Put all the players into an array to get the winner list
		$all_players = array($this, $contestants[0], $contestants[1]);
		$winner_list = $challenge->play_challenge($all_players);

		return $winner_list;
	}

	public function carryOutChallengeWithCompanion($challenge, $companion, $contestant) {
		// creating a team consisting of two players (Teams behave as regular players)
		$team = new Team("Team1", $this, $companion);
		// Put all the players into an array to get the winner list
		$all_players = array($team, $contestant);
		$winner_list = $challenge->play_challenge($all_players);

		return $winner_list;
	}


	// Getters & setters
	public function get_name() {
		return $this->name;
	}

	public function get_craft() {
		return $this->craft;
	}

	public function get_success() {
		return $this->success;
	}

	public function get_needlework() {
		return $this->needlework;
	}

	public function get_sewing() {
		return $this->sewing;
	}

	public function get_cutting() {
		return $this->cutting;
	}

	public function get_patterns() {
		return $this->patterns;
	}

	public function set_success($val) {
		// Limiting the success points to 0 - 100
		if ($val < 0) {
			$val = 0;
		}
		else if ($val > 100) {
			$val = 100;
		}		
		$this->success = $val;
	}

	public function set_needlework($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Needlework skill must be within 0 - 100");
		}
		$this->needlework = $val;
	}

	public function set_sewing($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Sewing skill must be within 0 - 100");
		}
		$this->sewing = $val;
	}

	public function set_cutting($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Cutting skill must be within 0 - 100");
		}
		$this->cutting = $val;
	}

	public function set_patterns($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Patterns skill must be within 0 - 100");
		}
		$this->patterns = $val;
	}

}
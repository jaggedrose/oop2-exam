 <?php

class Player extends Base {

	protected $name;
	protected $craft;
	protected $success = 50;

	protected $tools = array();

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name, $craft) {
    	$this->name = $name;
    	$this->craft = $craft;
	}

	// Methods we will use
	public function winTool($tool) {
		if (count($this->tools) < 3) {
			// push tool to players tools array
			$this->tools[] = $tool;
		}
	}

	public function looseTool() {
		if (count($this->tools) > 0) {
			array_splice($tool, 0, 1);    
		}
	}

	public function acceptChallenge($challenge) {
		return $this->name." accepts challenge: ".$challenge->title;
	}

	public function changeChallenge() {
		return $this->name." changes challenge, loses 5 success points!";
	}

	public function carryOutChallenge() {
		return $this->name." carries out the chosen challenge.";
	}

	public function carryOutChallengeWithCompanion() {

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
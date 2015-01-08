<?php

class Challenge extends Base {
	
	public $id;
	public $title;
	public $description;
	public $needlework = 0;
	public $sewing = 0;
	public $cutting = 0;
	public $patterns = 0;
	public $challenge;

	public function __construct($challenge) {
		// Getting the associative array from method restart
		$this->challenge = $challenge;
		$this->restart();		
	}

	private function restart() {
		$challenge = $this->challenge;
		// Challenges associative array that is re-used in the constructor
		$this->id = $challenge["id"];
		$this->title = $challenge["title"];
		$this->description = $challenge["description"];
		$this->needlework = $challenge["skills"]["needlework"];
		$this->sewing = $challenge["skills"]["sewing"];
		$this->cutting = $challenge["skills"]["cutting"];
		$this->patterns = $challenge["skills"]["patterns"];
	}
   
  	public function play_challenge($player) {
  		$counter = 0;
  		// Resetting the challenge skills for the next player to carry out the challenge.
  		$this->restart();
  		// ToDo - Add something like Thomas's winChances to make game "fair". Check each players proficiency to see who is best to win game.
  		while (!$this->is_complete()) {
  			$this->needlework -= $player->needlework;
  			$this->sewing -= $player->sewing;
  			$this->cutting -= $player->cutting;
  			$this->patterns -= $player->patterns;
  			$counter++;
  		}
  		return $counter;
   }

	private function is_complete() {
		if ($this->needlework <= 0 && $this->sewing <= 0 && $this->cutting <= 0 && $this->patterns <= 0 ) {
			return true;
		}
		else {
			return false;
		}


	}


}


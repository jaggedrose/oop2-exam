<?php

class Challenge extends Base {
	
	public $id;
	public $title;
	public $description;
  public $challenge;
	public $needlework = 0;
	public $sewing = 0;
	public $cutting = 0;
	public $patterns = 0;
  	

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
  		// ToDo - Add something like winChances to make game "fair". Check each players proficiency? to see who is best to win game.
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

	public function howGoodAMatch($person){
    //total points a person has
    $sum= 0;
    //total points possible for this challenge
    $max = 0;

	$challengeSkills = array() 
	{
		"needlework" => $needlework,
		 "sewing" => $sewing,
	 "cutting" => $cutting,
	 "patterns" => $patterns
	};

    //calculate how good of a match a person is to this challenge
    foreach($challengeSkills as $skill => $points){
      //by checking how many skillpoints the challenge requires
      $needed = $points;
      //and by checking how many skillpoints a person has
      $has = $person->{$skill};

      //check if a person has any tools
      // if (count($person->tools) > 0) {
      //   //if they do, go through them
      //   for ($i = 0; $i < count($person->tools); $i++) {
      //     //and for each skill the tool has
      //     foreach ($person->tools[$i]->skills as $toolSkill => $value) {
      //       //if a toolSkill matches the skill we are currently calculating
      //       if ($toolSkill == $skill) {
      //         //add the toolSkill points 
      //         $has += $value;
      //       }
      //     }
      //   } 
      // }

      //if a person has more points than needed, only count the points needed (to preserve our percentage)
      //else count the skillpoints a person has
      $sum += $has > $needed ? $needed : $has;
      $max += $needed;
    }

    //return the percentage of skill points they have
    return $sum/$max;
  }

  public function winChances($persons){
    $matches = array();
    //count is used to create a range of win intervals for all persons
    $count = 0;
    //calculate chance to win using howGoodAMatch()
    foreach($persons as $person){
      $howGoodAMatch = $this->howGoodAMatch($person);
      //and store result in matches
      $matches[] = array(
        "person" => $person,
        "howGoodAMatch" => $howGoodAMatch,
      );
      //increase count to create an interval
      $count += $howGoodAMatch;
    }
    //also create a percentage to be nice (better to count with)
    foreach($matches as &$match){
      $match["winChancePercent"] = round(100*($match["howGoodAMatch"]/$count));
    }
    //return win chances
    return $matches;
  }


}


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
		$this->id = $challenge["id"];
    $this->title = $challenge["title"];
    $this->description = $challenge["description"];
    $this->needlework = $challenge["skills"]["needlework"];
    $this->sewing = $challenge["skills"]["sewing"];
    $this->cutting = $challenge["skills"]["cutting"];
    $this->patterns = $challenge["skills"]["patterns"];
  }

  public function get_match_points($player) {
    //total points a player has
    $sum = 0;
    //total points possible for this challenge
    $max = 0;
    $challenge_skills = array(
      "needlework" => $this->needlework,
      "sewing" => $this->sewing,
      "cutting" => $this->cutting,
      "patterns" => $this->patterns
    );
    //calculate how good of a match a player is to this challenge
    foreach ($challenge_skills as $skill => $challenge_skill_points) {
      //and by checking how many skillpoints a player has
      $player_skill_points = $player->{$skill};
      // check if a player has any tools
      if (count($player->tools) > 0) {
        //if they do, go through them
        for ($i = 0; $i < count($player->tools); $i++) {
          //and for each skill the tool has
          foreach ($player->tools[$i]->skills as $tool_skill => $tool_skill_points) {
            //if a toolSkill matches the skill we are currently calculating
            if ($tool_skill == $skill) {
              //add the toolSkill points 
              $player_skill_points += $tool_skill_points;
            }
          }
        } 
      }
      //if a player has more points than needed, only count the points needed (to preserve our percentage)
      //else count the skillpoints a player has
      $sum = $player_skill_points > $challenge_skill_points ? $challenge_skill_points : $player_skill_points;
      $max = $challenge_skill_points;
    }
    //return the percentage of skill points they have
    return $sum/$max;
  }

  public function win_odds($players) {
    $players_points = array();
    //count is used to create a range of win intervals for all players
    $total_match_points = 0;
    //calculate chance to win using get_match_points()
    foreach ($players as $player) {
      $get_match_points = $this->get_match_points($player);
      //and store result in players_points
      $players_points[] = array(
        "player" => $player,
        "matchPoints" => $get_match_points,
      );
      //increase total_match_points to create an interval
      $total_match_points += $get_match_points;
    }
    //also create a percentage to be nice (better to count with)
    foreach ($players_points as &$points) {
      $points["winOddsPercent"] = round(100*($points["matchPoints"]/$total_match_points));
    }
    //return win odds
    return $players_points;
  }
   
  public function play_challenge($players) { 
    $winner_order = array();
    //get odds to win for each player
    $players_points = $this->win_odds($players);
    //once again we are using intervals to check for a winner
    $count = 0;
    //pick a random number (between 0 and 100 since we are using percent)
    $rand = rand(0,100);
    //then check which player interval contains the random number
    foreach ($players_points as $points){
      if ($rand >= $count && $rand <= $points["winOddsPercent"] + $count) {
        //if a persons interval contains the random number
        // we have a winner, end function using return
        return $points["player"];
      }
      //if this player was not a winner, increase interval and try again...
      $count += $points["winOddsPercent"];
    }
  }
}


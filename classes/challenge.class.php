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
    // Total points a player has
    $sum = 0;
    // Total points possible for this challenge
    $max = 0;
    $challenge_skills = array(
      "needlework" => $this->needlework,
      "sewing" => $this->sewing,
      "cutting" => $this->cutting,
      "patterns" => $this->patterns
    );
    // Compare player skill points to the skill points of this challenge
    foreach ($challenge_skills as $skill => $challenge_skill_points) {
      // Read the matching skill points
      $player_skill_points = $player->{$skill};
      // Check if a player has any tools
      if (count($player->tools) > 0) {
        // Go through them if they do
        for ($i = 0; $i < count($player->tools); $i++) {
          // And check the skills of each tool
          foreach ($player->tools[$i]->skills as $tool_skill => $tool_skill_points) {
            // If a tools skill matches the current challenge skills
            if ($tool_skill == $skill) {
              // Add the tool skill points  to the players skill points
              $player_skill_points += $tool_skill_points;
            }
          }
        } 
      }
      // If the players skill points are higher than the challenge skill points, clamp it to the challenge skill points
      // Otherwise, carry on!
      $sum = $player_skill_points > $challenge_skill_points ? $challenge_skill_points : $player_skill_points;
      $max = $challenge_skill_points;
    }
    // Return the percentage of skill points they have
    return $sum/$max;
  }

  public function win_odds($players) {
    $players_points = array();
    // Total_match_points is used to work out the win chance for each player
    $total_match_points = 0;
    // Calculate the chance to win using get_match_points()
    foreach ($players as $player) {
      $get_match_points = $this->get_match_points($player);
      // Store the result in players_points
      $players_points[] = array(
        "player" => $player,
        "matchPoints" => $get_match_points,
      );
      // Adding together the match points for all players
      $total_match_points += $get_match_points;
    }
    // Calculate in percentage, because it's easier to work with
    foreach ($players_points as &$points) {
      $points["winOddsPercent"] = round(100*($points["matchPoints"]/$total_match_points));
    }
    // Return winning odds
    return $players_points;
  }
   
  public function play_challenge($players) { 
    $winner_order = array();
    // Get winning odds for each player
    $players_points = $this->win_odds($players);
    // Like before, we are checking the players win chance space to see who wins, $count is where this space starts for each player
    $count = 0;
    // Pick a random number (between 0 and 100 since we are using percent)
    $rand = rand(0,100);
    // And check which players win chance space the random number is in
    foreach ($players_points as $points){
      if ($rand >= $count && $rand <= $points["winOddsPercent"] + $count) {
        // If a player win chance space has the random number, then that's our winner
        // Push the winner to the winner_order array
        $winner_order[] = $points["player"];
        // Search for winner & remove from $players_points array
        $the_winner = array_search($points, $players_points);
        array_splice($players_points, $the_winner, 1);
        break;
      }
      // If this player was not the winner, increase win chance and try again...
      $count += $points["winOddsPercent"];
    }
    //  If only 1 player left, add then to the winner_order array
    if (count($players_points) == 1) {
      $winner_order[] = $players_points[0];
    }
    // Otherwise check win odds precentage for second & third place, push to array in correct order
    else {
      if ($players_points[0]["winOddsPercent"] >= $players_points[1]["winOddsPercent"]) {
        $winner_order[] = $players_points[0]["player"];
        $winner_order[] = $players_points[1]["player"];
      }
      else {
        $winner_order[] = $players_points[1]["player"];
        $winner_order[] = $players_points[0]["player"];
      }
    }
    return $winner_order;
  }
}

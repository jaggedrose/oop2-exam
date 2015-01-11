<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get needed info from DB
$myplayer = &$ds->myplayer[0];
$contestants = &$ds->contestants;
$challenge = &$ds->challenge[0];

// Checking if challenge is played with companion, if so minus 5 success points
if (!isset($_REQUEST["challenge_companion"])) {
	// Not enough required data was received, exit script
  echo(json_encode(false));
  exit();
} 
else {
	$companion = $_REQUEST["challenge_companion"];
	if($companion == "true") {
		$myplayer->success -= 5;
		$winner_list = $myplayer->carryOutChallengeWithCompanion($challenge, $contestants);
	}
	else {
		// Calling method carryOutChallenge to get results
		$winner_list = $myplayer->carryOutChallenge($challenge, $contestants);	
	}
	// If you don't win you lose a random tool
	for ($i = 1; $i < count($winner_list); $i++)	{
		$winner_list[$i]->looseTool($tools);
	}
}
// Success points logic
$my_player_array = array($myplayer);
$all_players = array_merge($my_player_array, $contestants);

$return_string = "";
$game_over = false;

for ($i = 0; $i < count($all_players); $i++) {
	$current_player = $all_players[$i];
	if ($current_player->success >= 100) {
		if ($current_player == $myplayer) {
			$game_over = true;
			$return_string = "You have reached 100 success points. Game Over!";
		} else {
			$contestant_index = array_search($current_player, $contestants);
			array_splice($contestants, $contestant_index, 1);
			$return_string = $current_player->name ." has reached 100 success points!";
		}
	}
	else if ($current_player->success <= 0) {
		if ($current_player == $myplayer) {
			$return_string = "You have reached 0 success points. Game Over!";
			$game_over = true;
		} else {
			$contestant_index = array_search($current_player, $contestants);
			array_splice($contestants, $contestant_index, 1);
			$return_string = $current_player->name." has reached 0 success points!";
		}
	}
}

if (count($contestants) <= 0) {
	$return_string = "You have no one else to challenge. Game Over!";
	$game_over = true;
}

// Collect all data needed in an associative array
$return_data = array (
	"returnString" => &$return_string,
	"gameOver" => &$game_over,
	"challenge" => &$challenge,
	"firstPlace" => &$winner_list[0]->name,
	"secondPlace" => &$winner_list[1]->name,
	"thirdPlace" => &$winner_list[2]->name
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));

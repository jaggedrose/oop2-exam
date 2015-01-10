<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get player & challenge from DB
$myplayer = &$ds->myplayer[0];
// $myplayer_name = $myplayer->name;
$contestants = &$ds->contestants;
// $contestant1_name = &$ds->contestants[0]->name;
// $contestant2_name = &$ds->contestants[1]->name;
$challenge = &$ds->challenge[0];

// Checking if challenge is played with companion, if so minus 5 success points
if (isset($_REQUEST["challenge_companion"])) {
	$companion = $_REQUEST["challenge_companion"];
	if($companion == "true") {
		$myplayer->success -= 5;
	}
} 
// Calling method carryOutChallenge to get results
$winner_list = $myplayer->carryOutChallenge($challenge, $contestants);
// Points after completed challenge when done alone, first place + 15 success points
$winner_list[0]->success += 15;
// Third place - 5 success points
$winner_list[2]->success -= 5;
// If you don't win you lose a random tool
$lose_tool_secondplace = $winner_list[1]->looseTool();
$lose_tool_thirdplace = $winner_list[2]->looseTool();
// 


// $player_success = $player->success;
// $contestant1_success = $contestants[0]->success;
// $contestant2_success = $contestants[1]->success;

// Collect all data needed in an associative array
$return_data = array (
	// "myPlayerName" => &$myplayer_name,
	// "contestant1Name" => &$contestant1_name,
	// "contestant2Name" => &$contestant2_name,
	"challenge" => &$challenge,
	// "myPlayerSuccess" => &$myplayer->success,
	// "contestant1Success" => &$contestants[0]->success,
	// "contestant2Success" => &$contestants[1]->success,
	"firstPlace" => &$winner_list[0]->name,
	"secondPlace" => &$winner_list[1]->name,
	"thirdPlace" => &$winner_list[2]->name
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));


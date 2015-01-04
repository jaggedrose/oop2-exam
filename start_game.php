<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get the first player from the database, 
// we know that this is always the human player
$player = &$ds->player[0];
$playerName = $player->name;
$playerClass = get_class($player);

$randomChallengeNr = rand(0, 2);

$challengeJsonPath = "./data/challenge" . $randomChallengeNr . ".json";

//try to get the challenge json
$challengeData = file_get_contents($challengeJsonPath);

//if we did not find our story file, exit script
if (!$challengeData) {
  echo("Challenge json not found! ".$game_data_path);
  exit();
}

//json_decode($json_data, true) turns json into associative arrays
$challenge = json_decode($challengeData, true);

if(!$challenge) {
	echo("json_decode failed");
	exit();
}

// Empty components
unset($ds->challenge);

// "Alias" variable for properties
$current_challenge = &$ds->challenge;

$new_challenge = new Challenge($challenge);

// Check if we have a challenge in the DB already
// if (!count($current_challenge)) {
//   //start tracking challenge instance
//   $current_challenge[] = $new_challenge;
// }
// //or if we did load a challenge from the DB
// else {
//   //store a reference to $ds->challenge[0] in the variable $current_challenge
//   $current_challenge = &$ds->challenge[0];
// }

$returnData = array (
	"playerName" => &$playerName,
	"playerClass" => &$playerClass,
	"challenge" => &$challenge
);

echo(json_encode($returnData));
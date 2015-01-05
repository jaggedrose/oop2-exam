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
$player_name = $player->name;
$player_class = get_class($player);

$random_challenge_nr = rand(0, 2);

$challenge_json_path = "./data/challenge" . $random_challenge_nr . ".json";

//try to get the challenge json
$challenge_data = file_get_contents($challenge_json_path);

//if we did not find our story file, exit script
if (!$challenge_data) {
  echo("Challenge json not found! ".$game_data_path);
  exit();
}

//json_decode($json_data, true) turns json into associative arrays
$challenge = json_decode($challenge_data, true);

if(!$challenge) {
	echo("json_decode failed");
	exit();
}

// Empty challenge table in DB
unset($ds->challenge);

// "Alias" variable
$current_challenge = &$ds->challenge;

// Create new challenge instance
$new_challenge = new Challenge($challenge);

//start tracking challenge instance
$current_challenge[] = $new_challenge;

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$playerName,
	"playerClass" => &$playerClass,
	"challenge" => &$challenge
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));
<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get the first player from the database, &$ds->player[0];
// we know that this is always the human player
$player = &$ds->player[0];
$player_name = $player->name;
$player_class = $player->craft;
$companions = &$ds->companions;
$companion1_name = $companions[0]->name;
$companion1_craft = $companions[0]->craft;
$companion2_name = $companions[1]->name;
$companion2_craft = $companions[1]->craft;

// Checking if challenge has been changed, if so minus 5 success points
if (isset($_REQUEST["challenge_change"])) {
  $changed = $_REQUEST["challenge_change"];
  if($changed == "true") {
    $player->success -= 5;
  }
} 

$random_challenge_nr = rand(0, 9);

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

// Cloning player & companions success
$player_success = $player->success;
$companion1_success = $companions[0]->success;
$companion2_success = $companions[1]->success;

// Collect all data needed in an associative array
$return_data = array(
	"playerName" => &$player_name,
	"playerClass" => &$player_class,
  "playerSuccess" => &$player_success,
	"challenge" => &$challenge,
  "companion1Name" => &$companion1_name,
  "companion1Class" => &$companion1_craft,
  "companion1Success" => &$companion1_success,
  "companion2Name" => &$companion2_name,
  "companion2Class" => &$companion2_craft,
  "companion2Success" => &$companion2_success
 );
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));
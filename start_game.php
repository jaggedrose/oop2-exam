<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get the first player from the database, &$ds->myplayer[0];
// We know that this is always the human player
$myplayer = &$ds->myplayer[0];
$myplayer_name = $myplayer->name;
$myplayer_class = $myplayer->craft;
$contestants = &$ds->contestants;
$contestant1_name = $contestants[0]->name;
$contestant1_craft = $contestants[0]->craft;
$contestant2_name = $contestants[1]->name;
$contestant2_craft = $contestants[1]->craft;

// Checking if challenge has been changed, if so minus 5 success points
if (isset($_REQUEST["challenge_change"])) {
  $changed = $_REQUEST["challenge_change"];
  if($changed == "true") {
    $myplayer->changeChallenge();
  }
} 

$random_challenge_nr = rand(0, 9);

$challenge_json_path = "./data/challenge" . $random_challenge_nr . ".json";

// Get the challenge json
$challenge_data = file_get_contents($challenge_json_path);

// If we did not find our challenge file, exit script
if (!$challenge_data) {
  echo("Challenge json not found! ".$game_data_path);
  exit();
}

// json_decode($json_data, true) turns json into associative arrays
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

// Cloning player & contestants success
$myplayer_success = $myplayer->success;
$contestant1_success = $contestants[0]->success;
$contestant2_success = $contestants[1]->success;

// Collect all data needed in an associative array
$return_data = array(
	"myPlayerName" => &$myplayer_name,
	"myPlayerClass" => &$myplayer_class,
  "myPlayerSuccess" => &$myplayer_success,
	"challenge" => &$challenge,
  "contestant1Name" => &$contestant1_name,
  "contestant1Class" => &$contestant1_craft,
  "contestant1Success" => &$contestant1_success,
  "contestant2Name" => &$contestant2_name,
  "contestant2Class" => &$contestant2_craft,
  "contestant2Success" => &$contestant2_success
 );
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));
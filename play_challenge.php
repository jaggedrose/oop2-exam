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
$player = &$ds->player[0];
$player_name = $player->name;
$contestants = &$ds->contestants;
$contestant1_name = &$ds->contestants[0]->name;
$contestant2_name = &$ds->contestants[1]->name;
$challenge = &$ds->challenge[0];

// Checking if challenge is played with companion, if so minus 5 success points
if (isset($_REQUEST["challenge_companion"])) {
	$companion = $_REQUEST["challenge_companion"];
	if($companion == "true") {
		$player->success -= 5;
	}
} 

// Getting results from method carryOutChallenge in character.class.php
$doing_challenge = $player->carryOutChallenge($challenge, $contestants);

// Points after completed challenge
// $player->success += 15;
$player_success = $player->success;
$contestant1_success = $contestants[0]->success;
$contestant2_success = $contestants[1]->success;

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$player_name,
	"contestant1Name" => &$contestant1_name,
	"contestant2Name" => &$contestant2_name,
	"challenge" => &$challenge,
	"doingChallenge" =>&$doing_challenge,
	"playerSuccess" => &$player_success,
	"contestant1Success" => &$contestant1_success,
	"contestant2Success" => &$contestant2_success,
	"challengeResults" => &$challenge_results
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));


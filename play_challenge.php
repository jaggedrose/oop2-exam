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
$challenge = &$ds->challenge[0];

// Getting string in method carryOutChallenge from player.class.php
$doing_challenge = $player->carryOutChallenge();
// Counts the amount of times it takes to complete a challenge
$challenge_counter = $challenge->playChallenge($player);
// Points after completed challenge
$player->success += 15;
$player_success = $player->success;

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$player_name,
	"challenge" => &$challenge,
	"doingChallenge" =>&$doing_challenge,
	"challengeCounter" => &$challenge_counter,
	"playerSuccess" => &$player_success
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));


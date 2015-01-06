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
$player_class = get_class($player);
$challenge = &$ds->challenge[0];

// Getting string in method acceptChallenge from player.class.php
$accepted_string = $player->acceptChallenge($challenge);

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$player_name,
	"playerClass" => &$player_class,
	"challenge" => &$challenge,
	"playerSuccess" => &$player_success,
	"acceptedString" => &$accepted_string
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));

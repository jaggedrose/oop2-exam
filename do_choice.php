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
$player_class = $player->craft;
$companions = &$ds->companions;
$companion1_name = $companions[0]->name;
$companion1_craft = $companions[0]->craft;
$companion2_name = $companions[1]->name;
$companion2_craft = $companions[1]->craft;
$challenge = &$ds->challenge[0];

// Getting string in method acceptChallenge from player.class.php
$accepted_string = $player->acceptChallenge($challenge);

// Cloning player & companions success
$player_success = $player->success;
$companion1_success = $companions[0]->success;
$companion2_success = $companions[1]->success;

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$player_name,
	"playerClass" => &$player_class,
	"playerSuccess" => &$player_success,
	"companion1Name" => &$companion1_name,
	"companion1Class" => &$companion1_craft,
	"companion1Success" => &$companion1_success,
	"companion2Name" => &$companion2_name,
	"companion2Class" => &$companion2_craft,
	"companion2Success" => &$companion2_success,
	"challenge" => &$challenge,	
	"acceptedString" => &$accepted_string
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));

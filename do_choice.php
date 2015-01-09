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
$contestants = &$ds->contestants;
$contestant1_name = $contestants[0]->name;
$contestant1_craft = $contestants[0]->craft;
$contestant2_name = $contestants[1]->name;
$contestant2_craft = $contestants[1]->craft;
$challenge = &$ds->challenge[0];

// Empty tools table in DB
unset($ds->tools);
// "Alias" variable
$tools = &$ds->tools;

$tools[] = new Tool("a Sewing needle",
	array(
		"needlework" => 20
	)
);

$tools[] = new Tool("a Thimble", 
	array(
		"needlework" => 30,
	)
);

$tools[] = new Tool("Beeswax", 
	array(
		"needlework" => 20,
	)
);

$tools[] = new Tool("an Overlock", 
	array(
		"sewing" => 15,
	)
);

$tools[] = new Tool("an Industrial sewing machine", 
	array(
		"sewing" => 30,
	)
);

$tools[] = new Tool("a pair of Tailors shears", 
	array(
		"cutting" => 10,
	)
);

$tools[] = new Tool("a Rotary cutter", 
	array(
		"cutting" => 20,
	)
);

$tools[] = new Tool("a Tape measure", 
	array(
		"patterns" => 20,
	)
);

$tools[] = New Tool("a Grading program", 
	array(
		"patterns" => 20,
	)
);

// Getting string in method acceptChallenge from player.class.php
$accepted_string = $player->acceptChallenge($challenge);

// Cloning player & contestants success
$player_success = $player->success;
$contestant1_success = $contestants[0]->success;
$contestant2_success = $contestants[1]->success;

// Collect all data needed in an associative array
$return_data = array (
	"playerName" => &$player_name,
	"playerClass" => &$player_class,
	"playerSuccess" => &$player_success,
	"contestant1Name" => &$contestant1_name,
	"contestant1Class" => &$contestant1_craft,
	"contestant1Success" => &$contestant1_success,
	"contestant2Name" => &$contestant2_name,
	"contestant2Class" => &$contestant2_craft,
	"contestant2Success" => &$contestant2_success,
	"challenge" => &$challenge,	
	"acceptedString" => &$accepted_string
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));

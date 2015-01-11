<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get needed info from DB
$myplayer = &$ds->myplayer[0];
$myplayer_name = $myplayer->name;
$myplayer_class = $myplayer->craft;
$contestants = &$ds->contestants;
$contestant1_name = $contestants[0]->name;
$contestant1_craft = $contestants[0]->craft;
$contestant2_name = $contestants[1]->name;
$contestant2_craft = $contestants[1]->craft;
$challenge = &$ds->challenge[0];
$tools = &$ds->tools;

// Getting string in method acceptChallenge from character.class.php
$accepted_string = $myplayer->acceptChallenge($challenge, $tools);

// Cloning my player & contestants success & my tools
$myplayer_success = $myplayer->success;
$contestant1_success = $contestants[0]->success;
$contestant2_success = $contestants[1]->success;
$my_tools = $myplayer->mytools;

// Collect all data needed in an associative array
$return_data = array (
	"myPlayerName" => &$myplayer_name,
	"myPlayerClass" => &$myplayer_class,
	"myPlayerSuccess" => &$myplayer_success,
	"contestant1Name" => &$contestant1_name,
	"contestant1Class" => &$contestant1_craft,
	"contestant1Success" => &$contestant1_success,
	"contestant2Name" => &$contestant2_name,
	"contestant2Class" => &$contestant2_craft,
	"contestant2Success" => &$contestant2_success,
	"challenge" => &$challenge,
	"myTools" => &$my_tools,	
	"acceptedString" => &$accepted_string
);
// Takes array, encodes it to Json & sends it to Ajax
echo(json_encode($return_data));

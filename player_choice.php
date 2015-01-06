<?php

// JSON data example from main.js
//  data: {
//    player_name : chosenName,
// 		player_class : chosenClass
//  },

// Make sure the ajax is sending the required data
if (isset($_REQUEST["player_name"]) && isset($_REQUEST["player_class"])) {
  //store data in variables
  $player_name = $_REQUEST["player_name"];
  $player_class = $_REQUEST["player_class"];
} 
else {
  //not enough required data was received, exit script
  echo(json_encode(false));
  exit();
}

// Start new game
include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Empty player table in DB
unset($ds->player);
unset($ds->companions);

// "Alias" variable 
$player = &$ds->player;
$companions = &$ds->companions;

// Create new player instance
$new_player = new $player_class($player_name);

//start tracking player instance
$player[] = $new_player;

//Make 2 computer players
$classes = array("Dressmaker", "Tailor", "Patternmaker"); 

$used_class_index = array_search($player_class, $classes);
array_splice($classes, $used_class_index, 1);

$companions[] = new $classes[0]("Coco");
$companions[] = new $classes[1]("Christian");

$return_data = array (
  "newPlayer" => &$new_player,
  "companions" => &$companions
);

// ToDo - used for checking console.log, change to echo(json_encode(true));
// Takes $return_data array encodes it to Json, sends it to Ajax
echo(json_encode($return_data));
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

// "Alias" variable 
$player = &$ds->player;

// Create new player instance
$new_player = new $player_class($player_name);

//start tracking player instance
$player[] = $new_player;

// ToDo - used for checking console.log, change to echo(json_encode(true));
// Takes $new_player instance encodes it to Json, sends it to Ajax
echo(json_encode($new_player));
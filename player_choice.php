<?php

// JSON data example from main.js
//  data: {
//    player_name : chosenName,
// 		player_class : chosenClass
//  },


if (!isset($_REQUEST["player_name"]) || !isset($_REQUEST["player_class"])) {
  //if not enough request data was received, exit script
  echo(json_encode(false));
  exit();
} 
else {
  //else store data in variables
  $player_name = $_REQUEST["player_name"];
  $player_class = $_REQUEST["player_class"];
  // echo(json_encode($player_class));
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

// Empty components
unset($ds->player);

// "Alias" variable for properties
$player = &$ds->player;


// Create new player with chosen player class
$new_player = new $player_class($player_name);

// Check if we have any players in the DB already
if (!count($player)) {
  //start tracking player instance
  $player[] = $new_player;
}
//or if we did load any players from the DB
else {
  //store a reference to $ds->players[0] in the variable $player
  $player = &$ds->player[0];
}


echo(json_encode($new_player));
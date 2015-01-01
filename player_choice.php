<?php

include_once("nodebite-swiss-army-oop.php");

// $ds = new DBObjectSaver(array(
//   "host" => "127.0.0.1",
//   "dbname" => "wu14oop2",
//   "username" => "root",
//   "password" => "mysql",
//   "prefix" => "exam_game"
// ));

// JSON data example from main.js
// data: {
// 			// game_id : 0,
// 			// create_player: {
// 			//   "class" : "Aria",
// 			//   "name" : "aName"
// 			player_name : chosenName,
// 			player_class : chosenClass
// 			},


if (!isset($_REQUEST["player_name"]) || !isset($_REQUEST["player_class"])) {
  //if not enough request data was recieved, exit script
  echo(json_encode(false));
  exit();
} 
else {
  //else store data in variables
  $player_name = $_REQUEST["player_name"];
  $player_class = $_REQUEST["player_class"];
  // echo(json_encode($player_class));
}



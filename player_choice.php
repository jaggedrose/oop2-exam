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

if (strcmp($player_class, "Tailor") == 0) {
	$player = new Tailor($player_name);
}
elseif (strcmp($player_class, "Dressmaker") == 0) {
	$player = new Dressmaker($player_name);
}
else (strcmp($player_class, "Pattern Maker") == 0){
	$player = new Patternmaker($player_name);
}

// if(!count($ds->players)) {
//   echo("<br>Created new player");
//   $coco = New Player("Coco");
//   $ds->players[] = $coco;
// }
// else {
//     $coco = &$ds->players[0];
// }



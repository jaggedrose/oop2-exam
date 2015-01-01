<?php

include_once("nodebite-swiss-army-oop.php");

// $ds = new DBObjectSaver(array(
//   "host" => "127.0.0.1",
//   "dbname" => "wu14oop2",
//   "username" => "root",
//   "password" => "mysql",
//   "prefix" => "exam_game"
// ));


if (!isset($_REQUEST["player_name"])) {
  //if not enough request data was recieved, exit script
  echo(json_encode(false));
  exit();
} 
else {
  //else store data in variables
  $player_name = $_REQUEST["player_name"];
  echo(json_encode($player_name));
}


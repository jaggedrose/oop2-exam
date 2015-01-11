<?php

// JSON data example from main.js
//  data: {
//    myplayer_name : chosenName,
// 		player_class : chosenClass
//  },

// Make sure the ajax is sending the required data
if (isset($_REQUEST["myplayer_name"]) && isset($_REQUEST["player_class"])) {
  // Store data in variables
  $myplayer_name = $_REQUEST["myplayer_name"];
  $player_class = $_REQUEST["player_class"];
} 
else {
  // Not enough required data was received, exit script
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

// Empty tables in DB
unset($ds->myplayer);
unset($ds->contestants);
unset($ds->tools);
// "Alias" variable
$myplayer = &$ds->myplayer;
$contestants = &$ds->contestants;
$tools = &$ds->tools;

// Create new tools
$tools[] = new Tool("A sewing needle.",
  array(
    "needlework" => 20
  )
);

$tools[] = new Tool("A thimble.", 
  array(
    "needlework" => 30,
  )
);

$tools[] = new Tool("Beeswax.", 
  array(
    "needlework" => 20,
  )
);

$tools[] = new Tool("An overlock.", 
  array(
    "sewing" => 15,
  )
);

$tools[] = new Tool("An industrial sewing machine.", 
  array(
    "sewing" => 30,
  )
);

$tools[] = new Tool("A pair of tailors shears.", 
  array(
    "cutting" => 10,
  )
);

$tools[] = new Tool("A rotary cutter.", 
  array(
    "cutting" => 20,
  )
);

$tools[] = new Tool("A tape measure.", 
  array(
    "patterns" => 20,
  )
);

$tools[] = New Tool("A grading program", 
  array(
    "patterns" => 20,
  )
);

// Create new player instance
$new_player = new $player_class($myplayer_name, $player_class);

// Start tracking player instance
$myplayer[] = $new_player;

// Make 2 computer players (contestants)
$classes = array("Dressmaker", "Tailor", "Patternmaker"); 

$used_class_index = array_search($player_class, $classes);
array_splice($classes, $used_class_index, 1);

$contestants[] = new $classes[0]("Coco", $classes[0]);
$contestants[] = new $classes[1]("Christian", $classes[1]);

echo(json_encode(true));

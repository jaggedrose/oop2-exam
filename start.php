<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));


if(!isset($ds->players)) {
	$ds->players = array();
}

if(isset($ds->story)) {
	$ds->story = array();
}


// if(!count($ds->players)) {
//   echo("<br>Created new player");
//   $coco = New Player("Coco");
//   $ds->players[] = $coco;
// }
// else {
//     $coco = &$ds->players[0];
// }











$ds->companionPlayers = array("Coco","Vivienne","Tom","Marc");

$unusedNames = array_diff($ds->companionPlayers,$ds->usedNames);

if(count($ds->usedNames)>0){
  echo('<p>Your companion players:</p>'
    .implode('<br>',$ds->usedNames).'<hr>');
}

$newName = $unusedNames[array_rand($unusedNames)];
$ds->players[$newName] = new Player($newName);
$ds->usedNames[] = $newName;
echo('<p>Created player: '.$newName.'!</p>');

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

echo("<br>Did anything work?");

if(!count($ds->players)) {
  echo("<br>Created new player");
  $coco = New Player("Coco");
  $ds->players[] = $coco;
}
else {
    $coco = &$ds->players[0];
}
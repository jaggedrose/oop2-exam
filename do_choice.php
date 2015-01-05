<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

// Get player & challenge from DB
$player = &$ds->player[0];
$challenge = &$ds->challenge[0];

// calling string in method acceptChallenge from player.class.php
$accepted_string = $player->acceptChallenge($challenge);

echo(json_encode($accepted_string));



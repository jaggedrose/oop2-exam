<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

if (isset($_REQUEST["startAgain"])) {
  unset($ds->myplayer);
  unset($ds->challenge);
  unset($ds->contestants);
  unset($ds->tools);
}

echo(json_encode(true));
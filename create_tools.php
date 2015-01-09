<?php

include_once("nodebite-swiss-army-oop.php");

$ds = new DBObjectSaver(array(
  "host" => "127.0.0.1",
  "dbname" => "wu14oop2",
  "username" => "root",
  "password" => "mysql",
  "prefix" => "exam_game"
));

$tools[] = New Tool(
	"a Sewing needle", 
	array(
		"needlework" => 20,
	)
);

$tools[] = New Tool(
	"a Thimble", 
	array(
		"needlework" => 30,
	)
);

$tools[] = New Tool(
	"Beeswax", 
	array(
		"needlework" => 20,
	)
);

$tools[] = New Tool(
	"an Overlock", 
	array(
		"sewing" => 15,
	)
);

$tools[] = New Tool(
	"an Industrial sewing machine", 
	array(
		"sewing" => 30,
	)
);

$tools[] = New Tool(
	"a pair of Tailors shears", 
	array(
		"cutting" => 10,
	)
);

$tools[] = New Tool(
	"a Rotary cutter", 
	array(
		"cutting" => 20,
	)
);

$tools[] = New Tool(
	"a Tape measure", 
	array(
		"patterns" => 20,
	)
);

$tools[] = New Tool(
	"a Grading program", 
	array(
		"patterns" => 20,
	)
);



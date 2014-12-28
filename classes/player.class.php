<?php

class Player extends Base {

	public $name;
	public $success = 50;

	public $hand_stitching;
	public $sewing;
	public $cutting;
	public $patterns;

	public function __construct($name) {
    	$this->name = $name;
    }
	
}
<?php

class Player extends Base {

	public $name;
	public $success = 50;

	public function __construct($name) {
    	$this->name = $name;
    }
	
}
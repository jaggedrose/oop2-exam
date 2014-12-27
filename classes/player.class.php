<?php

class Player extends Base {

	public $name;
	protected $success = 50;

	protected $hand_stitching;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name) {
    	$this->name = $name;
    }
	
}
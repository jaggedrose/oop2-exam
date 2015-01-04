<?php

class Player extends Base {

	protected $name;
	protected $success = 50;

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name) {
    	$this->name = $name;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_success() {
		return $this->success;
	}

	public function get_needlework() {
		return $this->needlework;
	}

	public function set_needlework($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Skill level must be within 0 - 100");
		}
		$this->needlework = $val;
	}

	public function get_sewing() {
		return $this->sewing;
	}

	public function get_cutting() {
		return $this->cutting;
	}

	public function get_patterns() {
		return $this->patterns;
	}

   
    // greet
	public function greet() {
		return "Hello ".$this->name. "! You are a ".$this->class;
	}


	
}
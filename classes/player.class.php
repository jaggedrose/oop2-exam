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

	// Getters & setters
	public function get_name() {
		return $this->name;
	}

	public function get_success() {
		return $this->success;
	}

	public function get_needlework() {
		return $this->needlework;
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


	public function set_success($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Success must be within 0 - 100");
		}
		$this->success = $val;
	}

	public function set_needlework($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Needlework skill must be within 0 - 100");
		}
		$this->needlework = $val;
	}

	public function set_sewing($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Sewing skill must be within 0 - 100");
		}
		$this->sewing = $val;
	}

	public function set_cutting($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Cutting skill must be within 0 - 100");
		}
		$this->cutting = $val;
	}

	public function set_patterns($val) {
		if ($val < 0 || $val > 100) {
			throw new Exception("Patterns skill must be within 0 - 100");
		}
		$this->patterns = $val;
	}

   
   


	
}
<?php

class Challenge extends Base {
	
	public $id;
	public $title;
	public $description;
	public $needlework = 0;
	public $sewing = 0;
	public $cutting = 0;
	public $patterns = 0;

	public function __construct($challenge) {

		$this->id = $challenge["id"];
		$this->title = $challenge["title"];
		$this->description = $challenge["decription"];
		$this->needlework = $challenge["skills"]["needlework"];
		$this->sewing = $challenge["skills"]["sewing"];
		$this->cutting = $challenge["skills"]["cutting"];
		$this->patterns = $challenge["skills"]["patterns"];
	}
   


}


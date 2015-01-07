<?php

class Team extends Character {

	public $teamMembers = array();

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name, $myPlayer, $companionPlayer) {
		$this->teamMembers[] = $myPlayer;
		$this->teamMembers[] = $companionPlayer;

		// sum skill points of team members
		$this->needlework = $myPlayer->needlework + $companionPlayer->needlework;
		$this->sewing = $myPlayer->sewing + $companionPlayer->sewing;
		$this->cutting = $myPlayer->cutting + $companionPlayer->cutting;
		$this->patterns = $myPlayer->patterns + $companionPlayer->patterns;

	parent::__construct($name);

}
<?php

class Team extends Character {

	public $teamMembers = array();

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name, $myPlayer, $contestantPlayer) {
		$this->teamMembers[] = $myPlayer;
		$this->teamMembers[] = $contestantPlayer;

		// sum skill points of team members
		$this->needlework = $myPlayer->needlework + $contestantPlayer->needlework;
		$this->sewing = $myPlayer->sewing + $contestantPlayer->sewing;
		$this->cutting = $myPlayer->cutting + $contestantPlayer->cutting;
		$this->patterns = $myPlayer->patterns + $contestantPlayer->patterns;

	parent::__construct($name);

}
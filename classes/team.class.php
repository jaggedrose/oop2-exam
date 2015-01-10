<?php

class Team extends Character {

	public $team_members = array();

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name, $my_player, $contestant_player) {
		$this->teamMembers[] = $my_player;
		$this->teamMembers[] = $contestant_player;

		// sum skill points of team members
		$this->needlework = $my_player->needlework + $contestant_player->needlework;
		$this->sewing = $my_player->sewing + $contestant_player->sewing;
		$this->cutting = $my_player->cutting + $contestant_player->cutting;
		$this->patterns = $my_player->patterns + $contestant_player->patterns;

	parent::__construct($name);

}
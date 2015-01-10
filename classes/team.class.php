<?php

class Team extends Character {

	public $team_members = array();
	public $mytools = array();

	protected $needlework;
	protected $sewing;
	protected $cutting;
	protected $patterns;

	public function __construct($name, $my_player, $contestant_player) {
		$this->team_members[] = $my_player;
		$this->team_members[] = $contestant_player;

		// sum skill points of team members
		$this->needlework = $my_player->needlework + $contestant_player->needlework;
		$this->sewing = $my_player->sewing + $contestant_player->sewing;
		$this->cutting = $my_player->cutting + $contestant_player->cutting;
		$this->patterns = $my_player->patterns + $contestant_player->patterns;

		// Add tools to a team, if any player can have tools
    	for ($i=0; $i < count($this->team_members); $i++) { 
      	for ($j=0; $j < count($this->team_members[$i]->mytools); $j++) { 
        		$this->mytools[] = $this->team_members[$i]->mytools[$j];
      	}
   	}

		parent::__construct($name, "");
	}

}
<?php

class Schedule
{
	private $id;
	private $state;
	private $numSchedule;
	private $description;

	function __construct()
	{}

	/**********************************
	Setters 
	**********************************/
	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setState($pState)
	{
		$this->state = $pState;
	}

	public function setNumSchedule($pNumSchedule)
	{
		$this->numSchedule = $pNumSchedule;
	}

	public function setDescription($pDescription)
	{
		$this->description = $pDescription;
	}


	/**********************************
	Getters 
	**********************************/
	public function getId()
	{
		return $this->id;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getNumSchedule()
	{
		return $this->numSchedule;
	}

	public function getDescription()
	{
		return $this->description;
	}

}

?>
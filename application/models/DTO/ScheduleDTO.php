<?php

class ScheduleDTO{
	/****************************************
	Variables
	****************************************/
	private $idSchedule;
	private $description;
	private $numberSchedule;
	private $state;

	function __construct()
	{
		$this->idSchedule  = 0;
		$this->description = '';
		$this->numberSchedule = 0;
		$this->state = 0;
	}


	/* Setters and Getters */
	public function setIdSchedule($pIdSchedule)
	{
		$this->idSchedule = $pIdSchedule;
	}


	public function setDescription($pDescription)
	{
		$this->description = $pDescription;
	}


	public function setState($pState)
	{
		$this->state = $pState;
	}

	public function setNumberSchedule($pNumberSchedule)
	{
		$this->numberSchedule = $pNumberSchedule;
	}


	public function getId()
	{
		return $this->idSchedule;
	}


	public function getDescription()
	{
		return $this->description;
	}


	public function getState()
	{
		return $this->state;
	}

	public function getNumberSchedule()
	{
		return $this->numberSchedule;
	}
}
?>
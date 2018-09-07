<?php

class ScheduleDTO{
	/****************************************
	Variables
	****************************************/
	private $idSchedule;
	private $initialTime;
	private $finishTime;
	private $day;
	private $state;

	function __construct()
	{
		$this->idSchedule = 0;
		$this->initialTime = 0;
		$this->finishTime = 0;
		$this->day = 0;
		$this->state = 0;
	}

	/* Setters and Getters */

	public function setIdSchedule($pIdSchedule)
	{
		$this->idSchedule = $pIdSchedule;
	}

	public function setInitialTime($pInitialTime)
	{
		$this->initialTime = $pInitialTime;
	}

	public function setFinishTime($pFinishTime)
	{
		$this->finishTime = $pFinishTime;
	}

	public function setDay($pDay)
	{
		$this->day = $pDay;
	}

	public function setState($pState)
	{
		$this->state = $pState;
	}

	public function getId()
	{
		return $this->idSchedule;
	}

	public function getInitialTime()
	{
		return $this->initialTime;
	}

	public function getFinishTime()
	{
		return $this->finishTime;
	}

	public function getDay()
	{
		return $this->day;
	}

	public function getState()
	{
		return $this->state;
	}

	/* Finish the setters and getters */
}

?>
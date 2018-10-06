<?php

class Schedule
{
	private $day;
	private $initialHour;
	private $finalHour;

	function __construct($pDay, $pInitialHour, $pFinalHour)
	{
		$this->day = $pDay;
		$this->initialHour = $pInitialHour;
		$this->finalHour = $pFinalHour;
	}

	public function setDay($pDay)
	{
		$this->day = $pDay;
	}

	public function setInitialHour($pInitialHour)
	{
		$this->initialHour = $pInitialHour;
	}

	public function setFinalHour($pFinalHour)
	{
		$this->finalHour = $pFinalHour;
	}

	public function getDay()
	{
		return $this->day;
	}

	public function getInitialHour()
	{
		return $this->initialHour;
	}

	public function getFinalHour()
	{
		return $this->finalHour;
	}

}

?>
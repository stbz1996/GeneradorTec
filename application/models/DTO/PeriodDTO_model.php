<?php

class PeriodDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idPeriod;
	private $number;
	private $year;

	function __construct()
	{
		$this->idPeriod = 0;
		$this->number = 0;
		$this->year = 0;
	}

	/* Setters and Getters */

	public function setIdPeriod($pIdPeriod)
	{
		$this->idPeriod = $pIdPeriod;
	}

	public function setNumber($pNumber)
	{
		$this->number = $pNumber;
	}

	public function setYear($pYear)
	{
		$this->year = $pYear;
	}

	public function getId()
	{
		return $this->idPeriod;
	}

	public function getNumber()
	{
		return $this->number;
	}

	public function getYear()
	{
		return $this->year;
	}

	/* Finish the setters and getters */


}

?>
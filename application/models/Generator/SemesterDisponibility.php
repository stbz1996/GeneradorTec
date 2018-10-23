<?php

class SemesterDisponibility {
	/****************************************
	Variables
	****************************************/
	private $listOfSchedules;
	private $numBlocks;
	private $numSchedules;
	private $numDays;

	function __construct()
	{
	}

	/**********************************************
	Fill the matrix [$pBlocks][$pSchedules][$pDays]
	***********************************************/
	function fillInformation($pBlocks, $pSchedules)
	{
		$this->numBlocks    = $pBlocks;
		$this->numSchedules = $pSchedules;
		for ($i = 1; $i <= $this->numBlocks; $i++) 
		{
			for ($j = 1; $j <= $this->numSchedules; $j++) 
			{ 
			 	$this->listOfSchedules[$i][$j] = 0;
			} 
		}
	}


	/**********************************************************
	If the space is available, put in 1 the schedule 
	**********************************************************/
	function activeSchedule($pBlocks, $pSchedules)
	{
		if ($this->listOfSchedules[$pBlocks][$pSchedules] == 0) 
		{
			$this->listOfSchedules[$pBlocks][$pSchedules] = 1;
		}
	}


	/**********************************************************
	If the space is available, put in 1 the schedule 
	**********************************************************/
	function desactivateSchedule($pBlocks, $pSchedules)
	{
		if ($this->listOfSchedules[$pBlocks][$pSchedules] == 1) 
		{
			$this->listOfSchedules[$pBlocks][$pSchedules] = 0;
		}
	}


	/**********************************************************
	Insert an element in the matrix if the field is empty(0) 
	and return 1 or return 0 if the fiel is not empty
	**********************************************************/
	function changeElementInMatrix($pBlock, $pSchedule, $pVal)
	{
		$this->listOfSchedules[$pBlock][$pSchedule] = $pVal;
	}


	/*****************************************************
	*Returns 0: If the schedule is blocked by the carrer *
	*Returns 1: If is an available schedule              *
	*Returns 2: If is not an available schedule          *
	*****************************************************/
	public function verifyScheduleState($pBlocks, $pSchedules)
	{
		return $this->listOfSchedules[$pBlocks][$pSchedules];
	}


	/***************
	Print the matrix
	****************/
	function showMatrix()
	{
		for ($i = 1; $i <= $this->numBlocks; $i++) 
		{
			for ($j = 1; $j <= $this->numSchedules; $j++) 
			{ 
			 	echo $this->listOfSchedules[$i][$j].'-';
			}
			echo " Fin de bloque "; 
		}
	}
}
?>
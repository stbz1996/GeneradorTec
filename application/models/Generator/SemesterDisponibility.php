<?php

class SemesterDisponibility {
	/****************************************
	Variables
	****************************************/
	private $listOfEmailSent;
	private $numBlocks;
	private $numSchedules;
	private $numDays;

	function __construct()
	{
	}

	/**********************************************
	Fill the matrix [$pBlocks][$pSchedules][$pDays]
	***********************************************/
	function fillInformation($pBlocks, $pSchedules, $pDays)
	{
		$this->numBlocks    = $pBlocks;
		$this->numSchedules = $pSchedules;
		$this->numDays      = $pDays;

		for ($i = 1; $i <= $this->numBlocks; $i++) 
		{
			for ($j = 1; $j <= $this->numSchedules; $j++) 
			{ 
			 	for ($k = 1; $k <= $this->numDays; $k++) 
			 	{ 
			 		$data[$i][$j][$k] = 1;
			 	}
			 } 
		}
		$this->listOfEmailSent = $data;
	}


	/**********************************************************
	Insert an element in the matrix if the field is empty(0) 
	and return 1 or return 0 if the fiel is not empty
	**********************************************************/
	function insertInMatrix($pBlocks, $pSchedules, $pDays, $pVal){
		$this->listOfEmailSent[$pBlocks][$pSchedules][$pDays] = $pVal;
	}


	/**********************************************************
	Returns 1 if the field was empty and was selected. 
	Returns 0 if the field is not empty and cant be blocked
	**********************************************************/
	function selectSchedule($pBlocks, $pSchedules, $pDays){
		if ($this->listOfEmailSent[$pBlocks][$pSchedules][$pDays] == 0) {
			$this->listOfEmailSent[$pBlocks][$pSchedules][$pDays] = 1;
			return 1;
		}
		else{
			return 0;
		}
	}


	/**********************************************************
	Put a Schedule empty (with 0) 
	**********************************************************/
	function unSelectSchedule($pBlocks, $pSchedules, $pDays){
		$this->listOfEmailSent[$pBlocks][$pSchedules][$pDays] = 0;
	}


	/******************************
	Get an element in the matrix
	*******************************/
	function getElement($pBlocks, $pSchedules, $pDays){
		return $this->listOfEmailSent[$pBlocks][$pSchedules][$pDays];
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
			 	for ($k = 1; $k <= $this->numDays; $k++) 
			 	{ 
			 		echo $this->listOfEmailSent[$i][$j][$k].'-';
			 	}
			 	echo " Fin de fila ";
			}
			echo " Fin de bloque "; 
		}
		echo '########################';
	}
}
?>
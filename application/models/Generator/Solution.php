<?php

class Solution
{
	private $magistralClassesList;
	private $semDisp;
	private $points = 0;
	
	function __construct(){}

	
	/* JORGEEEEEEEEEEEEEEEEEEEEEEEEEEE */
	private function filterBySpacesBetweenSchedules()
	{

	}



	/***************************************************************
	*Function that apply a filter to assign points to the solution *
	***************************************************************/
	private function filterByCM($pList)
	{
		$days = array(0,0,0,0,0,0);
		$block = 1; 
		foreach ($pList as $cm) 
		{
			// Make the sume with the magistral class evaluation
			$this->points += $cm->getEvaluation();

			$newBlock = $cm->getCourse()->getBlock()->getNumber();
			if ($block != $newBlock) 
			{
				// Save the points according with the free days in a block
				foreach ($days as $day){
					if ($day == 0) {
						$this->points += 5;
					}
				}
				$block = $newBlock;
				$days  = array(0,0,0,0,0,0);
			}

			// Save the points according with time of the day (morning, late, nigth)
			$schedules = $cm->getAssignedSchedules();
			foreach ($schedules as $schedule) 
			{
				if ($schedule <= 30) 
				{
					$this->points += 3;
				}
				elseif ($schedule <= 60) 
				{
					$this->points += 1;
				}

				$val = (($schedule-1) % 6);
				$days[$val] += 1;
			}
		}

		// Save the points according with the free days in a block.
		// It is used for the last iteration
		foreach ($days as $day){
			if ($day == 0) {
				$this->points += 5;
			}
		}
	}


	// SETTERS
	public function setMagistralClassesList($pList, $pSem)
	{
		$this->magistralClassesList = $pList;
		$this->semDisp = $pSem;
		$this->filterByCM($pList);
		$this->filterBySpacesBetweenSchedules();
	}


	public function setPoints($pPoints)
	{
		$this->points = $pPoints;
	}


	// GETTERS 
	public function getMagistralClassesList()
	{
		return $this->magistralClassesList;
	}


	public function getPoints()
	{
		return $this->points;
	}
}
?>
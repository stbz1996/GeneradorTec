<?php

class Solution
{
	private $magistralClassesList;
	private $semDisp;
	private $points = 0;
	
	function __construct(){}

	
	/***************************************************************
	*Function that apply a filter to assign points to the solution *
	*by spaces between schedules. 								   *
	***************************************************************/
	private function filterBySpacesBetweenSchedules($pList)
	{
		$schedulesBlock = array();
		$actualBlock = 1;
		foreach ($pList as $cm) 
		{
			$newBlock = $cm->getCourse()->getBlock()->getNumber();

			/* Check if there's new block*/
			if($actualBlock != $newBlock)
			{
				$this->points -= $this->assignPointSpaces($schedulesBlock);
				$actualBlock = $newBlock;
				$schedulesBlock = array();
			}

			/* Get assigned schedules and store in schedulesBlock*/
			$schedulesCM = $cm->getAssignedSchedules();
			$schedulesBlock = array_merge($schedulesBlock, $schedulesCM);
		}

		/* Assign points of the last block */
		$this->points -= $this->assignPointSpaces($schedulesBlock);
	}

	/***************************************************************
	*Function that get points of schedules between spaces 		   *
	***************************************************************/
	private function assignPointSpaces($schedules)
	{
		$lostPoints = 0;

		/* Get and go through group of schedules by day */
		sort($schedules);
		$groupSchedules = $this->getGroupSchedules($schedules);		
		foreach ($groupSchedules as $group)
		{

			/* If first element doesn't correspond the first schedules*/
			if($group[0] > 6)
			{
				//There's available space before the first schedule
				$points = ($group[0] - ($group[0] % 6)) / 6;

				/* Case last day*/
				if(!($group[0] % 6))
				{
					$points -= 1;
				}

				/* Assign points */
				$lostPoints += 3*$points;
			}

			/* Go through each group */
			for($i = 1; $i < count($group); $i++)
			{
				/* Get points */
				$points = (($group[$i] - $group[$i - 1]) / 6) - 1;

				/* Case there's space between schedules */
				if($points)
				{
					$lostPoints += 3*$points;
				}
			}
		}
		return $lostPoints;
	}

	/***************************************************************
	*Function that get group of schedules by day.		 		   *
	***************************************************************/
	private function getGroupSchedules($schedules)
	{
		$groupSchedules = array();

		foreach ($schedules as $schedule)
		{
			$pos = ($schedule - 1) % 6;
			$groupSchedules[$pos][] = $schedule;
		}

		return $groupSchedules;
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
				else
				{
					$this->points -= 1;
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
		$this->filterBySpacesBetweenSchedules($pList);
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
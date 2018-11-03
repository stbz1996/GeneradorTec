<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generator_Logic
{
	function __construct(){}


	/********************************************************
	*Function that order a list                             *
	*Input: 									            *
	*	-array: It is the array to order                    *
	*Output: 									            *
	*	-Returns the array sorted                           *
	********************************************************/
	private function quick_sort($array)
	{
		$length = count($array);
		if($length <= 1)
		{
			return $array;
		}
		else
		{
			$pivot = $array[0];
			$left = $right = array();
			for($i = 1; $i < count($array); $i++)
			{
				if($array[$i] < $pivot)
				{
					$left[] = $array[$i];
				}
				else
				{
					$right[] = $array[$i];
				}
			}
			return array_merge(
						$this->quick_sort($left), 
						array($pivot), 
						$this->quick_sort($right)
					);
		}	
	}


	/***********************************************************
	*Function that returns a list of valid schedules according *
	*with the schedules of 2 and 2 not continuos lessons.      *
	*Input:          							               *
	*	-pProfessorScheduleList: It is the array that we       *
	*    have to use to get the schedules                      *
	*Output: 									               *
	*	-Returns an array with valid schedules                 *
	***********************************************************/
	private function getValidSchedulesTuples($pProfessorScheduleList)
	{
		$result = array();
		$rest = array();
		$validTuples = $this->getValidSchedulesNcontinuos($pProfessorScheduleList, 2);
	 	foreach ($validTuples as $tv1) 
	 	{
	 		foreach ($validTuples as $tv2) 
	 		{
	 			$validSchedule = $this->quick_sort(array($tv1[0],$tv1[1],$tv2[0],$tv2[1]));
				$tries = 6 - ($tv1[0] % 6);
				if ($tries < 6)
				{
					$val1 = $tv1[0];
				    $val2 = $tv1[1];
					for ($i = 1; $i <= $tries; $i++) 
					{ 
						$val1 += 1;
				    	$val2 += 1;
						if (($tv2[0] == $val1) && ($tv2[1] == $val2)) 
						{
							if ($this->findElemtInArray($validSchedule, $result) == false) 
				 			{
				 				if(!((($validSchedule[0] <= 30) && 
				 					  ($validSchedule[2] > 30)) 
				 					  ||
									  (($validSchedule[1] <= 30)  && 
									  ($validSchedule[3] > 30))))
								{
									if (($validSchedule[1] - $validSchedule[0]) >= 2) {
										array_push($result, $validSchedule);
										
									}
									else{
										array_push($rest, $validSchedule);
									}
								}
				 			}
						}
					}
				}
	 		}
	 	}
	 	$merge = array_merge($result, $rest);
	 	return $merge;
	}


	/***********************************************************
	*Function that returns a list of valid schedules according *
	*with the schedules of N continuos lessons.                *
	*Input:          							               *
	*	-pProfessorScheduleList: It is the array that we       *
	*    have to use to get the schedules                      *
	*Output: 									               *
	*	-Returns an array with valid schedules                 *
	***********************************************************/
	private function getValidSchedulesNcontinuos($pProfessorScheduleList, $numLessons)
	{
		$result = array();
		$list = $this->quick_sort($pProfessorScheduleList);
		$len = count($list);

		for ($i=0; $i <= $len-$numLessons; $i++) { 
			$val = $list[$i];
			$tempResult = array();
			array_push($tempResult, $val);
			for ($k= 0; $k < ($numLessons-1); $k++) { 
				$x = $this->nextSchdule($val, $list, $i);
				if ($x) {
					array_push($tempResult, $x);
					$val = $x;
				}
				else{
					break;
				}
			}
			if (count($tempResult) == $numLessons) 
			{
				array_push($result, $tempResult);
			}
		}
	 	return $result;
	}


	/***********************************************************
	*Function that receives the schedule N and returns the next*
	*schedule if exist, if not, returns false                  *
	*Input:          							               *
	*	-$schedule: It is the initial schedule                 *
	*   -$list: It is the list where is gonna find the         *
	*				schedule                                   *
	*	-$i: It is the index of the beginning in the list,     *
	* 		 to find just the rigth schedules                  *
	*Output: 									               *
	*	-Returns an array with valid schedules                 *
	***********************************************************/
	private function nextSchdule($schedule, $list, $i)
	{
		$len = count($list);
		for ($i; $i < $len; $i++) { 
			$val = $list[$i] - $schedule;
			if ($val == 6) {
				return $list[$i];
			}
		}
		return false;
	}


	/***********************************************************
	*Function that returns true if an elemt is in an array     *
	*or returns false if isn't                                 *
	*Input:          							               *
	*	-$elem: It is the elemt to find in the list            *
	*   -$array: It is the list to find the element            *
	*Output: 									               *
	*	-Returns true or false                                 *
	***********************************************************/
	public function findElemtInArray($elem, $array)
	{
		foreach ($array as $a) {
			if ($a == $elem) {
				return true;
			}
		}
		return false;
	}


	/***************************************************************
	*Function that returns a list of valid schedules according     *
	*Input:          							                   *
	*	-pProfessorScheduleList: It is the array that we have      * 
	*    to use to get the schedules                               *
	*   -numLessons: It is the number of lessons for the schedules *
	*Output: 									                   *
	*	-Returns an array with valid schedules                     *
	***************************************************************/
	public function getValidSchedules($pProfessorScheduleList, $numLessons)
	{
		$tuples = $this->getValidSchedulesTuples($pProfessorScheduleList);
		$temp   = $this->getValidSchedulesNcontinuos($pProfessorScheduleList, $numLessons);
		$nContinuos = $this->deleteInvalidSchedules($temp);

		$result = array();
		foreach ($tuples as $t) 
		{
			if ($this->findElemtInArray($t, $nContinuos) == false)
			{
				array_push($result, $t);
			}
		}		
		$merge = array_merge($result, $nContinuos);
		return $merge;
	}


	/***************************************************************************
	*Function that returns a list of available schedules according with the    *
	* valid schedules of TEC                                                   *
	*Input:          							                               *
	*	-$pList: List of all schedules to filter.                              *
	*Output: 									                               *
	*	-Returns an array with available schedules             . 		       *
	***************************************************************************/
	private function deleteInvalidSchedules($pList)
	{
		$result = array();
		foreach ($pList as $schedule)
		{
			if(!((($schedule[0] <= 30) && ($schedule[1] > 30)) ||
				(($schedule[2] <= 30)  && ($schedule[3] > 30))))
			{
				array_push($result, $schedule);
			}
		}
		return $result;
	}


	/***************************************************************************
	*Function that returns a list of available schedules of professor. 		   *
	*Input:          							                               *
	*	-$scheduleProfessor: List of all available schedules of professor.     *
	*   -$schedulesToDelete: List of schedules to delete.                      *
	*Output: 									                               *
	*	-Returns an array with available schedules of professor. 		       *
	***************************************************************************/
	public function deleteSchedulesToList($schedules, $schedulesToDelete)
	{
		foreach ($schedulesToDelete as $schedule) 
		{
			$schedules = array_diff($schedules, array($schedule));
		}
		return $schedules;
	}


	/***************************************************************************
	*Function that returns a list of available schedules of professor. 		   *
	*Input:          							                               *
	*	-$scheduleProfessor: List of all available schedules of professor.     *
	*   -$schedulesToAdd: List of schedules to add.                            *
	*Output: 									                               *
	*	-Returns an array with available schedules of professor. 		       *
	***************************************************************************/
	public function addSchedulesToList($schedules, $schedulesToAdd)
	{
		if(!count($schedulesToAdd))
		{
			return $schedules;
		}
		foreach ($schedulesToAdd as $schedule) 
		{
			if(!array_search($schedule, $schedules))
			{
				array_push($schedules, $schedule);
			}
		}
		return $schedules;
	}























	/* JASON  */
	public function getTotalActiveBlocks($idPlan)
	{
		$blockDAO = new BlockDAO_model();
		return $blockDAO->getTotalActiveBlocks($idPlan);
	}


	public function createClasses($data)
	{
		$classList = array();
		//print_r(count($data));
		//print_r($data);

		for($i = 0; $i < count($data); $i++)
		{
			$professor = $data[$i]['idProfessor'];
			$course = $data[$i]['idCourse'];
			$group = $data[$i]['idGroup'];
			$newClass = new AssignedCourse();
			$newClass->setAtributes($professor, $course, $group);
			array_push($classList, $newClass);
		}

		return $classList;
	}

	
	/* ###### */

}

?>
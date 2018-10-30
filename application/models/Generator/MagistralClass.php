<?php

class MagistralClass
{
	private $professor;
    private $course;
	private $group;
	private $assignedSchedules;

	private $countOfAvailableSpaces = 0;
	private $countOfRejectedSpaces  = 0;
	private $evaluation = 0; // This is calculed baed in the schedules 

	function __construct(){}


	public function getCountOfRejectedSpaces(){
		return $this->countOfRejectedSpaces;
	}

	public function getCountOfAvailableSpaces(){
		return $this->countOfAvailableSpaces;
	}

	public function addAvailableCount()
	{
		$this->countOfAvailableSpaces += 1;
	}
	
	public function addRejectedCount() 
	{
		$this->countOfRejectedSpaces += 1;
	}

	public function setEvaluation($pEvaluatio)
	{
		$this->evaluation = $pEvaluatio;
	}

	public function setProfessor($pProfessor)
	{
		$this->professor = $pProfessor;
	}

	public function setCourse($pCourse)
	{
		$this->course = $pCourse;
	}

	public function setGroup($pGroup)
	{
		$this->group = $pGroup;
	}

	public function setAssignedSchedules($pAssignedSchedules)
	{
		$this->assignedSchedules = $pAssignedSchedules;
		$valx = $pAssignedSchedules[1] - $pAssignedSchedules[0];
		$valy = $pAssignedSchedules[3] - $pAssignedSchedules[2];
		$valz = ($pAssignedSchedules[1] + 6) - $pAssignedSchedules[2];
		if (($valx == $valy) && ($valz != 0)) 
		{
			$this->evaluation = 10;
		}
		else{
			$this->evaluation = 5;
		}	
	}

	public function getProfessor()
	{
		return $this->professor;
    }
    
	public function getCourse()
	{
		return $this->course;
    }
    
	public function getGroup()
	{
		return $this->group;
    }
    
	public function getAssignedSchedules()
	{
		return $this->assignedSchedules;
	}

	public function getEvaluation()
	{
		return $this->evaluation;
	}
}

?>
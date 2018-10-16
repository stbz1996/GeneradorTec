<?php

class MagistralClass
{
	private $professor;
    private $course;
	private $group;
	private $assignedSchedules;

	function __construct($pProfessor, $pCourse, $pGroup, $pAssignedSchedules)
	{
        $this->professor = $pProfessor;
        $this->course = $pCourse;
        $this->group = $pGroup;
        $this->assignedSchedules = $pAssignedSchedules;
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
}

?>
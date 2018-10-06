<?php

class Professor
{
	private $workload;
	private $name;
    private $activities;
    private $courses;
    private $schedules;

	function __construct($pWorkload, $pName, $pActivities, $pCourses, $pSchedules)
	{
        $this->workload = $pWorkload;
        $this->name = $pName;
        $this->activities = $pActivities;
        $this->courses = $pCourses;
        $this->schedules = $pSchedules;
	}

	public function setWorkload($pWorkload)
	{
		$this->workload = $pWorkload;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function setActivities($pActivities)
	{
		$this->activities = $pActivities;
	}

	public function setCourses($pCourses)
	{
		$this->courses = $pCourses;
	}

	public function setSchedules($pSchedules)
	{
		$this->schedules = $pSchedules;
	}

	public function getWorkload()
	{
		return $this->workLoad;
    }
    
	public function getName()
	{
		return $this->name;
    }
    
	public function getActivities()
	{
		return $this->activities;
    }
    
	public function getCourses()
	{
		return $this->courses;
    }
    
	public function getSchedules()
	{
		return $this->schedules;
	}
}

?>
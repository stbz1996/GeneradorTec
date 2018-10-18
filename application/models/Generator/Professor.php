<?php

class Professor
{
	private $id;
	private $workload;
	private $name;
    private $activities; // It is a list
    private $courses;    // It is a list
    private $schedules;  // It is a list

	function __construct()
	{}


	/**********************************
	Setters 
	**********************************/
	public function setId($pId)
	{
		$this->id = $pId;
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


	/**********************************
	Getters
	**********************************/
	public function getId()
	{
		return $this->id;
	}

	public function getWorkload()
	{
		return $this->workload;
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
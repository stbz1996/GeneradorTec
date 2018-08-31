<?php

class Course{
	/****************************************
	Variables
	****************************************/
	private $idCourse;
	private $code;
	private $name;
	private $state;
	private $isCareer;
	private $groups;
	private $lessonNumber;
	private $idBlock;

	function __construct()
	{
		$this->idCourse = 0;
		$this->code = "";
		$this->name = "";
		$this->state = false;
		$this->isCareer = false;
		$this->groups = 0;
		$this->lessonNumber = 0;
		$this->idBlock = 0;
	}

	/* Setters and Getters */

	public function setIdCourse($pIdCourse)
	{
		$this->idCourse = $pIdCourse;
	}

	public function setCode($pCode)
	{
		$this->code = $pCode;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function changeState(){
		if ($this->state)
		{
			$this->state = false;
		}else{
			$this->state = true;
		}
	}

	public function changeIsCareer()
	{
		if ($this->isCareer)
		{
			$this->isCareer = false;
		}else{
			$this->isCareer = true;
		}
	}

	public function setGroups($pGroups)
	{
		$this->groups = $pGroups;
	}

	public function setLessonNumber($pLessonNumber)
	{
		$this->lessonNumber = $pLessonNumber;
	}

	public function setIdBlock($pIdBlock)
	{
		$this->idBlock = $pIdBlock;
	}

	public function getId()
	{
		return $this->idCourse;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getIsCareer()
	{
		return $this->isCareer;
	}

	public function getGroups()
	{
		return $this->groups;
	}

	public function getLessonNumber()
	{
		return $this->lessonNumber;
	}

	public function getIdBlock()
	{
		return $this->idBlock;
	}

	/* Finish the setters and getters */
}

?>
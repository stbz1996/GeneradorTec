<?php

class CareerDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idCareer;
	private $name;
	private $lessonDuration;
	private $advanceDays;

	function __construct()
	{
		$this->idCareer = 0;
		$this->name = "";
		$this->lessonDuration = 0;
		$this->advanceDays = 0;
	}

	/* Setters and Getters */

	public function setIdCareer($pIdCareer)
	{
		$this->idCareer = $pIdCareer;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function setLessonDuration($pLessonDuration)
	{
		$this->lessonDuration = $pLessonDuration;
	}

	public function setAdvanceDays($pAdvanceDays)
	{
		$this->advanceDays = $pAdvanceDays;
	}

	public function getId()
	{
		return $this->idCareer;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLessonDuration()
	{
		return $this->lessonDuration;
	}

	public function getAdvanceDays()
	{
		return $this->advanceDays;
	}

	/* Finish the setters and getters */


}

?>
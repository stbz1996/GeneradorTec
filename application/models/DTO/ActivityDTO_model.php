<?php

class ActivityDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idActivity;
	private $description;
	private $idForm;
	private $workPorcent;

	function __construct()
	{
		$this->idActivity = 0;
		$this->description = "";
		$this->workPorcent = 0;
		$this->idForm = 0;
	}

	/* Setters and Getters */

	public function setIdActivity($pIdActivity)
	{
		$this->idActivity = $pIdActivity;
	}

	public function setDescription($pDescription)
	{
		$this->description = $pDescription;
	}

	public function setWorkPorcent($pWorkPorcent)
	{
		$this->workPorcent = $pWorkPorcent;
	}

	public function setIdForm($pIdForm)
	{
		$this->idForm = $pIdForm;
	}

	public function getId()
	{
		return $this->idActivity;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getWorkPorcent()
	{
		return $this->workPorcent;
	}

	public function getIdForm()
	{
		return $this->idForm;
	}

	/* Finish the setters and getters */
}

?>